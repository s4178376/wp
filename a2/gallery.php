<?php
$pageTitle = 'BookVerse | Cover Gallery';
$activePage = 'gallery.php';
require_once __DIR__ . '/includes/functions.inc';
require_once __DIR__ . '/includes/db_connect.inc';
$books = [];
if ($connection !== null) {
    try {
        $books = select_books($connection, 'SELECT book_id, title, author, image_path FROM books ORDER BY created_at DESC, book_id DESC');
    } catch (Throwable $exception) {
        $dbError = report_query_failure($exception);
    }
}
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>Book Cover Gallery</h1>
  <?php if ($dbError): ?><p class="alert alert-danger" role="alert"><?= e($dbError) ?></p>
  <?php elseif (!$books): ?><p>No covers to display yet.</p><?php endif; ?>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
    <?php foreach ($books as $book): ?>
      <div class="col">
        <button class="gallery-item" type="button" data-bs-toggle="modal" data-bs-target="#gallery-modal"
          data-image="<?= e(cover_url($book['image_path'])) ?>"
          data-title="<?= e($book['title'] . ' by ' . $book['author']) ?>">
          <img src="<?= e(cover_url($book['image_path'])) ?>" alt="<?= e($book['title']) ?> cover">
        </button>
      </div>
    <?php endforeach; ?>
  </div>
</main>
<div class="modal fade gallery-modal" id="gallery-modal" tabindex="-1"
     role="dialog" aria-labelledby="gallery-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5" id="gallery-modal-label">Book cover</h2>
        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modal-image" src="assets/images/covers/1.png" alt="Selected book cover">
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" type="button" id="previous-cover">Previous</button>
        <button class="btn btn-bookverse" type="button" id="next-cover">Next</button>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.inc'; ?>
