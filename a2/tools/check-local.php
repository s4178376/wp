<?php
/* Run from Terminal with XAMPP PHP. This performs only reads, never INSERT/DELETE.
 * Keep this tool out of browser use; it reports local setup details.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
$failures = 0;
function check_result($ok, $message) {
    global $failures;
    echo ($ok ? 'PASS: ' : 'FAIL: ') . $message . PHP_EOL;
    if (!$ok) $failures++;
}
foreach (['mysqli', 'fileinfo', 'session'] as $extension) {
    check_result(extension_loaded($extension), 'PHP extension ' . $extension);
}
check_result(function_exists('mysqli_stmt_get_result'), 'MySQL native driver for prepared SELECT results');
echo 'CLI php.ini: ' . (php_ini_loaded_file() ?: 'none') . PHP_EOL;
echo 'CLI upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;
echo 'CLI post_max_size: ' . ini_get('post_max_size') . PHP_EOL;
echo 'Apache may use different settings. Verify uploads in the browser.' . PHP_EOL;

// CLI has no request hostname, so deliberately select the local configuration.
$_SERVER['SERVER_NAME'] = 'localhost';
require __DIR__ . '/../includes/functions.inc';
require __DIR__ . '/../includes/db_connect.inc';
check_result($connection !== null, 'Local database connection');
if ($connection !== null) {
    try {
        $rows = select_books($connection, 'SELECT book_id, title, author, genre,
            publication_year, isbn, description, book_condition, price,
            image_path, status, created_at FROM books ORDER BY book_id');
        check_result(true, 'Prepared SELECT with every required schema column');
        echo count($rows) . ' books currently stored.' . PHP_EOL;
        $missing = 0;
        foreach ($rows as $row) {
            if (cover_url($row['image_path']) === 'assets/images/favicon.svg') $missing++;
        }
        check_result($missing === 0, 'Cover files present for all records (' . $missing . ' missing)');
        $latest = select_books($connection, 'SELECT book_id FROM books ORDER BY created_at DESC, book_id DESC LIMIT 4');
        check_result(count($latest) === min(4, count($rows)), 'Latest-books query');
        if ($rows) {
            $found = select_books($connection, 'SELECT title FROM books WHERE book_id = ?', 'i', [(int) $rows[0]['book_id']]);
            check_result(count($found) === 1 && $found[0]['title'] === $rows[0]['title'], 'Bound integer details query');
        }
    } catch (Throwable $exception) {
        check_result(false, 'Schema/query check: ' . $exception->getMessage());
    }
    mysqli_close($connection);
}
check_result(is_dir(__DIR__ . '/../assets/images/covers'), 'Upload directory exists');
echo 'Directory writability under this Terminal user does not prove Apache can upload.' . PHP_EOL;
echo PHP_EOL . ($failures ? "$failures check(s) failed." : 'Read-only checks passed. Browser upload and live deployment checks remain.') . PHP_EOL;
exit($failures ? 1 : 0);
