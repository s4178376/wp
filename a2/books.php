<?php
$pageTitle = 'BookVerse | Browse Books';
$activePage = 'books.php';
// __DIR__ resolves includes relative to this file, not the terminal directory.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>All Books</h1>
  <p class="starter-note">Starter: database rows and status choices are not connected yet.</p>
  <div class="content-panel filter-panel rounded">
    <label for="status-filter" class="form-label">Filter by status</label>
    <select class="form-select" id="status-filter">
      <option value="all">Show All</option>
      <!-- Later: generate other options from database status values. -->
    </select>
  </div>
  <div class="table-responsive content-panel rounded">
    <table class="table books-table">
      <caption class="visually-hidden">BookVerse catalogue</caption>
      <thead><tr>
        <th scope="col">Title</th><th scope="col">Author</th>
        <th scope="col">Genre</th><th scope="col">Year</th>
        <th scope="col">Price</th><th scope="col">Status</th>
      </tr></thead>
      <tbody id="book-table-body">
        <!-- Later: each database row needs data-status and a details.php?id=... link. -->
        <tr><td colspan="6">Database connection will be added in the next stage.</td></tr>
      </tbody>
    </table>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>

