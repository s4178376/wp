<?php
/*
 * Protected Add Book page: restore previous safe text values once after an error.
 * The shared form posts a multipart request so PHP receives both fields and an image.
 */
require __DIR__ . '/includes/bootstrap.inc';
require_login();
$pageTitle = 'BookVerse | Add Book';
$activePage = 'add.php';
$old = $_SESSION['add_book_values'] ?? [];
unset($_SESSION['add_book_values']);
$isEdit = false;
$formAction = 'process_add.php';
// Queries, authentication and redirects run before the shared header prints HTML.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<!-- Main landmark: page-specific content follows the shared navigation. -->
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Add New Book</h1>
    <p>Add a book to your collection with a cover image. Your account will be listed as the seller.</p>
    <?php require __DIR__ . '/includes/book_form.inc'; ?>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
