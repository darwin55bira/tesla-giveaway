<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$settings = loadSettings();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = trim($_POST['access_key'] ?? '');
    if ($key === $settings['admin_access_key']) {
        $_SESSION['admin_authenticated'] = true;
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid access key. Please try again.';
}

if (isAdminAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access — Tesla Giveaway Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(baseUrl('assets/css/style.css')) ?>">
</head>
<body class="admin-page">
<div class="admin-login">
    <div class="admin-login-card">
        <img src="<?= e(baseUrl('assets/images/tesla-logo.png')) ?>" alt="Tesla" class="admin-login-logo">
        <h1>Admin Access</h1>
        <p>Enter admin key to continue</p>
        <?php if ($error): ?>
        <div class="alert alert-error" style="margin-bottom:16px"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="password" name="access_key" placeholder="Enter access key" required autofocus>
            <button type="submit" class="btn-admin" style="width:100%;padding:14px">Unlock Admin Panel</button>
        </form>
        <p style="margin-top:24px;font-size:12px;color:#6b7280">Default demo key: <code>demo-admin-2025</code></p>
    </div>
</div>
</body>
</html>
