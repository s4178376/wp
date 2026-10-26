<?php
// Keep A3 authentication separate from the A2 session on the same host.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('bookverse_a3');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
    ]);
    session_start();
}
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

function current_user_id() { return (int) ($_SESSION['user_id'] ?? 0); }
function is_logged_in() { return current_user_id() > 0; }
function is_owner($book) {
    return is_logged_in() && (int) ($book['user_id'] ?? 0) === current_user_id();
}
function flash($message, $type = 'info') {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}
function redirect_to($page) {
    // Call only with application-controlled relative destinations.
    header('Location: ' . $page, true, 303);
    exit;
}
function require_login() {
    if (!is_logged_in()) {
        flash('Please log in to manage books.', 'warning');
        redirect_to('login.php');
    }
}
function require_post_token() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Allow: POST');
        show_error(405, 'Please use the form to perform this action.');
    }
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
        show_error(403, 'The form expired. Go back, refresh the page and try again.');
    }
}
