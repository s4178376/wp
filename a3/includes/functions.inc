<?php
// Escape database and user values at the point where they enter HTML.
function e($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Keep image URLs inside the cover directory; use the favicon if a file is absent.
function cover_url($filename) {
    $filename = (string) ($filename ?? '');
    if ($filename === '' || basename($filename) !== $filename ||
        !preg_match('/\.(?:jpe?g|png|gif|webp)$/i', $filename) ||
        !is_file(__DIR__ . '/../assets/images/covers/' . $filename)) {
        return 'assets/images/favicon.svg';
    }
    return 'assets/images/covers/' . rawurlencode($filename);
}
function badge_class($status) {
    $classes = ['Available' => 'badge-available', 'Reserved' => 'badge-reserved', 'Sold' => 'badge-sold'];
    return $classes[$status] ?? 'badge-sold';
}

/*
 * Every SELECT goes through procedural MySQLi prepare/execute.
 * Parameters are bound separately from SQL; no input is concatenated into SQL.
 * mysqli_stmt_get_result requires mysqlnd (provided by typical XAMPP PHP builds).
 */
function select_books($connection, $sql, $types = '', $parameters = []) {
    $statement = mysqli_prepare($connection, $sql);
    try {
        if ($types !== '') {
            mysqli_stmt_bind_param($statement, $types, ...$parameters);
        }
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $rows;
    } finally {
        mysqli_stmt_close($statement);
    }
}
function report_query_failure($exception) {
    error_log('BookVerse query failed: ' . $exception->getMessage());
    http_response_code(503);
    return 'Books are temporarily unavailable. Please try again later.';
}
