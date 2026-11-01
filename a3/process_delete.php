<?php
/*
 * Delete handler: require POST, CSRF and ownership before deleting a locked book row.
 * File cleanup follows database commit and preserves images still used by another book.
 */
require __DIR__ . '/includes/bootstrap.inc';
require_login();
require_post_token();
$book = owned_book($_POST['book_id'] ?? null);
$id = (int) $book['book_id'];
$owner = current_user_id();
$inTransaction = false;
$commitAttempted = false;

try {
    mysqli_begin_transaction($connection);
    $inTransaction = true;
    // Recheck ownership under a row lock in case another request changed the book.
    $rows = select_books($connection,
        'SELECT user_id, image_path FROM books WHERE book_id = ? FOR UPDATE', 'i', [$id]);
    if (!$rows || (int) $rows[0]['user_id'] !== $owner) {
        throw new RuntimeException('The book is no longer available to this owner.');
    }
    // The filename comes from the database, never from the submitted form.
    $filename = (string) ($rows[0]['image_path'] ?? '');
    $statement = mysqli_prepare($connection,
        'DELETE FROM books WHERE book_id = ? AND user_id = ?');
    try {
        mysqli_stmt_bind_param($statement, 'ii', $id, $owner);
        mysqli_stmt_execute($statement);
        if (mysqli_stmt_affected_rows($statement) !== 1) {
            throw new RuntimeException('No owned book was deleted.');
        }
    } finally {
        mysqli_stmt_close($statement);
    }
    $commitAttempted = true;
    mysqli_commit($connection);
    $inTransaction = false;
} catch (Throwable $error) {
    if ($inTransaction) {
        try { mysqli_rollback($connection); }
        catch (Throwable $rollbackError) { error_log('BookVerse delete rollback could not be confirmed.'); }
    }
    // Leave the cover untouched on failure, including an uncertain COMMIT outcome.
    error_log('BookVerse delete failed; code ' . $error->getCode());
    flash($commitAttempted
        ? 'The deletion result could not be confirmed. Check the catalogue before trying again.'
        : 'The book could not be deleted. Please refresh the catalogue and try again.', 'danger');
    redirect_to('books.php');
}

// The database deletion has committed. Image cleanup is a separate operation:
// a filesystem failure should not incorrectly report that the book still exists.
$cleanupFailed = false;
if ($filename !== '') {
    try {
        if (!preg_match('/\A[A-Za-z0-9_-]+\.(?:jpe?g|png|gif|webp)\z/i', $filename)) {
            throw new RuntimeException('Unsafe cover filename; cleanup skipped.');
        }
        $references = select_books($connection,
            'SELECT book_id FROM books WHERE image_path = ? LIMIT 1', 's', [$filename]);
        if (!$references) {
            $path = __DIR__ . '/assets/images/covers/' . $filename;
            if (is_link($path)) throw new RuntimeException('Cover is a symlink; cleanup skipped.');
            // An already-missing cover needs no cleanup. Shared covers are preserved.
            if (file_exists($path) && (!is_file($path) || !unlink($path))) {
                throw new RuntimeException('Unable to remove the unused cover.');
            }
        }
    } catch (Throwable $error) {
        $cleanupFailed = true;
        error_log('BookVerse deleted-cover cleanup failed; code ' . $error->getCode());
    }
}
if (($_SESSION['edit_book_values']['book_id'] ?? null) === $id) {
    unset($_SESSION['edit_book_values']);
}
flash($cleanupFailed
    ? 'Your book was deleted, but its unused cover could not be removed. Check the server cover folder.'
    : 'Your book has been deleted.', $cleanupFailed ? 'warning' : 'success');
redirect_to('books.php');
