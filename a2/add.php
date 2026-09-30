<?php
require_once __DIR__ . '/includes/functions.inc';
require_once __DIR__ . '/includes/session.inc';
$errors = $_SESSION['form_errors'] ?? [];
$old = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);
$pageTitle = 'BookVerse | Add Book';
$activePage = 'add.php';
// __DIR__ resolves includes relative to this file, not the terminal directory.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap">
    <h1>Add New Book</h1>
    <?php if ($errors): ?>
      <div class="alert alert-danger" role="alert" tabindex="-1" id="server-errors">
        <h2 class="h5">Please correct the following</h2>
        <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
        <p class="mb-0">Your text has been kept. Please select the cover file again.</p>
      </div>
    <?php endif; ?>
    <!-- multipart/form-data sends file bytes alongside ordinary POST fields. -->
    <form id="add-book-form" class="row g-3 content-panel form-panel rounded"
          action="process_add.php" method="post" enctype="multipart/form-data" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
      <div class="col-12">
        <label class="form-label" for="title">Book Title</label>
        <input class="form-control" type="text" id="title" name="title" value="<?= e($old['title'] ?? '') ?>" maxlength="255" required>
        <div class="invalid-feedback">Enter a valid book title.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="author">Author Name</label>
        <input class="form-control" type="text" id="author" name="author" value="<?= e($old['author'] ?? '') ?>" maxlength="255" required>
        <div class="invalid-feedback">Enter a valid author name.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="genre">Genre</label>
        <input class="form-control" type="text" id="genre" name="genre" value="<?= e($old['genre'] ?? '') ?>" maxlength="100" required>
        <div class="invalid-feedback">Enter a valid genre.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="publication_year">Publication Year</label>
        <input class="form-control" type="number" id="publication_year" name="publication_year" value="<?= e($old['publication_year'] ?? '') ?>" min="1000" max="<?= e(date('Y')) ?>" required>
        <div class="invalid-feedback">Enter a valid publication year.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="isbn">ISBN</label>
        <input class="form-control" type="text" id="isbn" name="isbn" value="<?= e($old['isbn'] ?? '') ?>" maxlength="20" aria-describedby="isbn-help" required>
        <div class="form-text" id="isbn-help">10 or 13 characters; spaces and hyphens are allowed.</div>
        <div class="invalid-feedback">Enter an ISBN with 10 or 13 characters; only ISBN-10 may end in X.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="price">Price ($)</label>
        <input class="form-control" type="number" id="price" name="price" value="<?= e($old['price'] ?? '') ?>" min="0.01" max="999999.99" step="0.01" required>
        <div class="invalid-feedback">Enter a valid price ($).</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="book_condition">Book Condition</label>
        <select class="form-select" id="book_condition" name="book_condition" required>
          <option value="" disabled <?= empty($old['book_condition']) ? 'selected' : '' ?>>Select book condition</option>
          <option value="New" <?= ($old['book_condition'] ?? '') === 'New' ? 'selected' : '' ?>>New</option>
          <option value="Gently Used" <?= ($old['book_condition'] ?? '') === 'Gently Used' ? 'selected' : '' ?>>Gently Used</option>
          <option value="Fair" <?= ($old['book_condition'] ?? '') === 'Fair' ? 'selected' : '' ?>>Fair</option>
        </select>
        <div class="invalid-feedback">Choose book condition.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="status">Availability Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="" disabled <?= empty($old['status']) ? 'selected' : '' ?>>Select availability status</option>
          <option value="Available" <?= ($old['status'] ?? '') === 'Available' ? 'selected' : '' ?>>Available</option>
          <option value="Reserved" <?= ($old['status'] ?? '') === 'Reserved' ? 'selected' : '' ?>>Reserved</option>
          <option value="Sold" <?= ($old['status'] ?? '') === 'Sold' ? 'selected' : '' ?>>Sold</option>
        </select>
        <div class="invalid-feedback">Choose availability status.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" maxlength="10000" required><?= e($old['description'] ?? '') ?></textarea>
        <div class="invalid-feedback">Enter a description.</div>
      </div>
      <div class="col-12">
        <label class="form-label" for="image-path">Upload Cover Image</label>
        <input class="form-control" id="image-path" name="image_path" type="file"
               accept=".jpg,.jpeg,.png,.gif,.webp" aria-describedby="image-help image-feedback image-status" required>
        <div class="form-text" id="image-help">JPG, JPEG, PNG, GIF or WEBP. Maximum 5 MiB; your server may have a lower upload limit.</div>
        <div class="invalid-feedback" id="image-feedback">Choose a JPG, JPEG, PNG, GIF or WEBP image up to 5 MiB.</div>
        <p id="image-status" class="visually-hidden" aria-live="polite">No cover selected.</p>
        <img id="image-preview" class="image-preview" src="assets/images/favicon.svg" alt="Selected cover preview">
      </div>
      <div class="col-12">
        <button class="btn btn-bookverse w-100" type="submit">Add Book to Collection</button>
        <p id="form-status" role="status" class="mt-3 mb-0"></p>
      </div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
