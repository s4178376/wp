<?php
require __DIR__ . '/includes/bootstrap.inc';
require_post_token();
if (is_logged_in()) redirect_to('index.php');

// Validate on the server even when the browser has already checked the form.
$errors = [];
$values = [];
foreach (['username' => 50, 'email' => 100, 'phone' => 20, 'location' => 100, 'bio' => 10000] as $field => $limit) {
    $raw = $_POST[$field] ?? '';
    // Reject arrays, invalid UTF-8 and oversized input before saving form values.
    if (!is_string($raw) || strlen($raw) > $limit * 4 || preg_match('//u', $raw) !== 1) {
        $errors[] = ucfirst($field) . ' is invalid or too long.';
        $values[$field] = '';
        continue;
    }
    $value = trim($raw);
    $length = preg_match_all('/./us', $value);
    if ($length > $limit || strpos($value, "\0") !== false) {
        $errors[] = ucfirst($field) . ' must contain at most ' . $limit . ' characters and no null bytes.';
        $value = '';
    }
    $values[$field] = $value;
}
if ($values['username'] === '') $errors[] = 'Enter a username.';
if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';

$password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
$confirmation = is_string($_POST['confirm_password'] ?? null) ? $_POST['confirm_password'] : '';
// Bcrypt accepts at most 72 bytes. Reject longer values rather than silently truncating.
if (strlen($password) > 72 || preg_match('//u', $password) !== 1 ||
    preg_match_all('/./us', $password) < 8 || strpos($password, "\0") !== false) {
    $errors[] = 'Use a password of at least 8 characters and at most 72 bytes, without null bytes.';
}
if ($password !== $confirmation) $errors[] = 'The passwords do not match.';

// Only non-password fields are retained after a failed submission.
$_SESSION['registration_values'] = $values;
if ($errors) {
    flash(implode(' ', array_unique($errors)), 'danger');
    redirect_to('register.php');
}
if ($connection === null) {
    flash('Registration is temporarily unavailable. Your details have been kept; please try again.', 'danger');
    redirect_to('register.php');
}

try {
    // The database collation determines case sensitivity, consistent with login.
    $existing = select_books($connection,
        'SELECT user_id FROM users WHERE username = ? OR email = ? LIMIT 1',
        'ss', [$values['username'], $values['email']]);
    if ($existing) {
        flash('That username or email is already registered. Choose different details or log in.', 'danger');
        redirect_to('register.php');
    }
    // PASSWORD_BCRYPT produces the 60-character hash expected by the supplied schema.
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $statement = mysqli_prepare($connection,
        'INSERT INTO users (username, email, password, phone, location, bio) VALUES (?, ?, ?, ?, ?, ?)');
    try {
        mysqli_stmt_bind_param($statement, 'ssssss', $values['username'], $values['email'],
            $hash, $values['phone'], $values['location'], $values['bio']);
        mysqli_stmt_execute($statement);
        $userId = (int) mysqli_insert_id($connection);
    } finally {
        mysqli_stmt_close($statement);
    }
} catch (Throwable $error) {
    // UNIQUE constraints also catch two registrations arriving at the same time.
    if ($error instanceof mysqli_sql_exception && (int) $error->getCode() === 1062) {
        flash('That username or email is already registered. Choose different details or log in.', 'danger');
    } else {
        // Do not log submitted details or expose database errors to visitors.
        error_log('BookVerse registration failed; error code ' . $error->getCode());
        flash('Registration is temporarily unavailable. Please try again later.', 'danger');
    }
    redirect_to('register.php');
}

// A new account is immediately authenticated using the same session keys as login.
session_regenerate_id(true);
$_SESSION['user_id'] = $userId;
$_SESSION['username'] = $values['username'];
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
unset($_SESSION['registration_values']);
flash('Your account has been created. You are now logged in.', 'success');
redirect_to('index.php');
