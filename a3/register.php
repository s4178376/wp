<?php
require __DIR__ . '/includes/bootstrap.inc';
if (is_logged_in()) redirect_to('index.php');
$pageTitle = 'BookVerse | Register';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Create an Account</h1>
    <p>Registration processing will be added in the next development step.</p>
    <form action="process_register.php" method="post" class="content-panel form-panel rounded row g-3">
      <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
      <div class="col-12"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" maxlength="50" autocomplete="username" required></div>
      <div class="col-12"><label class="form-label" for="email">Email</label><input class="form-control" type="email" id="email" name="email" maxlength="100" autocomplete="email" required></div>
      <div class="col-md-6"><label class="form-label" for="password">Password</label><input class="form-control" type="password" id="password" name="password" minlength="8" autocomplete="new-password" required></div>
      <div class="col-md-6"><label class="form-label" for="confirm-password">Confirm Password</label><input class="form-control" type="password" id="confirm-password" name="confirm_password" minlength="8" autocomplete="new-password" required></div>
      <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input class="form-control" type="tel" id="phone" name="phone" maxlength="20" autocomplete="tel"></div>
      <div class="col-md-6"><label class="form-label" for="location">Location</label><input class="form-control" id="location" name="location" maxlength="100"></div>
      <div class="col-12"><label class="form-label" for="bio">About You</label><textarea class="form-control" id="bio" name="bio" rows="4" maxlength="10000"></textarea></div>
      <div class="col-12"><button class="btn btn-bookverse" type="submit">Register</button></div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
