<?php
require __DIR__ . '/config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = (string)($_POST['install_key'] ?? '');
    if (!hash_equals(INSTALL_KEY, $key) || INSTALL_KEY === 'CHANGE-THIS-TO-A-LONG-RANDOM-SECRET-KEY') {
        $message = 'Set a private INSTALL_KEY in config.php and enter it correctly.';
    } else {
        $username = trim((string)($_POST['username'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        if (!preg_match('/^[a-zA-Z0-9_.-]{3,80}$/', $username) || strlen($password) < 12) {
            $message = 'Username must be 3–80 characters. Password must be at least 12 characters.';
        } else {
            $pdo = db();
            $count = (int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
            if ($count > 0) {
                $message = 'An admin already exists. Delete install.php now.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO admins (username,password_hash) VALUES (?,?)');
                $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
                $message = 'Admin created. IMPORTANT: delete install.php from your server now, then sign in at /admin/login.php.';
            }
        }
    }
}
?>
<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Install <?= e(SITE_NAME) ?></title><link rel="stylesheet" href="assets/style.css">
<body class="admin-bg"><main class="auth-card"><a class="brand" href="index.php"><?= e(SITE_NAME) ?></a><h1>First-time setup</h1>
<p class="muted">Create your administrator account. This page should be deleted after setup.</p>
<?php if ($message): ?><p class="notice"><?= e($message) ?></p><?php endif; ?>
<form method="post"><label>Install key<input name="install_key" required></label><label>Admin username<input name="username" required minlength="3"></label><label>Password (12+ characters)<input type="password" name="password" required minlength="12"></label><button class="btn" type="submit">Create admin</button></form></main></body></html>
