<?php
$pageTitle = 'BookVerse | Cover Gallery';
$activePage = 'gallery.php';
// __DIR__ resolves includes relative to this file, not the terminal directory.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>Book Cover Gallery</h1>
  <p class="starter-note">Starter: cover buttons will be generated from database records.</p>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
    <!-- Later: .gallery-item buttons need data-image, data-title,
         data-bs-toggle="modal" and data-bs-target="#gallery-modal". -->
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

