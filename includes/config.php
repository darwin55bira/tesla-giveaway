<?php
declare(strict_types=1);

// Scam-awareness demo: nothing is stored and nothing is written to disk,
// so the site runs on read-only filesystems and cannot collect anyone's data.

define('BASE_PATH', dirname(__DIR__));

function loadSettings(): array
{
    return [
        'site_title' => 'VoltDrive Giveaway (Scam-Awareness Demo)',
        'brand' => 'VoltDrive',
        'participant_count' => 12847,
        'event_hours' => 11,
        'event_minutes' => 42,
        'event_seconds' => 33,
        'cars' => [
            ['id' => 'aero', 'name' => 'VoltDrive Aero', 'year' => '2025', 'category' => 'Electric Sedan', 'type' => 'Performance Sedan', 'badge' => '🏆 Most Popular', 'sm_badge' => 'Most Popular', 'power' => '510 hp Dual Motor', 'hp' => '510', 'range' => '358 mi Range', 'range_short' => '358mi range', 'delivery_days' => '7–10 Business Days', 'fee' => 299, 'image' => 'model3'],
            ['id' => 'terra', 'name' => 'VoltDrive Terra', 'year' => '2025', 'category' => 'Electric SUV', 'type' => 'Premium SUV', 'badge' => '⚡ Express Delivery', 'sm_badge' => 'Best SUV', 'power' => '384 hp Electric', 'hp' => '384', 'range' => '330 mi Range', 'range_short' => '330mi range', 'delivery_days' => '5–7 Business Days', 'fee' => 349, 'image' => 'modely'],
            ['id' => 'luxe', 'name' => 'VoltDrive Luxe', 'year' => '2025', 'category' => 'Luxury Sedan', 'type' => 'Luxury Flagship', 'badge' => '👑 Premium', 'sm_badge' => 'Premium', 'power' => '670 hp Tri Motor', 'hp' => '670', 'range' => '405 mi Range', 'range_short' => '405mi range', 'delivery_days' => '3–5 Business Days', 'fee' => 399, 'image' => 'models'],
            ['id' => 'summit', 'name' => 'VoltDrive Summit', 'year' => '2025', 'category' => 'Luxury SUV', 'type' => 'Luxury SUV', 'badge' => '💚 Best Value', 'sm_badge' => 'Eco Pick', 'power' => '670 hp Tri Motor', 'hp' => '670', 'range' => '348 mi Range', 'range_short' => '348mi range', 'delivery_days' => '10–14 Business Days', 'fee' => 249, 'image' => 'modelx'],
            ['id' => 'hauler', 'name' => 'VoltDrive Hauler', 'year' => '2025', 'category' => 'Electric Truck', 'type' => 'Electric Truck', 'badge' => '🔥 New Arrival', 'sm_badge' => 'New Arrival', 'power' => '845 hp Tri Motor', 'hp' => '845', 'range' => '340 mi Range', 'range_short' => '340mi range', 'delivery_days' => '5–8 Business Days', 'fee' => 379, 'image' => 'cybertruck'],
            ['id' => 'bolt-gt', 'name' => 'VoltDrive Bolt GT', 'year' => '2025', 'category' => 'Ultra Performance', 'type' => 'Ultra Performance', 'badge' => '💎 Ultra Luxury', 'sm_badge' => 'Ultra Luxury', 'power' => '1000+ hp Electric', 'hp' => '1000+', 'range' => '620 mi Range', 'range_short' => '620mi range', 'delivery_days' => '3–5 Business Days', 'fee' => 499, 'image' => 'roadster'],
            ['id' => 'aero-city', 'name' => 'VoltDrive Aero City', 'year' => '2025', 'category' => 'Electric Sedan', 'type' => 'Standard Range', 'badge' => '🌊 City Special', 'sm_badge' => 'City Special', 'power' => '283 hp RWD', 'hp' => '283', 'range' => '272 mi Range', 'range_short' => '272mi range', 'delivery_days' => '10–14 Business Days', 'fee' => 199, 'image' => 'model3sr'],
            ['id' => 'terra-lr', 'name' => 'VoltDrive Terra LR', 'year' => '2025', 'category' => 'Electric SUV', 'type' => 'Long Range SUV', 'badge' => '👨‍👩‍👧 Family Pick', 'sm_badge' => 'Family Pick', 'power' => '384 hp AWD', 'hp' => '384', 'range' => '330 mi Range', 'range_short' => '330mi range', 'delivery_days' => '7–10 Business Days', 'fee' => 329, 'image' => 'modelylr'],
            ['id' => 'luxe-max', 'name' => 'VoltDrive Luxe Max', 'year' => '2025', 'category' => 'Luxury Sedan', 'type' => 'Performance Sedan', 'badge' => '⭐ Top Rated', 'sm_badge' => 'Top Rated', 'power' => '1020 hp Tri Motor', 'hp' => '1020', 'range' => '396 mi Range', 'range_short' => '396mi range', 'delivery_days' => '5–7 Business Days', 'fee' => 359, 'image' => 'modelsplaid'],
        ],
    ];
}

function baseUrl(string $path = ''): string
{
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $root = preg_replace('#/api$#', '', rtrim($script, '/'));
    return rtrim($root, '/') . '/' . ltrim($path, '/');
}
