<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';
$settings = loadSettings();
$pageTitle = $pageTitle ?? $settings['site_title'];
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(baseUrl('assets/css/style.css')) ?>">
</head>
<body class="<?= e($bodyClass) ?>">
<div class="demo-banner" role="alert">
    ⚠️ <strong>Scam-awareness demo.</strong> This giveaway is fake. VoltDrive is not a real company.
    Never pay a "delivery fee" for a prize. <a href="<?= e(baseUrl('payment.php')) ?>">See the red flags →</a>
</div>

<header class="site-header">
    <div class="container header-inner">
        <a href="<?= e(baseUrl()) ?>" class="logo">
            <span class="text-logo">⚡ <?= e($settings['brand']) ?></span>
        </a>
        <nav class="main-nav" id="mainNav">
            <a href="<?= e(baseUrl('#giveaway')) ?>">Giveaway</a>
            <a href="<?= e(baseUrl('#info')) ?>">Info</a>
            <a href="<?= e(baseUrl('#instruction')) ?>">Instruction</a>
            <a href="<?= e(baseUrl('participate.php')) ?>">Participate</a>
            <a href="<?= e(baseUrl('participate.php')) ?>" class="btn btn-sm">Claim Now</a>
        </nav>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button>
    </div>
</header>

<div id="liveToastContainer" class="live-toast-container" aria-live="polite"></div>

<main>
