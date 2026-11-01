<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$settings = loadSettings();
$selectedCarId = $_GET['car'] ?? 'aero';
$selectedCar = findCarById($settings, $selectedCarId) ?? $settings['cars'][0];

$pageTitle = 'Participate — ' . $settings['site_title'];
require __DIR__ . '/includes/header.php';
?>

<div class="form-page">
    <div class="container">
        <div class="form-card">
            <h1>🎉 You've been selected!</h1>
            <p class="subtitle">Fill in your delivery details.</p>

            <div class="alert alert-error">Demo only: don't enter real details. Nothing on this form is saved or sent.</div>

            <form method="get" action="payment.php">
                <div class="form-section-title">Choose Your Car Model</div>
                <div class="form-group">
                    <select name="car" id="carSelect" required>
                        <?php foreach ($settings['cars'] as $car): ?>
                        <option value="<?= e($car['id']) ?>" <?= $car['id'] === $selectedCar['id'] ? 'selected' : '' ?>>
                            <?= e($car['name'] . ' ' . $car['year']) ?> — $<?= (int)$car['fee'] ?> delivery
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-section-title">Personal Information</div>
                <div class="form-group">
                    <input type="text" placeholder="Full Name *" required>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Email Address *" required>
                </div>
                <div class="form-group">
                    <input type="tel" placeholder="Phone Number *" required>
                </div>

                <div class="form-section-title">Delivery Address</div>
                <div class="form-group">
                    <input type="text" placeholder="Street Address *" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" placeholder="City *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="ZIP / Postal">
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Country *" required>
                </div>

                <button type="submit" class="btn btn-block">Order Now →</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
