<?php
/*
 * Protected Edit Book page: load only a book owned by the current user.
 * A retained draft is reused only when both its book ID and user ID match.
 */
require __DIR__ . '/includes/bootstrap.inc';
$book = owned_book($_GET['id'] ?? null);
// Retain failed input only for this book and this signed-in owner.
$draft = $_SESSION['edit_book_values'] ?? null;
unset($_SESSION['edit_book_values']);
$old = is_array($draft) && ($draft['book_id'] ?? null) === (int) $book['book_id'] &&
    ($draft['user_id'] ?? null) === current_user_id()
    ? $draft['values'] : $book;
$isEdit = true;
$formAction = 'process_edit.php';
$pageTitle = 'BookVerse | Edit: ' . $book['title'];
// Queries, authentication and redirects run before the shared header prints HTML.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<!-- Main landmark: page-specific content follows the shared navigation. -->
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Edit Book</h1>
    <p>Update your book details. Leave the cover upload empty to keep the current image.</p>
    <?php require __DIR__ . '/includes/book_form.inc'; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
