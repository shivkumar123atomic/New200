<?php
require __DIR__ . '/../config.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method not allowed'); }
verify_csrf(); $id=(int)($_POST['id']??0);
$stmt=db()->prepare('DELETE FROM articles WHERE id=?'); $stmt->execute([$id]);
header('Location: dashboard.php'); exit;
