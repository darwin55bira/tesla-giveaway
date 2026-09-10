<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$settings = loadSettings();
$orders = loadOrders();
$message = '';
$tab = $_GET['tab'] ?? 'overview';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_payments') {
        foreach (array_keys($settings['payments']) as $key) {
            $settings['payments'][$key]['enabled'] = isset($_POST["payment_{$key}_enabled"]);
            $settings['payments'][$key]['details'] = trim($_POST["payment_{$key}_details"] ?? $settings['payments'][$key]['details']);
            $settings['payments'][$key]['instructions'] = trim($_POST["payment_{$key}_instructions"] ?? $settings['payments'][$key]['instructions']);
        }
        saveSettings($settings);
        $message = 'Payment settings saved.';
        $tab = 'payments';
    }

    if ($action === 'save_general') {
        $settings['site_title'] = trim($_POST['site_title'] ?? $settings['site_title']);
        $settings['participant_count'] = (int)($_POST['participant_count'] ?? $settings['participant_count']);
        $settings['event_hours'] = (int)($_POST['event_hours'] ?? $settings['event_hours']);
        $settings['event_minutes'] = (int)($_POST['event_minutes'] ?? $settings['event_minutes']);
        $settings['event_seconds'] = (int)($_POST['event_seconds'] ?? $settings['event_seconds']);
        $settings['demo_mode'] = isset($_POST['demo_mode']);

        $newKey = trim($_POST['admin_access_key'] ?? '');
        if ($newKey !== '') {
            $settings['admin_access_key'] = $newKey;
        }

        saveSettings($settings);
        $message = 'General settings saved.';
        $tab = 'settings';
    }

    if ($action === 'update_order') {
        $orderId = $_POST['order_id'] ?? '';
        $newStatus = $_POST['status'] ?? '';
        foreach ($orders as &$o) {
            if ($o['id'] === $orderId) {
                $o['status'] = $newStatus;
                $o['updated_at'] = date('c');
            }
        }
        unset($o);
        saveOrders($orders);
        $message = 'Order updated.';
        $tab = 'orders';
    }

    if ($action === 'delete_order') {
        $orderId = $_POST['order_id'] ?? '';
        $orders = array_values(array_filter($orders, static fn($o) => $o['id'] !== $orderId));
        saveOrders($orders);
        $message = 'Order deleted.';
        $tab = 'orders';
    }
}

