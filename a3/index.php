<?php
require __DIR__ . '/includes/bootstrap.inc';
$pageTitle = 'BookVerse | Home';
$activePage = 'index.php';
$books = [];
if ($connection !== null) {
    try {
        $books = select_books($connection, 'SELECT b.*, u.username AS seller_name
            FROM books b LEFT JOIN users u ON u.user_id = b.user_id
            ORDER BY b.created_at DESC, b.book_id DESC LIMIT 4');
    } catch (Throwable $error) { $dbError = report_query_failure($error); }
}
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main id="main-content">
  <h1 class="visually-hidden">BookVerse — discover your next book</h1>
  <?php if ($books): ?>
    <!-- A3 uses the latest database covers for the carousel as well as the grid. -->
    <div id="featured-carousel" class="carousel slide hero-carousel" data-bs-ride="carousel" aria-label="Latest books">
      <div class="carousel-inner">
        <?php foreach ($books as $position => $book): ?>
          <div class="carousel-item<?= $position === 0 ? ' active' : '' ?>">
            <img src="<?= e(cover_url($book['image_path'])) ?>" alt="<?= e($book['title']) ?> cover">
            <div class="carousel-caption"><h2><?= e($book['title']) ?></h2></div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#featured-carousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
      <button class="carousel-control-next" type="button" data-bs-target="#featured-carousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
    </div>
  <?php endif; ?>
  <section class="container page-wrap" aria-labelledby="latest-heading">
    <h2 id="latest-heading">Latest Books</h2>
    <?php if ($dbError): ?><p class="alert alert-danger"><?= e($dbError) ?></p>
    <?php elseif (!$books): ?><p>No books have been added yet.</p>
    <?php else: require __DIR__ . '/includes/book_cards.inc'; endif; ?>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
