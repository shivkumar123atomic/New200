<?php
require __DIR__ . '/../config.php'; require_admin();
$id = (int)($_GET['id'] ?? 0); $article = ['title'=>'','excerpt'=>'','content'=>'','category'=>'Writing','cover_url'=>'','status'=>'draft'];
if ($id) { $stmt=db()->prepare('SELECT * FROM articles WHERE id=?'); $stmt->execute([$id]); $found=$stmt->fetch(); if (!$found) { http_response_code(404); exit('Story not found'); } $article=$found; }
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= $id?'Edit':'New' ?> story</title><link rel="stylesheet" href="../assets/style.css"></head><body class="admin-bg">
<header class="admin-top"><a class="brand" href="dashboard.php">← Dashboard</a><div><a href="../index.php" target="_blank">View site ↗</a><a href="logout.php">Sign out</a></div></header>
<main class="editor-wrap"><p class="eyebrow">WRITING EDITOR</p><h1><?= $id?'Edit your story':'A new story begins.' ?></h1><form method="post" action="save.php" class="editor-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= $id ?>">
<label>Title<input class="title-input" name="title" maxlength="220" value="<?= e($article['title']) ?>" placeholder="Give your story a title..." required></label>
<label>Short introduction<textarea name="excerpt" rows="2" maxlength="1000" placeholder="A sentence that invites readers in..."><?= e($article['excerpt']) ?></textarea></label>
<div class="form-row"><label>Category<input name="category" maxlength="100" value="<?= e($article['category']) ?>"></label><label>Cover image URL<input type="url" name="cover_url" maxlength="600" value="<?= e($article['cover_url']) ?>" placeholder="https://..."></label></div>
<label>Your story <span class="muted">· Plain text editor; line breaks are preserved</span><textarea class="content-input" name="content" rows="22" placeholder="Start writing..."><?= e($article['content']) ?></textarea></label>
<div class="editor-actions"><label class="status-label">Status<select name="status"><option value="draft" <?= $article['status']==='draft'?'selected':'' ?>>Save as draft</option><option value="published" <?= $article['status']==='published'?'selected':'' ?>>Publish</option></select></label><button class="btn" type="submit">Save story</button><a class="subtle-link" href="dashboard.php">Cancel</a></div></form></main></body></html>
