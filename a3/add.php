<?php
require __DIR__ . '/includes/bootstrap.inc';
require_login();
$pageTitle = 'BookVerse | Add Book';
$activePage = 'add.php';
$old = [];
$isEdit = false;
$formAction = 'process_add.php';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Add New Book</h1>
    <p>Saving books and uploading covers will be connected in the next development step.</p>
    <?php require __DIR__ . '/includes/book_form.inc'; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
