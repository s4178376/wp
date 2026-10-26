<?php
require __DIR__ . '/includes/bootstrap.inc';
require_login();
require_post_token();
// TODO: validate book fields and verify the uploaded file's size, extension and MIME.
// TODO: save under a random filename and INSERT using procedural prepared statements.
// Take user_id from current_user_id(), never from a submitted hidden owner field.
// TODO: remove the new file if INSERT fails; flash success and redirect on success.
flash('Adding books is not connected yet. No record or image was saved.', 'info');
redirect_to('add.php');
