<?php
require __DIR__ . '/includes/bootstrap.inc';
$id = positive_id($_GET['id'] ?? null);
if (!$id) show_error(400, 'Choose a valid seller.');
if ($connection === null) show_error(503, 'The database is unavailable.');
try {
    $rows = select_books($connection, 'SELECT user_id, username, location, bio, joined_at FROM users WHERE user_id = ?', 'i', [$id]);
    if (!$rows) show_error(404, 'Seller not found.');
    $seller = $rows[0];
    $books = select_books($connection, 'SELECT b.*, u.username AS seller_name
        FROM books b JOIN users u ON u.user_id = b.user_id WHERE b.user_id = ?
        ORDER BY b.created_at DESC, b.book_id DESC', 'i', [$id]);
} catch (Throwable $error) { show_error(503, report_query_failure($error)); }
$pageTitle = 'BookVerse | Seller: ' . $seller['username'];
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1><?= e($seller['username']) ?></h1>
  <p><?= e($seller['location']) ?></p>
  <p class="book-description"><?= e($seller['bio']) ?></p>
  <h2>Books from this seller</h2>
  <?php if (!$books): ?><p>This seller has no books listed.</p><?php endif; ?>
  <?php require __DIR__ . '/includes/book_cards.inc'; ?>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
