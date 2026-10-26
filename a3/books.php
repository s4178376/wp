<?php
require_once __DIR__ . '/includes/bootstrap.inc';
$pageTitle = 'BookVerse | Browse Books';
$activePage = 'books.php';
$books = [];
$statuses = [];
if ($connection !== null) {
    try {
        $books = select_books($connection, 'SELECT b.*, u.username AS seller_name FROM books b LEFT JOIN users u ON u.user_id = b.user_id ORDER BY b.title, b.book_id');
        $statuses = select_books($connection, 'SELECT DISTINCT status FROM books ORDER BY status');
    } catch (Throwable $exception) {
        $dbError = report_query_failure($exception);
    }
}
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>All Books</h1>
  <?php if ($dbError): ?>
    <p class="alert alert-danger" role="alert"><?= e($dbError) ?></p>
  <?php else: ?>
    <div class="content-panel filter-panel rounded">
      <label for="status-filter" class="form-label">Filter by status</label>
      <select class="form-select" id="status-filter">
        <option value="all">Show All</option>
        <?php foreach ($statuses as $item): ?>
          <option value="<?= e($item['status']) ?>"><?= e($item['status']) ?></option>
        <?php endforeach; ?>
      </select>
      <p id="filter-status" class="visually-hidden" role="status" aria-live="polite"></p>
    </div>
    <div class="table-responsive content-panel rounded">
      <table class="table books-table align-middle">
        <caption class="visually-hidden">BookVerse catalogue</caption>
        <thead><tr><th scope="col">Title</th><th scope="col">Author</th><th scope="col">Genre</th>
          <th scope="col">Year</th><th scope="col">Price</th><th scope="col">Status</th><th scope="col">Seller</th></tr></thead>
        <tbody id="book-table-body">
          <?php foreach ($books as $book): ?>
            <tr data-status="<?= e($book['status']) ?>">
              <td><a href="details.php?id=<?= e($book['book_id']) ?>"><?= e($book['title']) ?></a></td>
              <td><?= e($book['author']) ?></td><td><?= e($book['genre']) ?></td>
              <td><?= e($book['publication_year']) ?></td>
              <td>$<?= e(number_format((float) $book['price'], 2)) ?></td>
              <td><span class="badge <?= e(badge_class($book['status'])) ?>"><?= e($book['status']) ?></span></td>
              <td><?php if ($book['user_id'] !== null): ?><a href="seller.php?id=<?= e($book['user_id']) ?>"><?= e($book['seller_name']) ?></a><?php else: ?>No current seller<?php endif; ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$books): ?><tr><td colspan="7">No books have been added.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
