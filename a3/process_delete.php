<?php
require __DIR__ . '/includes/bootstrap.inc';
require_login();
require_post_token();
$book = owned_book($_POST['book_id'] ?? null);
// TODO: DELETE FROM books WHERE book_id = ? AND user_id = ? (prepared statement).
// TODO: remove the associated cover safely; do not accept a file path from POST.
// Handle filesystem failure explicitly and preserve any image referenced elsewhere.
flash('Deletion is not connected yet. Your book was not deleted.', 'info');
redirect_to('details.php?id=' . (int) $book['book_id']);
