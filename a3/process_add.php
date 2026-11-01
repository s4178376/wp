<?php
/*
 * Add handler: validate text and real uploaded image bytes before inserting a book.
 * Use the authenticated session for ownership, and remove a new cover if insertion fails.
 */
require __DIR__ . '/includes/bootstrap.inc';
require_login();
// PHP discards POST and FILES when post_max_size is exceeded, including the token.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES)) {
    flash('No form data was received. The upload may exceed the server limit. Choose a smaller image and try again.', 'danger');
    redirect_to('add.php');
}
require_post_token();
require_once __DIR__ . '/includes/book_validation.inc';
[$values, $errors] = validate_book_fields($_POST);
$_SESSION['add_book_values'] = $values;

try {
    [$temporary, $extension] = validate_book_cover($_FILES['image_path'] ?? null);
} catch (InvalidArgumentException $error) {
    $errors[] = $error->getMessage();
} catch (Throwable $error) {
    error_log('BookVerse cover inspection failed; code ' . $error->getCode());
    $errors[] = 'Cover inspection is temporarily unavailable. Please try again later.';
}
if ($errors) {
    flash(implode(' ', $errors) . ' Your text has been kept. Please select the cover again.', 'danger');
    redirect_to('add.php');
}
if ($connection === null) {
    flash('The database is unavailable. Your text has been kept. Please try again and select the cover again.', 'danger');
    redirect_to('add.php');
}

$destination = null;
$saved = false;
try {
    $directory = __DIR__ . '/assets/images/covers';
    if (!is_dir($directory) || !is_writable($directory)) {
        throw new RuntimeException('Cover directory is not writable.');
    }
    // The client never controls a path or the owner ID stored in the database.
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $directory . '/' . $filename;
    if (!move_uploaded_file($temporary, $destination)) {
        throw new RuntimeException('Unable to save cover.');
    }
    if (!chmod($destination, 0644)) throw new RuntimeException('Unable to set cover permissions.');
    $owner = current_user_id();
    $year = (int) $values['publication_year'];
    $statement = mysqli_prepare($connection,
        'INSERT INTO books (user_id, title, author, genre, publication_year, isbn, description,
         book_condition, price, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    try {
        // Bind DECIMAL price as a validated string to preserve its decimal value.
        mysqli_stmt_bind_param($statement, 'isssissssss', $owner, $values['title'],
            $values['author'], $values['genre'], $year, $values['isbn'],
            $values['description'], $values['book_condition'], $values['price'],
            $filename, $values['status']);
        mysqli_stmt_execute($statement);
        $bookId = (int) mysqli_insert_id($connection);
        $saved = true;
    } finally {
        mysqli_stmt_close($statement);
    }
} catch (Throwable $error) {
    // Compensate for a failed INSERT so it does not leave an unused cover behind.
    if (!$saved && $destination !== null && is_file($destination) && !unlink($destination)) {
        error_log('BookVerse could not remove an unsaved cover: ' . basename($destination));
    }
    error_log('BookVerse add failed; code ' . $error->getCode());
    flash('The book could not be saved. Check the database and cover-folder permissions. Your text has been kept; please select the cover again.', 'danger');
    redirect_to('add.php');
}
unset($_SESSION['add_book_values']);
flash('Your book has been added to the collection.', 'success');
redirect_to('details.php?id=' . $bookId);
