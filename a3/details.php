<?php
require __DIR__ . '/includes/bootstrap.inc';
$id = positive_id($_GET['id'] ?? null);
if (!$id) show_error(400, 'Choose a valid book.');
if ($connection === null) show_error(503, 'The database is unavailable.');
try {
    $rows = select_books($connection, 'SELECT b.*, u.username AS seller_name
        FROM books b LEFT JOIN users u ON u.user_id = b.user_id WHERE b.book_id = ?', 'i', [$id]);
} catch (Throwable $error) { show_error(503, report_query_failure($error)); }
if (!$rows) show_error(404, 'Book not found.');
$book = $rows[0];
$pageTitle = 'BookVerse | ' . $book['title'];
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <article class="row g-4">
    <div class="col-md-4"><img class="img-fluid rounded detail-cover" src="<?= e(cover_url($book['image_path'])) ?>" alt="<?= e($book['title']) ?> cover"></div>
    <div class="col-md-8">
      <h1><?= e($book['title']) ?></h1>
      <p class="lead">By <?= e($book['author']) ?></p>
      <dl>
        <dt>Genre</dt><dd><?= e($book['genre']) ?></dd>
        <dt>Publication year</dt><dd><?= e($book['publication_year']) ?></dd>
        <dt>ISBN</dt><dd><?= e($book['isbn']) ?></dd>
        <dt>Condition</dt><dd><?= e($book['book_condition']) ?></dd>
        <dt>Price</dt><dd>$<?= e(number_format((float) $book['price'], 2)) ?></dd>
        <dt>Status</dt><dd><span class="badge <?= e(badge_class($book['status'])) ?>"><?= e($book['status']) ?></span></dd>
        <dt>Seller</dt><dd><?php if ($book['user_id'] !== null): ?><a href="seller.php?id=<?= e($book['user_id']) ?>"><?= e($book['seller_name']) ?></a><?php else: ?>No current seller<?php endif; ?></dd>
      </dl>
      <h2>Description</h2><p class="book-description"><?= e($book['description']) ?></p>
      <?php if (is_owner($book)): ?>
        <a class="btn btn-bookverse" href="edit.php?id=<?= e($book['book_id']) ?>">Edit Book</a>
        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete Book</button>
      <?php endif; ?>
    </div>
  </article>
  <a class="btn btn-bookverse mt-4" href="books.php">Back to Browse Books</a>
</main>
<?php if (is_owner($book)): ?>
  <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content content-panel">
      <div class="modal-header"><h2 class="modal-title fs-5" id="delete-title">Delete book?</h2><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body"><p>Delete “<?= e($book['title']) ?>” and its cover?</p><p class="mb-0">Deletion is not enabled in this starter.</p></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
        <form action="process_delete.php" method="post">
          <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
          <input type="hidden" name="book_id" value="<?= e($book['book_id']) ?>">
          <button class="btn btn-danger" type="submit">Confirm Delete</button>
        </form>
      </div>
    </div></div>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.inc'; ?>
