<?php
require_once __DIR__ . '/includes/functions.inc';
require_once __DIR__ . '/includes/session.inc';
$pageTitle = 'BookVerse | Book Details';
$activePage = '';
$book = null;
$dbError = null;
// Arrays, negative values, zero and non-integer query strings are rejected.
$rawId = $_GET['id'] ?? '';
$id = is_string($rawId) ? filter_var($rawId, FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]) : false;
if ($id === false) {
    http_response_code(400);
    $dbError = 'Please choose a valid book from the catalogue.';
} else {
    require __DIR__ . '/includes/db_connect.inc';
    if ($connection !== null) {
        try {
            // The question mark holds data bound as an integer, not SQL text.
            $rows = select_books($connection, 'SELECT * FROM books WHERE book_id = ?', 'i', [$id]);
            $book = $rows[0] ?? null;
            if (!$book) {
                http_response_code(404);
                $dbError = 'That book was not found.';
            } else {
                $pageTitle = 'BookVerse | ' . $book['title'];
            }
        } catch (Throwable $exception) {
            $dbError = report_query_failure($exception);
        }
    }
}
$saved = $book && (($_SESSION['created_book_id'] ?? null) === (int) $book['book_id']);
if ($saved) unset($_SESSION['created_book_id']);
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <?php if ($dbError): ?>
    <h1>Book Details</h1><p class="alert alert-danger" role="alert"><?= e($dbError) ?></p>
  <?php elseif ($book): ?>
    <?php if ($saved): ?><p class="alert alert-success" role="status">Book added successfully.</p><?php endif; ?>
    <article class="row g-4">
      <div class="col-md-4">
        <img class="img-fluid rounded detail-cover" src="<?= e(cover_url($book['image_path'])) ?>" alt="<?= e($book['title']) ?> cover">
      </div>
      <div class="col-md-8">
        <h1><?= e($book['title']) ?></h1>
        <p class="lead">By <?= e($book['author']) ?></p>
        <dl>
          <dt>Genre</dt><dd><?= e($book['genre']) ?></dd>
          <dt>Publication year</dt><dd><?= e($book['publication_year']) ?></dd>
          <dt>ISBN</dt><dd><?= e($book['isbn']) ?></dd>
          <dt>Condition</dt><dd><?= e($book['book_condition']) ?></dd>
          <dt>Price</dt><dd>$<?= e(number_format((float) $book['price'], 2)) ?></dd>
          <dt>Availability</dt><dd><span class="badge <?= e(badge_class($book['status'])) ?>"><?= e($book['status']) ?></span></dd>
        </dl>
        <h2>Description</h2>
        <p class="book-description"><?= e($book['description']) ?></p>
      </div>
    </article>
  <?php endif; ?>
  <a class="btn btn-bookverse mt-4" href="books.php">Back to Browse Books</a>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
