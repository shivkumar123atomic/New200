<?php
require __DIR__ . '/config.php';
$slug = (string)($_GET['slug'] ?? '');
$stmt = db()->prepare("SELECT * FROM articles WHERE slug=? AND status='published' LIMIT 1");
$stmt->execute([$slug]); $article = $stmt->fetch();
if (!$article) { http_response_code(404); }
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= $article ? e($article['title']) . ' — ' . e(SITE_NAME) : 'Not found' ?></title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><?= e(SITE_NAME) ?></a><nav><a href="index.php">← All stories</a></nav></header>
<?php if (!$article): ?><main class="article-wrap"><h1>Story not found</h1><a class="text-link" href="index.php">Return home</a></main>
<?php else: ?><main class="article-wrap"><p class="category"><?= e($article['category']) ?> · <?= date('M j, Y', strtotime($article['published_at'] ?? $article['created_at'])) ?></p><h1><?= e($article['title']) ?></h1><p class="article-excerpt"><?= e($article['excerpt']) ?></p>
<?php if ($article['cover_url']): ?><img class="article-cover" src="<?= e($article['cover_url']) ?>" alt=""><?php endif; ?>
<div class="article-content"><?= nl2br(e($article['content'])) ?></div><p class="back"><a class="text-link" href="index.php">← Back to all stories</a></p></main><?php endif; ?>
<footer class="footer"><span>© <?= date('Y') ?> <?= e(SITE_NAME) ?></span></footer></body></html>
