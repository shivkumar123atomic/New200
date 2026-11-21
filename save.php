<?php
require __DIR__ . '/../config.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method not allowed'); }
verify_csrf();
$id=(int)($_POST['id']??0); $title=trim((string)($_POST['title']??'')); $excerpt=trim((string)($_POST['excerpt']??'')); $content=trim((string)($_POST['content']??''));
$category=trim((string)($_POST['category']??'Writing')) ?: 'Writing'; $cover=trim((string)($_POST['cover_url']??'')); $status=($_POST['status']??'draft')==='published'?'published':'draft';
if ($title==='' || $content==='') { exit('Title and story content are required. Go back and complete them.'); }
if ($cover !== '' && (!filter_var($cover,FILTER_VALIDATE_URL) || !in_array(strtolower((string)parse_url($cover,PHP_URL_SCHEME)),['http','https'],true))) { exit('Cover image must be a valid http/https URL.'); }
$slug=slugify($title); $pdo=db();
if ($id) {
    $check=$pdo->prepare('SELECT id FROM articles WHERE slug=? AND id<>?'); $check->execute([$slug,$id]); if ($check->fetch()) $slug .= '-' . $id;
    $stmt=$pdo->prepare("UPDATE articles SET title=?,slug=?,excerpt=?,content=?,category=?,cover_url=?,status=?,published_at=IF(?='published',COALESCE(published_at,NOW()),NULL) WHERE id=?");
    $stmt->execute([$title,$slug,$excerpt,$content,$category,$cover?:null,$status,$status,$id]);
} else {
    $check=$pdo->prepare('SELECT id FROM articles WHERE slug=?'); $check->execute([$slug]); if ($check->fetch()) $slug .= '-' . bin2hex(random_bytes(3));
    $stmt=$pdo->prepare("INSERT INTO articles(title,slug,excerpt,content,category,cover_url,status,published_at) VALUES(?,?,?,?,?,?,?,IF(?='published',NOW(),NULL))");
    $stmt->execute([$title,$slug,$excerpt,$content,$category,$cover?:null,$status,$status]);
}
header('Location: dashboard.php'); exit;
