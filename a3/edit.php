<?php
require __DIR__ . '/includes/bootstrap.inc';
$book = owned_book($_GET['id'] ?? null);
$old = $book;
$isEdit = true;
$formAction = 'process_edit.php';
$pageTitle = 'BookVerse | Edit: ' . $book['title'];
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Edit Book</h1>
    <p>Editing is not connected yet. This form loads your current book details.</p>
    <?php require __DIR__ . '/includes/book_form.inc'; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
