<?php
require __DIR__ . '/includes/bootstrap.inc';
if (is_logged_in()) redirect_to('index.php');
// Consume retained text once; passwords are never stored or repopulated.
$values = $_SESSION['registration_values'] ?? [];
unset($_SESSION['registration_values']);
$pageTitle = 'BookVerse | Register';
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <div class="form-panel-wrap"><h1>Create an Account</h1>
    <p>Create an account to manage your book listings. Phone, location and About You are optional.</p>
    <form action="process_register.php" method="post" class="content-panel form-panel rounded row g-3">
      <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
      <div class="col-12"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" value="<?= e($values['username'] ?? '') ?>" maxlength="50" autocomplete="username" required></div>
      <div class="col-12"><label class="form-label" for="email">Email</label><input class="form-control" type="email" id="email" name="email" value="<?= e($values['email'] ?? '') ?>" maxlength="100" autocomplete="email" required></div>
      <div class="col-md-6"><label class="form-label" for="password">Password</label><input class="form-control" type="password" id="password" name="password" minlength="8" maxlength="72" aria-describedby="password-help" autocomplete="new-password" required></div>
      <div class="col-md-6"><label class="form-label" for="confirm-password">Confirm Password</label><input class="form-control" type="password" id="confirm-password" name="confirm_password" minlength="8" maxlength="72" aria-describedby="password-help" autocomplete="new-password" required></div>
      <div class="col-12"><p class="form-text" id="password-help">Use at least 8 characters and at most 72 bytes. Some characters, such as emoji, use more than one byte. Re-enter both passwords if the form reports an error.</p></div>
      <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input class="form-control" type="tel" id="phone" name="phone" value="<?= e($values['phone'] ?? '') ?>" maxlength="20" autocomplete="tel"></div>
      <div class="col-md-6"><label class="form-label" for="location">Location</label><input class="form-control" id="location" name="location" value="<?= e($values['location'] ?? '') ?>" maxlength="100"></div>
      <div class="col-12"><label class="form-label" for="bio">About You</label><textarea class="form-control" id="bio" name="bio" rows="4" maxlength="10000"><?= e($values['bio'] ?? '') ?></textarea></div>
      <div class="col-12"><button class="btn btn-bookverse" type="submit">Register</button></div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
