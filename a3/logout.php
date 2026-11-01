<?php
/*
 * Logout is a CSRF-protected POST action, not a link that changes state on GET.
 * Discard the authenticated session and create an anonymous session for one-time feedback.
 */
require __DIR__ . '/includes/bootstrap.inc';
require_post_token();
// Destroy the authenticated session, then use a fresh anonymous session for feedback.
$_SESSION = [];
session_destroy();
session_id('');
session_start();
session_regenerate_id(true);
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
flash('You have logged out.', 'success');
redirect_to('index.php');
