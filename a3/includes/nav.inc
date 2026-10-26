<?php
$activePage = $activePage ?? '';
$links = ['index.php' => 'Home', 'books.php' => 'Browse Books', 'gallery.php' => 'Gallery'];
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark navbar-bookverse" aria-label="Main navigation">
    <div class="container">
      <a class="navbar-brand" href="index.php"><span class="material-icons brand-icon" aria-hidden="true">auto_stories</span> BookVerse</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="main-nav">
        <ul class="navbar-nav me-auto">
          <?php foreach ($links as $url => $label): ?>
            <li class="nav-item"><a class="nav-link<?= $activePage === $url ? ' active' : '' ?>" href="<?= e($url) ?>" <?= $activePage === $url ? 'aria-current="page"' : '' ?>><?= e($label) ?></a></li>
          <?php endforeach; ?>
          <li class="nav-item"><a class="nav-link<?= $activePage === 'search.php' ? ' active' : '' ?>" href="search.php"><span class="material-icons nav-icon" aria-hidden="true">search</span> Search</a></li>
          <?php if (is_logged_in()): ?>
            <li class="nav-item"><a class="nav-link" href="add.php">Add Book</a></li>
          <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
          <?php if (is_logged_in()): ?>
            <li class="nav-item"><a class="nav-link" href="seller.php?id=<?= e(current_user_id()) ?>"><?= e($_SESSION['username']) ?></a></li>
            <li class="nav-item">
              <form action="logout.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                <button class="btn nav-link" type="submit">Logout</button>
              </form>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
