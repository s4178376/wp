<!-- Caller supplies $books from a prepared SELECT, including seller_name and user_id. -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
  <?php foreach ($books as $book): ?>
    <div class="col"><article class="card book-card">
      <img class="card-img-top" src="<?= e(cover_url($book['image_path'])) ?>" alt="<?= e($book['title']) ?> cover" loading="lazy">
      <div class="card-body">
        <h2 class="card-title"><a href="details.php?id=<?= e($book['book_id']) ?>"><?= e($book['title']) ?></a></h2>
        <p class="book-meta"><?= e($book['author']) ?> · <?= e($book['genre']) ?></p>
        <p>$<?= e(number_format((float) $book['price'], 2)) ?></p>
        <span class="badge <?= e(badge_class($book['status'])) ?>"><?= e($book['status']) ?></span>
        <p class="mt-2 mb-0"><?php if ($book['user_id'] !== null): ?>
          Seller: <a href="seller.php?id=<?= e($book['user_id']) ?>"><?= e($book['seller_name']) ?></a>
        <?php else: ?>No current seller<?php endif; ?></p>
      </div>
    </article></div>
  <?php endforeach; ?>
</div>
