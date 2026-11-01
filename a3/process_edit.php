<?php
/*
 * Edit handler: validate input and optionally replace a cover under a generated filename.
 * A row lock protects the ownership recheck and update; old-image cleanup follows commit.
 */
require __DIR__ . '/includes/bootstrap.inc';
require_login();
// PHP can discard the whole form, including the token and book ID, for oversized POSTs.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES)) {
    flash('No form data was received. The upload may exceed the server limit. Open your book again and choose a smaller image.', 'danger');
    redirect_to('books.php');
}
require_post_token();
$book = owned_book($_POST['book_id'] ?? null);
require_once __DIR__ . '/includes/book_validation.inc';
$id = (int) $book['book_id'];
$owner = current_user_id();
[$values, $errors] = validate_book_fields($_POST);
$_SESSION['edit_book_values'] = ['book_id' => $id, 'user_id' => $owner, 'values' => $values];

// No file means keep the cover. Any other upload error must be reported.
$file = $_FILES['image_path'] ?? null;
$replaceCover = $file !== null && !(is_array($file) && ($file['error'] ?? null) === UPLOAD_ERR_NO_FILE);
if ($replaceCover) {
    try {
        [$temporary, $extension] = validate_book_cover($file);
    } catch (InvalidArgumentException $error) {
        $errors[] = $error->getMessage();
    } catch (Throwable $error) {
        error_log('BookVerse replacement cover inspection failed; code ' . $error->getCode());
        $errors[] = 'Cover inspection is temporarily unavailable. Please try again later.';
    }
}
if ($errors) {
    flash(implode(' ', $errors) . ' Your text has been kept. Select any replacement cover again.', 'danger');
    redirect_to('edit.php?id=' . $id);
}

$newPath = null;
$newFilename = null;
$inTransaction = false;
$commitAttempted = false;
try {
    if ($replaceCover) {
        $directory = __DIR__ . '/assets/images/covers';
        if (!is_dir($directory) || !is_writable($directory)) {
            throw new RuntimeException('Cover directory is not writable.');
        }
        $newFilename = bin2hex(random_bytes(16)) . '.' . $extension;
        $newPath = $directory . '/' . $newFilename;
        if (!move_uploaded_file($temporary, $newPath)) throw new RuntimeException('Unable to save replacement cover.');
        if (!chmod($newPath, 0644)) throw new RuntimeException('Unable to set cover permissions.');
    }

    mysqli_begin_transaction($connection);
    $inTransaction = true;
    // Lock and recheck the row: another request might have changed it since the initial check.
    $rows = select_books($connection,
        'SELECT user_id, image_path FROM books WHERE book_id = ? FOR UPDATE', 'i', [$id]);
    if (!$rows || (int) $rows[0]['user_id'] !== $owner) {
        throw new RuntimeException('The book is no longer available to this owner.');
    }
    $oldFilename = (string) ($rows[0]['image_path'] ?? '');
    $image = $replaceCover ? $newFilename : $rows[0]['image_path'];
    $year = (int) $values['publication_year'];
    $statement = mysqli_prepare($connection,
        'UPDATE books SET title = ?, author = ?, genre = ?, publication_year = ?, isbn = ?,
         description = ?, book_condition = ?, price = ?, image_path = ?, status = ?
         WHERE book_id = ? AND user_id = ?');
    try {
        // Keep DECIMAL price as validated text. The owner is taken only from the session.
        mysqli_stmt_bind_param($statement, 'sssissssssii', $values['title'], $values['author'],
            $values['genre'], $year, $values['isbn'], $values['description'],
            $values['book_condition'], $values['price'], $image, $values['status'], $id, $owner);
        mysqli_stmt_execute($statement);
        // Zero affected rows is valid when Save Changes submits unchanged values.
    } finally {
        mysqli_stmt_close($statement);
    }
    $commitAttempted = true;
    mysqli_commit($connection);
    $inTransaction = false;
} catch (Throwable $error) {
    if ($inTransaction) {
        try { mysqli_rollback($connection); }
        catch (Throwable $rollbackError) { error_log('BookVerse edit rollback could not be confirmed.'); }
    }
    // After a connection loss during COMMIT, its outcome can be unknown. Preserve both
    // images in that case rather than risk deleting a cover the database now references.
    if (!$commitAttempted && $newPath !== null && is_file($newPath) && !unlink($newPath)) {
        error_log('BookVerse could not remove an unsaved replacement cover: ' . basename($newPath));
    }
    error_log('BookVerse edit failed; code ' . $error->getCode());
    $message = $commitAttempted
        ? 'The save result could not be confirmed. Check the book details before trying again.'
        : 'The book could not be updated. Check database access and cover-folder permissions.';
    flash($message . ' Your text has been kept. Select any replacement cover again.', 'danger');
    redirect_to('edit.php?id=' . $id);
}

// Remove the previous cover only after the update commits and if no book still uses it.
// Restrict cleanup to plain image filenames in the cover directory; never follow symlinks.
$cleanupFailed = false;
if ($replaceCover && $oldFilename !== '' && $oldFilename !== $newFilename &&
    preg_match('/\A[A-Za-z0-9_-]+\.(?:jpe?g|png|gif|webp)\z/i', $oldFilename)) {
    try {
        $references = select_books($connection,
            'SELECT book_id FROM books WHERE image_path = ? LIMIT 1', 's', [$oldFilename]);
        $oldPath = __DIR__ . '/assets/images/covers/' . $oldFilename;
        if (!$references && !is_link($oldPath) && is_file($oldPath) && !unlink($oldPath)) {
            throw new RuntimeException('Unable to remove the previous cover.');
        }
    } catch (Throwable $error) {
        // Cleanup failure must not turn a successful database update into a false failure.
        $cleanupFailed = true;
        error_log('BookVerse previous-cover cleanup failed; code ' . $error->getCode());
    }
}
unset($_SESSION['edit_book_values']);
flash($cleanupFailed
    ? 'Your book was updated, but the unused previous cover could not be cleaned up.'
    : 'Your book has been updated.', $cleanupFailed ? 'warning' : 'success');
redirect_to('details.php?id=' . $id);
