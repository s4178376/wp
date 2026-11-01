<?php
/*
 * Login screen: send credentials and the session CSRF token to process_login.php.
 * A signed-in visitor is redirected before any HTML is printed.
 */
require __DIR__ . '/includes/bootstrap.inc';
if (is_logged_in()) redirect_to('index.php');
$pageTitle = 'BookVerse | Login';
$activePage = 'login.php';
// Queries, authentication and redirects run before the shared header prints HTML.
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<!-- Main landmark: page-specific content follows the shared navigation. -->
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Login</h1>
    <form action="process_login.php" method="post" class="content-panel form-panel rounded">
      <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
      <div class="mb-3"><label for="username" class="form-label">Username</label><input class="form-control" id="username" name="username" maxlength="50" autocomplete="username" required></div>
      <div class="mb-3"><label for="password" class="form-label">Password</label><input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required></div>
      <button type="submit" class="btn btn-bookverse">Login</button>
      <a class="ms-3" href="register.php">Create an account</a>
    </form>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
