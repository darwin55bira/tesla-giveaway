<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$settings = loadSettings();
$orders = loadOrders();
usort($orders, static fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));

$pageTitle = 'Transactions — ' . $settings['site_title'];
require __DIR__ . '/includes/header.php';
?>

<div class="form-page">
    <div class="container" style="max-width:900px">
        <div class="form-card" style="max-width:100%">
            <h1>Live Transactions</h1>
            <p class="subtitle">Recent delivery fee payments from participants worldwide.</p>

            <?php if (empty($orders)): ?>
            <p style="text-align:center;color:var(--gray);padding:40px 0">No transactions yet. Be the first to claim your Tesla!</p>
            <?php else: ?>
            <div class="live-feed" style="margin-top:24px">
                <?php foreach ($orders as $order):
                    $statusLabels = [
                        'pending_payment' => 'Awaiting payment ⏳',
                        'payment_submitted' => 'Payment verified ✓',
                        'completed' => 'Delivery confirmed ✓',
                    ];
                    $status = $statusLabels[$order['status']] ?? $order['status'];
                    $minutesAgo = max(1, (int)((time() - strtotime($order['created_at'])) / 60));
                ?>
                <div class="feed-item">
                    <div class="feed-item-left">
                        <div class="feed-name"><?= e($order['full_name']) ?> · <?= e($order['country']) ?></div>
                        <div class="feed-status"><?= e($order['car_name']) ?> · <?= e($status) ?></div>
                    </div>
                    <div style="text-align:right">
                        <div class="feed-fee">$<?= (int)$order['fee'] ?></div>
                        <div class="feed-time"><?= $minutesAgo ?> min ago</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div style="text-align:center;margin-top:32px">
                <a href="participate.php" class="btn">🚗 Claim Your Tesla Now →</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
