<?php
/*
 * Automatic local/Coreteaching selection.
 * Local defaults match an unchanged XAMPP installation.
 * Override settings with environment variables or config.private.php.
 * Never commit the private file. Do not use your RMIT login password.
 */
$serverName = strtolower($_SERVER['SERVER_NAME'] ?? '');
$isLocal = in_array($serverName, ['localhost', '127.0.0.1', '::1'], true);
error_reporting(E_ALL);
ini_set('display_errors', $isLocal ? '1' : '0');
ini_set('log_errors', '1');

$settings = [
    'local' => ['host' => '127.0.0.1', 'port' => 3306, 'user' => 'root',
                'password' => '', 'database' => 'bookverse'],
    'live' => ['host' => 'talsprddb02.int.its.rmit.edu.au', 'port' => 3306,
               'user' => '', 'password' => '', 'database' => '']
];
// A PHP file returns an array; it prints no credentials to the response.
if (is_file(__DIR__ . '/config.private.php')) {
    $overrides = require __DIR__ . '/config.private.php';
    if (is_array($overrides)) {
        $settings = array_replace_recursive($settings, $overrides);
    }
}
$environment = $isLocal ? 'local' : 'live';
$config = $settings[$environment];
$prefix = $isLocal ? 'BOOKVERSE_LOCAL_DB_' : 'BOOKVERSE_LIVE_DB_';
foreach (['host', 'user', 'password', 'database', 'port'] as $key) {
    $value = getenv($prefix . strtoupper($key));
    if ($value !== false) $config[$key] = $value;
}
$connection = null;
$dbError = null;
try {
    if (!extension_loaded('mysqli')) {
        throw new RuntimeException('Enable the MySQLi PHP extension.');
    }
    if ($config['host'] === '' || $config['user'] === '' || $config['database'] === '' ||
        (!$isLocal && $config['password'] === '')) {
        throw new RuntimeException('Set the exact SDAMDS username, database name and database password in config.private.php.');
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_connect($config['host'], $config['user'],
        $config['password'], $config['database'], (int) $config['port']);
    mysqli_set_charset($connection, 'utf8mb4');
} catch (Throwable $exception) {
    // Charset setup can fail after connecting: never let a page use that connection.
    if ($connection !== null && $connection !== false) mysqli_close($connection);
    $connection = null;
    error_log('BookVerse connection failed: ' . $exception->getMessage());
    http_response_code(503);
    // Pages escape this text with e() before displaying it.
    $dbError = $isLocal
        ? 'Local database connection failed. Check that XAMPP MySQL is running and bookverse exists. ' . $exception->getMessage()
        : 'The database is temporarily unavailable. Please try again later.';
}
unset($config, $settings, $overrides, $value);
