<?php
require __DIR__ . '/includes/bootstrap.inc';
$pageTitle = 'BookVerse | Search';
$activePage = 'search.php';
$keyword = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$books = [];
if (strlen($keyword) > 200) show_error(400, 'Use a shorter search phrase.');
if ($keyword !== '' && $connection !== null) {
    // Escape LIKE wildcards so a user's % or _ is searched literally.
    $pattern = '%' . strtr($keyword, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
    try {
        $books = select_books($connection, "SELECT b.*, u.username AS seller_name
            FROM books b LEFT JOIN users u ON u.user_id = b.user_id
            WHERE b.title LIKE ? ESCAPE '!' OR b.author LIKE ? ESCAPE '!'
               OR b.description LIKE ? ESCAPE '!' ORDER BY b.title, b.book_id",
            'sss', [$pattern, $pattern, $pattern]);
    } catch (Throwable $error) { $dbError = report_query_failure($error); }
}
require __DIR__ . '/includes/header.inc';
require __DIR__ . '/includes/nav.inc';
?>
<main class="container page-wrap" id="main-content">
  <h1>Search Books</h1>
  <form action="search.php" method="get" class="content-panel p-3 rounded mb-4">
    <label for="keyword" class="form-label">Title, author or description</label>
    <div class="input-group"><input type="search" class="form-control" id="keyword" name="q" value="<?= e($keyword) ?>" maxlength="200" required><button class="btn btn-bookverse" type="submit">Search</button></div>
  </form>
  <?php if ($dbError): ?><p class="alert alert-danger"><?= e($dbError) ?></p>
  <?php elseif ($keyword !== ''): ?>
    <p><?= e(count($books)) ?> results for “<?= e($keyword) ?>”.</p>
    <?php require __DIR__ . '/includes/book_cards.inc'; ?>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.inc'; ?>
