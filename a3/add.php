<?php
require __DIR__ . '/includes/bootstrap.inc';
require_login();
$pageTitle = 'BookVerse | Add Book';
$activePage = 'add.php';
$old = $_SESSION['add_book_values'] ?? [];
unset($_SESSION['add_book_values']);
$isEdit = false;
$formAction = 'process_add.php';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Add New Book</h1>
    <p>Add a book to your collection with a cover image. Your account will be listed as the seller.</p>
    <?php require __DIR__ . '/includes/book_form.inc'; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
