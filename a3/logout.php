<?php
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
