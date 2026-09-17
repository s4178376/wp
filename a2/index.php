<?php
$pageTitle = 'BookVerse | Home';
$activePage = 'index.php';
// __DIR__ resolves includes relative to this file, not the terminal directory.
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
    <p class="starter-note">Starter: the latest four database records will appear here.</p>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4" id="latest-books">
      <!-- Later: prepared SELECT ordered by created_at DESC, book_id DESC LIMIT 4.
           Escape database values with htmlspecialchars() inside each card. -->
    </div>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>

