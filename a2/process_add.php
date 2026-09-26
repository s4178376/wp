<?php
require_once __DIR__ . '/includes/session.inc';
require_once __DIR__ . '/includes/functions.inc';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add.php', true, 303);
    exit;
}
// A successful POST redirects: refreshing the details page will not insert again.
$errors = [];
$values = [];
foreach (['title','author','genre','publication_year','isbn','description','book_condition','price','status'] as $field) {
    $values[$field] = is_string($_POST[$field] ?? null) ? trim($_POST[$field]) : '';
}
$token = $_POST['csrf_token'] ?? '';
if (!is_string($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
    $errors[] = 'The form expired or was too large. Please submit it again.';
}
// Apply all validation again on the server; browser validation can be bypassed.
foreach (['title' => 255, 'author' => 255, 'genre' => 100, 'isbn' => 20, 'description' => 10000] as $field => $maximum) {
    $length = function_exists('mb_strlen') ? mb_strlen($values[$field], 'UTF-8') : strlen($values[$field]);
    if ($values[$field] === '' || $length > $maximum) {
        $errors[] = ucfirst($field) . ' is required and must be at most ' . $maximum . ' characters.';
    }
}
$year = filter_var($values['publication_year'], FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1000, 'max_range' => (int) date('Y')]]);
if ($year === false) $errors[] = 'Enter a publication year between 1000 and the current year.';
$isbn = preg_replace('/[ -]/', '', $values['isbn']);
// Validate ISBN shape, not its checksum: the supplied seed data includes example ISBNs.
if (!preg_match('/^(?:[0-9]{9}[0-9Xx]|[0-9]{13})$/D', $isbn)) {
    $errors[] = 'ISBN must contain 10 or 13 characters (digits, with X allowed at the end of ISBN-10).';
}
if (!preg_match('/^[0-9]{1,6}(?:\.[0-9]{1,2})?$/D', $values['price']) ||
    (float) $values['price'] < 0.01 || (float) $values['price'] > 999999.99) {
    $errors[] = 'Enter a price between 0.01 and 999999.99 with up to two decimal places.';
}
if (!in_array($values['book_condition'], ['New','Gently Used','Fair'], true)) $errors[] = 'Choose a valid condition.';
if (!in_array($values['status'], ['Available','Reserved','Sold'], true)) $errors[] = 'Choose a valid status.';

$file = $_FILES['image_path'] ?? null;
$extension = '';
if (!is_array($file) || !is_int($file['error'] ?? null) || $file['error'] !== UPLOAD_ERR_OK) {
    $errors[] = 'Select a cover image. The upload may have exceeded the PHP server limit.';
} elseif (!is_string($file['tmp_name'] ?? null) || !is_uploaded_file($file['tmp_name'])) {
    $errors[] = 'The cover upload could not be verified.';
} else {
    $allowed = ['jpg'=>'image/jpeg', 'jpeg'=>'image/jpeg', 'png'=>'image/png', 'gif'=>'image/gif', 'webp'=>'image/webp'];
    $extension = is_string($file['name'] ?? null) ? strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) : '';
    $size = filesize($file['tmp_name']);
    if ($size === false || $size < 1 || $size > 5 * 1024 * 1024) $errors[] = 'The cover must be no larger than 5 MiB.';
    if (!function_exists('finfo_open')) {
        $errors[] = 'The server needs the Fileinfo extension to verify images.';
    } else {
        $info = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($info, $file['tmp_name']);
        finfo_close($info);
        $dimensions = @getimagesize($file['tmp_name']);
        if (!isset($allowed[$extension]) || $allowed[$extension] !== $mime ||
            !$dimensions || ($dimensions['mime'] ?? '') !== $mime) {
            $errors[] = 'Upload a real JPG, JPEG, PNG, GIF or WEBP image matching its extension.';
        } elseif ($dimensions[0] > 10000 || $dimensions[1] > 10000) {
            $errors[] = 'Cover dimensions must not exceed 10000 pixels on either side.';
        }
    }
}
if ($errors) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_old'] = $values;
    header('Location: add.php', true, 303);
    exit;
}

require __DIR__ . '/includes/db_connect.inc';
$destination = null;
$statement = null;
if ($connection === null) {
    $errors[] = 'The database is unavailable. Your book was not saved.';
} else {
    try {
        $folder = __DIR__ . '/assets/images/covers/';
        if (!is_dir($folder) || !is_writable($folder)) {
            throw new RuntimeException('The covers directory is not writable by PHP.');
        }
        // Random server-generated basename prevents trusting or reusing user filenames.
        $filename = 'cover_' . bin2hex(random_bytes(16)) . '.' . $extension;
        $nextToken = bin2hex(random_bytes(32));
        $destination = $folder . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException('Unable to store the uploaded cover.');
        }
        chmod($destination, 0644);
        $sql = 'INSERT INTO books
            (title, author, genre, publication_year, isbn, description, book_condition, price, image_path, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $statement = mysqli_prepare($connection, $sql);
        // i = integer, s = string. Price stays a decimal string for the DECIMAL column.
        mysqli_stmt_bind_param($statement, 'sssissssss',
            $values['title'], $values['author'], $values['genre'], $year,
            $isbn, $values['description'], $values['book_condition'],
            $values['price'], $filename, $values['status']);
        mysqli_stmt_execute($statement);
        $id = mysqli_insert_id($connection);
        mysqli_stmt_close($statement);
        $statement = null;
        $_SESSION['created_book_id'] = (int) $id;
        $_SESSION['csrf_token'] = $nextToken;
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        header('Location: details.php?id=' . $id, true, 303);
        exit;
    } catch (Throwable $exception) {
        // If insertion fails, remove only the newly created upload.
        if ($statement !== null) mysqli_stmt_close($statement);
        if ($destination !== null && is_file($destination)) unlink($destination);
        error_log('BookVerse add failed: ' . $exception->getMessage());
        $errors[] = 'The book could not be saved. Check the database and upload-folder permissions.';
    }
}
$_SESSION['form_errors'] = $errors;
$_SESSION['form_old'] = $values;
header('Location: add.php', true, 303);
exit;