$pendingCount = count(array_filter($orders, static fn($o) => ($o['status'] ?? '') === 'pending_payment'));
$submittedCount = count(array_filter($orders, static fn($o) => ($o['status'] ?? '') === 'payment_submitted'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Tesla Giveaway Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(baseUrl('assets/css/style.css')) ?>">
</head>
<body class="admin-page">
<div class="admin-layout">
    <aside class="admin-sidebar">
        <h2>⚡ Admin Panel</h2>
        <nav>
            <a href="?tab=overview" class="<?= $tab === 'overview' ? 'active' : '' ?>">📊 Overview</a>
            <a href="?tab=payments" class="<?= $tab === 'payments' ? 'active' : '' ?>">💳 Payment Methods</a>
            <a href="?tab=orders" class="<?= $tab === 'orders' ? 'active' : '' ?>">📋 Orders</a>
            <a href="?tab=settings" class="<?= $tab === 'settings' ? 'active' : '' ?>">⚙️ Settings</a>
            <a href="<?= e(baseUrl()) ?>" target="_blank">🌐 View Site</a>
            <a href="logout.php">🚪 Logout</a>
        </nav>
    </aside>
    <div class="admin-content">
        <h1>Dashboard</h1>

        <?php if ($message): ?>
        <div class="alert alert-success" style="margin-bottom:20px"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($tab === 'overview'): ?>
        <div class="admin-grid">
            <div class="stat-card">
                <div class="stat-num"><?= count($orders) ?></div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-num"><?= $pendingCount ?></div>
                <div class="stat-label">Pending Payment</div>
            </div>
            <div class="stat-card">
                <div class="stat-num"><?= $submittedCount ?></div>
                <div class="stat-label">Payment Submitted</div>
            </div>
            <div class="stat-card">
                <div class="stat-num"><?= count(enabledPayments($settings)) ?></div>
                <div class="stat-label">Active Payment Methods</div>
            </div>
        </div>

        <div class="admin-card">
            <h3>Payment Methods Status</h3>
            <?php foreach ($settings['payments'] as $key => $payment): ?>
            <div class="toggle-row">
                <span><?= e($payment['label']) ?></span>
                <span style="color:<?= $payment['enabled'] ? '#4ade80' : '#f87171' ?>">
                    <?= $payment['enabled'] ? '✅ Enabled' : '❌ Disabled' ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ($tab === 'payments'): ?>
        <div class="admin-card">
            <h3>Configure Payment Methods</h3>
            <p style="color:#9ca3af;font-size:13px;margin-bottom:24px">Enable or disable payment options and set payment details shown to users.</p>
            <form method="post" class="admin-form">
                <input type="hidden" name="action" value="save_payments">
                <?php foreach ($settings['payments'] as $key => $payment): ?>
                <div style="border:1px solid #2a2d3a;border-radius:12px;padding:20px;margin-bottom:16px">
                    <div class="toggle-row" style="border:none;padding:0 0 16px">
                        <strong><?= e($payment['label']) ?></strong>
                        <label class="toggle">
                            <input type="checkbox" name="payment_<?= e($key) ?>_enabled" <?= $payment['enabled'] ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Payment Details (tag, email, wallet, etc.)</label>
                        <input type="text" name="payment_<?= e($key) ?>_details" value="<?= e($payment['details']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Instructions</label>
                        <textarea name="payment_<?= e($key) ?>_instructions" rows="2" style="width:100%;padding:10px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#fff;font-size:14px;margin-top:6px"><?= e($payment['instructions']) ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn-admin">Save Payment Settings</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($tab === 'orders'): ?>
        <div class="admin-card">
            <h3>All Orders (<?= count($orders) ?>)</h3>
            <?php if (empty($orders)): ?>
            <p style="color:#9ca3af;padding:20px 0">No orders yet.</p>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Name</th>
                        <th>Car</th>
                        <th>Fee</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($orders) as $order): ?>
                    <tr>
                        <td><?= e($order['id']) ?></td>
                        <td><?= e($order['full_name']) ?><br><small style="color:#9ca3af"><?= e($order['email']) ?></small></td>
                        <td><?= e($order['car_name']) ?></td>
                        <td>$<?= (int)$order['fee'] ?></td>
                        <td><?= e($order['payment_method'] ?? '—') ?></td>
                        <td><?= e($order['status']) ?></td>
                        <td>
                            <form method="post" style="display:inline">
                                <input type="hidden" name="action" value="update_order">
                                <input type="hidden" name="order_id" value="<?= e($order['id']) ?>">
                                <select name="status" onchange="this.form.submit()" style="background:#0f1117;border:1px solid #2a2d3a;color:#fff;padding:4px 8px;border-radius:4px;font-size:12px">
                                    <option value="pending_payment" <?= ($order['status'] ?? '') === 'pending_payment' ? 'selected' : '' ?>>Pending</option>
                                    <option value="payment_submitted" <?= ($order['status'] ?? '') === 'payment_submitted' ? 'selected' : '' ?>>Submitted</option>
                                    <option value="completed" <?= ($order['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                                </select>
                            </form>
                            <form method="post" style="display:inline" onsubmit="return confirm('Delete this order?')">
                                <input type="hidden" name="action" value="delete_order">
                                <input type="hidden" name="order_id" value="<?= e($order['id']) ?>">
                                <button type="submit" class="btn-admin-outline" style="margin-left:4px;padding:4px 8px;font-size:12px">✕</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($tab === 'settings'): ?>
        <div class="admin-card">
            <h3>General Settings</h3>
            <form method="post" class="admin-form">
                <input type="hidden" name="action" value="save_general">
                <div class="form-group">
                    <label>Site Title</label>
                    <input type="text" name="site_title" value="<?= e($settings['site_title']) ?>">
                </div>
                <div class="form-group">
                    <label>Participant Count</label>
                    <input type="number" name="participant_count" value="<?= (int)$settings['participant_count'] ?>">
                </div>
                <div class="form-group">
                    <label>Countdown Timer (H:M:S)</label>
                    <div style="display:flex;gap:8px">
                        <input type="number" name="event_hours" value="<?= (int)$settings['event_hours'] ?>" placeholder="Hours" style="flex:1">
                        <input type="number" name="event_minutes" value="<?= (int)$settings['event_minutes'] ?>" placeholder="Min" style="flex:1">
                        <input type="number" name="event_seconds" value="<?= (int)$settings['event_seconds'] ?>" placeholder="Sec" style="flex:1">
                    </div>
                </div>
                <div class="form-group">
                    <label>New Admin Access Key (leave blank to keep current)</label>
                    <input type="password" name="admin_access_key" placeholder="Enter new key">
                </div>
                <div class="toggle-row">
                    <span>Show Demo Banner</span>
                    <label class="toggle">
                        <input type="checkbox" name="demo_mode" <?= $settings['demo_mode'] ? 'checked' : '' ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <button type="submit" class="btn-admin" style="margin-top:16px">Save Settings</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
