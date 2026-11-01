<?php
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
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Edit Book</h1>
    <p>Update your book details. Leave the cover upload empty to keep the current image.</p>
    <?php require __DIR__ . '/includes/book_form.inc'; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
