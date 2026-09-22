<?php
/*
 * Shared procedural MySQLi connection.
 * Credentials come from the PHP server environment, not committed files.
 * Pages do not include this file yet: setup and testing are deferred.
 */
$serverName = strtolower($_SERVER['SERVER_NAME'] ?? '');
$isLocal = in_array($serverName, ['localhost', '127.0.0.1', '::1'], true);

error_reporting(E_ALL);
ini_set('display_errors', $isLocal ? '1' : '0');
ini_set('log_errors', '1');

// Automatically choose local or university settings.
if ($isLocal) {
    $databaseName = 'bookverse';
    $databaseHost = getenv('BOOKVERSE_LOCAL_DB_HOST');
    $databaseUser = getenv('BOOKVERSE_LOCAL_DB_USER');
    $databasePassword = getenv('BOOKVERSE_LOCAL_DB_PASSWORD');
} else {
    $databaseName = 's4178376';
    // Use the confirmed Jacob 5 hostname, not the Titan website URL.
    $databaseHost = getenv('BOOKVERSE_LIVE_DB_HOST');
    $databaseUser = getenv('BOOKVERSE_LIVE_DB_USER');
    $databasePassword = getenv('BOOKVERSE_LIVE_DB_PASSWORD');
}

// getenv() returns false for missing settings. An empty password may be intentional.
if (
    $databaseHost === false ||
    $databaseHost === '' ||
    $databaseUser === false ||
    $databaseUser === '' ||
    $databasePassword === false
) {
    http_response_code(503);
    exit(
        $isLocal
            ? 'Database settings are missing. Configure the local database environment variables.'
            : 'The database connection is not configured yet.'
    );
}

if (!extension_loaded('mysqli')) {
    http_response_code(503);
    exit(
        $isLocal
            ? 'The MySQLi PHP extension is not enabled.'
            : 'The database service is unavailable.'
    );
}

// Report database failures as exceptions.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = mysqli_connect(
        $databaseHost,
        $databaseUser,
        $databasePassword,
        $databaseName
    );
    mysqli_set_charset($connection, 'utf8mb4');
} catch (mysqli_sql_exception $exception) {
    // Keep technical details out of the live page.
    error_log('BookVerse database connection: ' . $exception->getMessage());
    http_response_code(503);
    if ($isLocal) {
        exit(
            'Database connection failed: ' .
            htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8')
        );
    }
    exit('Unable to connect to the database. Please try again later.');
}
