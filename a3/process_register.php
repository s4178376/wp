<?php
require __DIR__ . '/includes/bootstrap.inc';
require_post_token();
// TODO: validate username, email, password confirmation, phone, location and bio.
// TODO: check uniqueness with prepared SELECTs; handle duplicate INSERT errors.
// TODO: hash with password_hash($password, PASSWORD_BCRYPT): schema is CHAR(60).
// TODO: prepared INSERT into users, regenerate session ID and automatically log in.
// Never preserve passwords in a session or echo them back into the form.
flash('Registration is not connected yet. No account was created.', 'info');
redirect_to('register.php');
