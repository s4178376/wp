<?php
// One navigation definition serves every page. The active page controls highlighting.
$navigation = [
    'index.php' => ['Home', 'home'],
    'books.php' => ['Browse Books', 'menu_book'],
    'gallery.php' => ['Gallery', 'photo_library'],
    'add.php' => ['Add Book', 'add_circle']
];
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark navbar-bookverse" aria-label="Main navigation">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <span class="material-icons brand-icon" aria-hidden="true">auto_stories</span> BookVerse
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#main-nav" aria-controls="main-nav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-nav">
        <ul class="navbar-nav me-auto">
          <?php foreach ($navigation as $file => $item): ?>
            <li class="nav-item">
              <a class="nav-link<?= $activePage === $file ? ' active' : '' ?>"
                 href="<?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?>"
                 <?= $activePage === $file ? 'aria-current="page"' : '' ?>>
                <span class="material-icons nav-icon" aria-hidden="true"><?= htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8') ?></span>
                <?= htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8') ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

