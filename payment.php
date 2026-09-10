<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$settings = loadSettings();
$orderId = $_GET['order'] ?? ($_SESSION['current_order_id'] ?? '');
$orders = loadOrders();
$order = null;

foreach ($orders as $o) {
    if ($o['id'] === $orderId) {
        $order = $o;
        break;
    }
}

if (!$order) {
    header('Location: participate.php');
    exit;
}

$payments = enabledPayments($settings);
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['payment_method'] ?? '';

    if (!isset($payments[$method])) {
        $error = 'Please select a valid payment method.';
    } elseif ($method === 'giftcard') {
        if (empty($_FILES['giftcard_image']['name'])) {
            $error = 'Please upload a gift card image.';
        } else {
            $ext = strtolower(pathinfo($_FILES['giftcard_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($ext, $allowed, true)) {
                $error = 'Invalid file type. Please upload an image.';
            } else {
                $filename = $orderId . '_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['giftcard_image']['tmp_name'], UPLOAD_PATH . '/' . $filename);

                foreach ($orders as &$o) {
                    if ($o['id'] === $orderId) {
                        $o['payment_method'] = 'giftcard';
                        $o['giftcard_file'] = $filename;
                        $o['status'] = 'payment_submitted';
                        $o['updated_at'] = date('c');
                    }
                }
                unset($o);
                saveOrders($orders);
                $message = 'Gift card uploaded successfully! Your payment is being verified.';
                $order['status'] = 'payment_submitted';
            }
        }
    } else {
        foreach ($orders as &$o) {
            if ($o['id'] === $orderId) {
                $o['payment_method'] = $method;
                $o['status'] = 'payment_submitted';
                $o['updated_at'] = date('c');
            }
        }
        unset($o);
        saveOrders($orders);
        $message = 'Payment method selected! Please complete your payment using the instructions below.';
        $order['status'] = 'payment_submitted';
    }
}

$paymentIcons = [
    'cashapp' => '💵',
    'paypal' => '🅿️',
    'crypto' => '₿',
    'zelle' => '💳',
    'giftcard' => '🎁',
];

$pageTitle = 'Select Payment — ' . $settings['site_title'];
require __DIR__ . '/includes/header.php';
?>

<div class="form-page">
    <div class="container" style="max-width:800px">
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-row"><span>Order ID</span><span><?= e($order['id']) ?></span></div>
            <div class="summary-row"><span>Vehicle</span><span><?= e($order['car_name']) ?></span></div>
            <div class="summary-row"><span>Name</span><span><?= e($order['full_name']) ?></span></div>
            <div class="summary-row"><span>Delivery To</span><span><?= e($order['city'] . ', ' . $order['country']) ?></span></div>
            <div class="summary-row total"><span>Delivery Fee</span><span class="amount">$<?= (int)$order['fee'] ?></span></div>
        </div>

        <div class="form-card">
            <h1>Select Payment Method</h1>
            <p class="subtitle">Choose how you'd like to pay the one-time delivery fee.</p>

            <?php if ($message): ?>
            <div class="alert alert-success"><?= e($message) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>

            <?php if (empty($payments)): ?>
            <div class="alert alert-error">No payment methods are currently available. Please check back later.</div>
            <?php else: ?>
            <form method="post" enctype="multipart/form-data" id="paymentForm">
                <div class="payment-grid">
                    <?php foreach ($payments as $key => $payment): ?>
                    <label class="payment-card" data-method="<?= e($key) ?>">
                        <input type="radio" name="payment_method" value="<?= e($key) ?>" style="display:none" required>
                        <h3><?= ($paymentIcons[$key] ?? '💰') . ' ' . e($payment['label']) ?></h3>
                        <p><?= e($payment['instructions']) ?></p>
                    </label>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($payments as $key => $payment): ?>
                <div class="payment-details" id="details-<?= e($key) ?>">
                    <h3 style="margin-bottom:12px"><?= e($payment['label']) ?> Payment Details</h3>
                    <p style="margin-bottom:12px"><?= e($payment['instructions']) ?></p>
                    <div style="background:#fff;padding:16px;border-radius:10px;border:1px solid var(--border);font-family:monospace;font-size:15px;word-break:break-all">
                        <?= e($payment['details']) ?>
                    </div>
                    <p style="margin-top:12px;font-size:14px;color:var(--gray)">Amount: <strong style="color:var(--red)">$<?= (int)$order['fee'] ?></strong> · Order ID: <strong><?= e($order['id']) ?></strong></p>

                    <?php if ($key === 'giftcard'): ?>
                    <div class="form-group" style="margin-top:20px">
                        <label>Upload Gift Card Image</label>
                        <input type="file" name="giftcard_image" accept="image/*">
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-block" style="margin-top:24px">Confirm Payment Method →</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
