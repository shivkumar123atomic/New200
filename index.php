<?php
require __DIR__ . '/config.php';
$stmt = db()->query("SELECT title,slug,excerpt,category,cover_url,published_at FROM articles WHERE status='published' ORDER BY published_at DESC, id DESC");
$articles = $stmt->fetchAll();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e(SITE_NAME) ?> — Stories worth keeping</title><link rel="stylesheet" href="assets/style.css"></head>
<body><header class="topbar"><a class="brand" href="index.php"><?= e(SITE_NAME) ?></a><nav><a href="#stories">Stories</a><a href="admin/login.php">Admin</a></nav></header>
<main class="wrap"><section class="hero"><p class="eyebrow">A PLACE FOR IDEAS</p><h1>Stories worth<br><em>keeping.</em></h1><p class="hero-copy">Thoughts, essays and notes on life, creativity and everything in between.</p><a class="text-link" href="#stories">Explore the writing ↓</a></section>
<section id="stories" class="stories"><div class="section-head"><div><p class="eyebrow">THE JOURNAL</p><h2>Latest stories</h2></div><span class="muted"><?= count($articles) ?> published</span></div>
<?php if (!$articles): ?><div class="empty"><h3>The first page is waiting.</h3><p>Published stories will appear here.</p></div><?php else: ?>
<div class="story-grid"><?php foreach ($articles as $a): ?><article class="story-card">
<?php if ($a['cover_url']): ?><a href="article.php?slug=<?= rawurlencode($a['slug']) ?>"><img class="cover" src="<?= e($a['cover_url']) ?>" alt=""></a><?php endif; ?>
<p class="category"><?= e($a['category']) ?> <span>·</span> <?= $a['published_at'] ? date('M j, Y', strtotime($a['published_at'])) : '' ?></p>
<h3><a href="article.php?slug=<?= rawurlencode($a['slug']) ?>"><?= e($a['title']) ?></a></h3>
<p class="excerpt"><?= e($a['excerpt']) ?></p><a class="read-link" href="article.php?slug=<?= rawurlencode($a['slug']) ?>">Read story ↗</a>
</article><?php endforeach; ?></div><?php endif; ?></section></main>
<footer class="footer"><span>© <?= date('Y') ?> <?= e(SITE_NAME) ?></span><span>Made for thoughtful words.</span></footer></body></html>
