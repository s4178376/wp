<?php
// All pages start here, before any HTML or redirects are sent.
require_once __DIR__ . '/functions.inc';
require_once __DIR__ . '/session.inc';
require_once __DIR__ . '/db_connect.inc';

function positive_id($value) {
    return is_string($value) ? filter_var($value, FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]) : false;
}
function show_error($status, $message) {
    http_response_code($status);
    $pageTitle = 'BookVerse | Request Error';
    require __DIR__ . '/header.inc';
    require __DIR__ . '/nav.inc';
    echo '<main class="container page-wrap" id="main-content"><h1>Unable to continue</h1>';
    echo '<p class="alert alert-danger">' . e($message) . '</p>';
    echo '<a href="books.php">Back to books</a></main>';
    require __DIR__ . '/footer.inc';
    exit;
}
function owned_book($rawId) {
    global $connection;
    require_login();
    $id = positive_id($rawId);
    if (!$id) show_error(400, 'Choose a valid book.');
    if ($connection === null) show_error(503, 'The database is unavailable.');
    try {
        $rows = select_books($connection, 'SELECT * FROM books WHERE book_id = ?', 'i', [$id]);
    } catch (Throwable $error) {
        show_error(503, report_query_failure($error));
    }
    if (!$rows) show_error(404, 'Book not found.');
    if (!is_owner($rows[0])) show_error(403, 'Only the owner can change this book.');
    return $rows[0];
}
