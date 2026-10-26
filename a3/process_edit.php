<?php
require __DIR__ . '/includes/bootstrap.inc';
require_login();
require_post_token();
$book = owned_book($_POST['book_id'] ?? null);
// TODO: validate fields and optionally validate/save a replacement cover.
// TODO: UPDATE books ... WHERE book_id = ? AND user_id = ? using bound values.
// Keep the original image when no replacement is uploaded.
// Delete the old image only after a successful update; clean new uploads on failure.
flash('Editing is not connected yet. Your book was not changed.', 'info');
redirect_to('edit.php?id=' . (int) $book['book_id']);
