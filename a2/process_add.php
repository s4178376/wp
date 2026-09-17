<?php
/*
 * Safe starter endpoint: it does not move files or insert records.
 * Later: check request method, validate all fields and image contents/size,
 * generate a unique filename, move the upload and execute a prepared INSERT.
 * Remove an uploaded file if insertion fails; redirect after successful saving.
 */
http_response_code(501);
header('Cache-Control: no-store');
$pageTitle = 'BookVerse | Saving Not Implemented';
$activePage = '';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>Saving is not implemented yet</h1>
  <p>This starter has not saved a record or stored an uploaded image.</p>
  <a href="add.php" class="btn btn-bookverse">Return to Add Book</a>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>

