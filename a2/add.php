<?php
$pageTitle = 'BookVerse | Add Book';
$activePage = 'add.php';
// __DIR__ resolves includes relative to this file, not the terminal directory.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap">
    <h1>Add New Book</h1>
    <p class="starter-note">Starter: validation and preview only. Saving and uploading are not implemented.</p>
    <!-- multipart/form-data will carry the file once the PHP handler is implemented. -->
    <form id="add-book-form" class="row g-3 content-panel form-panel rounded"
          action="process_add.php" method="post" enctype="multipart/form-data" novalidate>
      <div class="col-12">
        <label class="form-label" for="title">Book Title</label>
        <input class="form-control" type="text" id="title" name="title" maxlength="255" required>
        <div class="invalid-feedback">Enter a valid book title.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="author">Author Name</label>
        <input class="form-control" type="text" id="author" name="author" maxlength="255" required>
        <div class="invalid-feedback">Enter a valid author name.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="genre">Genre</label>
        <input class="form-control" type="text" id="genre" name="genre" maxlength="100" required>
        <div class="invalid-feedback">Enter a valid genre.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="publication_year">Publication Year</label>
        <input class="form-control" type="number" id="publication_year" name="publication_year" min="1000" max="2026" required>
        <div class="invalid-feedback">Enter a valid publication year.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="isbn">ISBN</label>
        <input class="form-control" type="text" id="isbn" name="isbn" maxlength="20" required>
        <div class="invalid-feedback">Enter a valid isbn.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="price">Price ($)</label>
        <input class="form-control" type="number" id="price" name="price" min="0.01" max="999999.99" step="0.01" required>
        <div class="invalid-feedback">Enter a valid price ($).</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="book_condition">Book Condition</label>
        <select class="form-select" id="book_condition" name="book_condition" required>
          <option value="" selected disabled>Select book condition</option>
          <option value="New">New</option>
          <option value="Gently Used">Gently Used</option>
          <option value="Fair">Fair</option>
        </select>
        <div class="invalid-feedback">Choose book condition.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="status">Availability Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="" selected disabled>Select availability status</option>
          <option value="Available">Available</option>
          <option value="Reserved">Reserved</option>
          <option value="Sold">Sold</option>
        </select>
        <div class="invalid-feedback">Choose availability status.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        <div class="invalid-feedback">Enter a description.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="image-path">Upload Cover Image</label>
        <input class="form-control" id="image-path" name="image_path" type="file"
               accept=".jpg,.jpeg,.png,.gif,.webp" aria-describedby="image-feedback image-status" required>
        <div class="invalid-feedback" id="image-feedback">Choose a JPG, JPEG, PNG, GIF or WEBP image.</div>
        <p id="image-status" class="visually-hidden" aria-live="polite">No cover selected.</p>
        <img id="image-preview" class="image-preview" src="assets/images/favicon.svg" alt="Selected cover preview">
      </div>
      <div class="col-12">
        <button class="btn btn-bookverse w-100" type="submit">Check Book Details (starter only)</button>
        <p id="form-status" role="status" class="mt-3 mb-0"></p>
      </div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>

