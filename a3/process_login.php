<?php
require __DIR__ . '/includes/bootstrap.inc';
require_post_token();
if (is_logged_in()) redirect_to('index.php');
$username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
$password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
if ($username === '' || strlen($username) > 50 || $password === '' || strlen($password) > 4096) {
    flash('Enter your username and password.', 'danger');
    redirect_to('login.php');
}
if ($connection === null) {
    flash('Login is temporarily unavailable.', 'danger');
    redirect_to('login.php');
}
try {
    $rows = select_books($connection, 'SELECT user_id, username, password FROM users WHERE username = ?', 's', [$username]);
    $user = $rows[0] ?? null;
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        flash('You are now logged in.', 'success');
        redirect_to('index.php');
    }
    flash('The username or password is incorrect.', 'danger');
} catch (Throwable $error) {
    error_log('Login failed: ' . $error->getMessage());
    flash('Login is temporarily unavailable.', 'danger');
}
redirect_to('login.php');
