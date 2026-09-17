<?php
$pageTitle = 'BookVerse | Book Details';
$activePage = '';
// __DIR__ resolves includes relative to this file, not the terminal directory.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>Book Details</h1>
  <p class="starter-note">Starter: a selected book will appear here once database retrieval is implemented.</p>
  <!-- Later: validate $_GET['id'] as a positive integer, then bind it to a
       prepared SELECT. Handle missing, invalid and unknown IDs gracefully.
       Escape all displayed values, including image paths and alternative text. -->
  <a class="btn btn-bookverse" href="books.php">Back to Browse Books</a>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>

