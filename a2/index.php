<?php
$pageTitle = 'BookVerse | Home';
$activePage = 'index.php';
require_once __DIR__ . '/includes/functions.inc';
require_once __DIR__ . '/includes/db_connect.inc';
$books = [];
if ($connection !== null) {
    try {
        // Tie-break on ID because imported records can share a creation timestamp.
        $books = select_books($connection,
            'SELECT book_id, title, author, genre, price, image_path, status
             FROM books ORDER BY created_at DESC, book_id DESC LIMIT 4');
    } catch (Throwable $exception) {
        $dbError = report_query_failure($exception);
    }
}
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main id="main-content">
  <section aria-label="Featured book carousel">
    <div id="featured-carousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
      <div class="carousel-inner">
        <!-- The carousel stays static; only the latest-books section becomes database-driven. -->
        <div class="carousel-item active">
          <img src="assets/images/covers/1.png" alt="The Midnight Library cover">
          <div class="carousel-caption"><h1>The Midnight Library</h1></div>
        </div>
        <div class="carousel-item">
          <img src="assets/images/covers/2.png" alt="Project Hail Mary cover">
          <div class="carousel-caption"><h2>Project Hail Mary</h2></div>
        </div>
        <div class="carousel-item">
          <img src="assets/images/covers/3.png" alt="Dune cover">
          <div class="carousel-caption"><h2>Dune</h2></div>
        </div>
        <div class="carousel-item">
          <img src="assets/images/covers/4.png" alt="The Hobbit cover">
          <div class="carousel-caption"><h2>The Hobbit</h2></div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#featured-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#featured-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  <section class="container page-wrap" aria-labelledby="latest-heading">
    <h2 id="latest-heading">Latest Books</h2>
    <?php if ($dbError): ?>
      <p class="alert alert-danger" role="alert"><?= e($dbError) ?></p>
    <?php elseif (!$books): ?>
      <p>No books yet. <a href="add.php">Add the first book</a>.</p>
    <?php endif; ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4" id="latest-books">
      <?php foreach ($books as $book): ?>
        <div class="col">
          <article class="card book-card">
            <img class="card-img-top" src="<?= e(cover_url($book['image_path'])) ?>" alt="<?= e($book['title']) ?> cover">
            <div class="card-body">
              <h3 class="card-title"><a href="details.php?id=<?= e($book['book_id']) ?>"><?= e($book['title']) ?></a></h3>
              <p class="book-meta"><?= e($book['genre']) ?> · <?= e($book['author']) ?></p>
              <p>$<?= e(number_format((float) $book['price'], 2)) ?></p>
              <span class="badge <?= e(badge_class($book['status'])) ?>"><?= e($book['status']) ?></span>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
