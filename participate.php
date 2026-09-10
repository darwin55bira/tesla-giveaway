<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$settings = loadSettings();
$selectedCarId = $_GET['car'] ?? 'model-3';
$selectedCar = findCarById($settings, $selectedCarId) ?? $settings['cars'][0];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carId = $_POST['car_id'] ?? '';
    $car = findCarById($settings, $carId);

    if (!$car) {
        $error = 'Please select a valid car model.';
    } elseif (empty(trim($_POST['full_name'] ?? '')) || empty(trim($_POST['email'] ?? ''))) {
        $error = 'Please fill in all required fields.';
    } else {
        $orderId = createOrderId();
        $order = [
            'id' => $orderId,
            'car_id' => $car['id'],
            'car_name' => $car['name'] . ' ' . $car['year'],
            'fee' => $car['fee'],
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'zip' => trim($_POST['zip'] ?? ''),
            'country' => trim($_POST['country'] ?? ''),
            'status' => 'pending_payment',
            'payment_method' => null,
            'created_at' => date('c'),
        ];

        $orders = loadOrders();
        $orders[] = $order;
        saveOrders($orders);

        $_SESSION['current_order_id'] = $orderId;
        header('Location: payment.php?order=' . urlencode($orderId));
        exit;
    }
}

$pageTitle = 'Participate — ' . $settings['site_title'];
require __DIR__ . '/includes/header.php';
?>

<div class="form-page">
    <div class="container">
        <div class="form-card">
            <h1>🎉 You've been selected!</h1>
            <p class="subtitle">Fill in your delivery details.</p>

            <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="form-section-title">Choose Your Tesla Car Model</div>
                <div class="form-group">
                    <select name="car_id" id="carSelect" required>
                        <?php foreach ($settings['cars'] as $car): ?>
                        <option value="<?= e($car['id']) ?>" <?= $car['id'] === $selectedCar['id'] ? 'selected' : '' ?>>
                            <?= e($car['name'] . ' ' . $car['year']) ?> — $<?= (int)$car['fee'] ?> delivery
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-section-title">Personal Information</div>
                <div class="form-group">
                    <input type="text" name="full_name" placeholder="Full Name *" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address *" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Phone Number *" required>
                </div>

                <div class="form-section-title">Delivery Address</div>
                <div class="form-group">
                    <input type="text" name="address" placeholder="Street Address *" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="city" placeholder="City *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="zip" placeholder="ZIP / Postal">
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="country" placeholder="Country *" required>
                </div>

                <button type="submit" class="btn btn-block">Order Now →</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
