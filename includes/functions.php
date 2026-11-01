<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function findCarById(array $settings, string $id): ?array
{
    foreach ($settings['cars'] as $car) {
        if ($car['id'] === $id) {
            return $car;
        }
    }
    return null;
}

function generateTestimonials(): array
{
    return [
        [
            'name' => 'Michael R.',
            'country' => '🇺🇸 USA',
            'text' => 'I received my VoltDrive Aero 2024! I paid the delivery fee and the car arrived at my door in 9 days. I can\'t believe how real this is!',
            'model' => 'VoltDrive Aero 2024',
        ],
        [
            'name' => 'Sarah K.',
            'country' => '🇬🇧 UK',
            'text' => 'Just received my VoltDrive Terra after paying the delivery fee. I cried when I saw the car parked outside! 🙏',
            'model' => 'VoltDrive Terra 2025',
        ],
        [
            'name' => 'Carlos M.',
            'country' => '🇲🇽 Mexico',
            'text' => 'From Mexico! I received my VoltDrive car after paying the delivery fee. This giveaway is 100% real.',
            'model' => 'VoltDrive Aero 2025',
        ],
        [
            'name' => 'Amara O.',
            'country' => '🇬🇭 Ghana',
            'text' => 'From Ghana 🇬🇭 I paid for the delivery fee and received my VoltDrive car! Thank you VoltDrive!',
            'model' => 'VoltDrive Summit 2025',
        ],
        [
            'name' => 'Yuki T.',
            'country' => '🇯🇵 Japan',
            'text' => 'I was skeptical at first but I paid the delivery fee and received my VoltDrive EV. Amazing!',
            'model' => 'VoltDrive Luxe 2024',
        ],
        [
            'name' => 'Emma W.',
            'country' => '🇨🇦 Canada',
            'text' => 'Paid the delivery fee and within a week my brand new VoltDrive Terra arrived at my door. 🚗⚡',
            'model' => 'VoltDrive Terra 2025',
        ],
    ];
}

function generateLiveDeliveries(array $settings): array
{
    $people = [
        ['James O.', '🇺🇸 USA'], ['Sophie M.', '🇬🇧 UK'], ['Carlos R.', '🇲🇽 Mexico'],
        ['Yuki T.', '🇯🇵 Japan'], ['Emma W.', '🇨🇦 Canada'], ['Lucas B.', '🇧🇷 Brazil'],
        ['Fatima A.', '🇦🇪 UAE'], ['Pierre D.', '🇫🇷 France'], ['Amara N.', '🇿🇦 South Africa'],
        ['Hans M.', '🇩🇪 Germany'],
    ];

    $statuses = [
        'Delivery confirmed ✓', 'Car dispatched 🚚', 'Payment verified ✓',
        'Shipment confirmed ✓', 'Vehicle en route 🚗',
    ];

    $deliveries = [];
    foreach ($people as $index => [$name, $country]) {
        $car = $settings['cars'][$index % count($settings['cars'])];
        $deliveries[] = [
            'name' => $name,
            'country' => $country,
            'car' => $car['name'] . ' ' . $car['year'],
            'status' => $statuses[array_rand($statuses)],
            'fee' => $car['fee'],
            'minutes_ago' => random_int(2, 58),
        ];
    }

    return $deliveries;
}

function generateCommentTestimonials(): array
{
    $comments = [
        ['Mike Johnson', '🇺🇸 USA', 'MJ', 'I received my VoltDrive car!! I paid the delivery fee and within a week my brand new VoltDrive Aero arrived at my door. 🚗⚡', 4821, 2],
        ['Sarah Williams', '🇺🇸 USA', 'SW', 'Just received my VoltDrive car after paying for the delivery fee. I cried when I saw the car parked outside! 🙏', 3244, 1],
        ['Carlos Mendez', '🇲🇽 Mexico', 'CM', 'From Mexico! I received my VoltDrive car after paying the delivery fee. This giveaway is 100% real.', 2918, 3],
        ['David Chen', '🇨🇳 China', 'DC', 'I was skeptical at first but I paid the delivery fee and received my VoltDrive EV. Amazing!', 2611, 2],
        ['Amara Osei', '🇬🇭 Ghana', 'AO', 'From Ghana 🇬🇭 I paid for the delivery fee and received my VoltDrive car! Thank you VoltDrive!', 2403, 1],
    ];

    return array_map(static function (array $c): array {
        return [
            'name' => $c[0],
            'country' => $c[1],
            'initials' => $c[2],
            'text' => $c[3],
            'likes' => $c[4],
            'days_ago' => $c[5],
        ];
    }, $comments);
}

function carImageUrl(string $type): string
{
    $files = [
        'model3' => 'model3.jpg',
        'modely' => 'modely.jpg',
        'models' => 'models.jpg',
        'modelx' => 'modelx.jpg',
        'cybertruck' => 'cybertruck.jpg',
        'roadster' => 'roadster.jpg',
        'model3sr' => 'model3sr.jpg',
        'modelylr' => 'modelylr.jpg',
        'modelsplaid' => 'modelsplaid.jpg',
    ];

    $file = $files[$type] ?? 'model3.jpg';
    return baseUrl('assets/images/cars/' . $file);
}

function carSpecLine(array $car): string
{
    $range = $car['range_short'] ?? $car['range'] ?? '';
    $hp = $car['hp'] ?? '';
    return trim($range . ($hp !== '' ? ' · ' . $hp . 'hp' : ''));
}

function channelAvatarHtml(): string
{
    return '<div class="comment-avatar">VD</div>';
}

function liveToastData(): array
{
    return [
        ['name' => 'James O.', 'country' => '🇺🇸 USA', 'car' => 'VoltDrive Aero 2024', 'fee' => '$299'],
        ['name' => 'Sophie M.', 'country' => '🇬🇧 UK', 'car' => 'VoltDrive Terra 2025', 'fee' => '$349'],
        ['name' => 'Carlos R.', 'country' => '🇲🇽 Mexico', 'car' => 'VoltDrive Aero 2024', 'fee' => '$249'],
        ['name' => 'Yuki T.', 'country' => '🇯🇵 Japan', 'car' => 'VoltDrive Luxe 2025', 'fee' => '$399'],
        ['name' => 'Emma W.', 'country' => '🇨🇦 Canada', 'car' => 'VoltDrive Aero 2025', 'fee' => '$329'],
        ['name' => 'Lucas B.', 'country' => '🇧🇷 Brazil', 'car' => 'VoltDrive Terra 2024', 'fee' => '$289'],
        ['name' => 'Fatima A.', 'country' => '🇦🇪 UAE', 'car' => 'VoltDrive Luxe 2024', 'fee' => '$399'],
        ['name' => 'Pierre D.', 'country' => '🇫🇷 France', 'car' => 'VoltDrive Aero 2025', 'fee' => '$249'],
        ['name' => 'Amara N.', 'country' => '🇿🇦 South Africa', 'car' => 'VoltDrive Terra 2025', 'fee' => '$319'],
        ['name' => 'Hans M.', 'country' => '🇩🇪 Germany', 'car' => 'VoltDrive Aero 2024', 'fee' => '$299'],
        ['name' => 'Raj P.', 'country' => '🇮🇳 India', 'car' => 'VoltDrive Terra 2025', 'fee' => '$349'],
        ['name' => 'Maria G.', 'country' => '🇦🇷 Argentina', 'car' => 'VoltDrive Aero 2024', 'fee' => '$249'],
        ['name' => 'Kevin O.', 'country' => '🇰🇪 Kenya', 'car' => 'VoltDrive Aero 2025', 'fee' => '$329'],
        ['name' => 'Anna S.', 'country' => '🇷🇺 Russia', 'car' => 'VoltDrive Luxe 2025', 'fee' => '$399'],
        ['name' => 'David C.', 'country' => '🇦🇺 Australia', 'car' => 'VoltDrive Hauler 2025', 'fee' => '$319'],
        ['name' => 'Liam M.', 'country' => '🇮🇪 Ireland', 'car' => 'VoltDrive Terra 2024', 'fee' => '$289'],
        ['name' => 'Jin W.', 'country' => '🇰🇷 South Korea', 'car' => 'VoltDrive Aero 2024', 'fee' => '$299'],
        ['name' => 'Thomas B.', 'country' => '🇧🇪 Belgium', 'car' => 'VoltDrive Aero 2025', 'fee' => '$249'],
        ['name' => 'Ingrid H.', 'country' => '🇳🇴 Norway', 'car' => 'VoltDrive Luxe 2024', 'fee' => '$399'],
        ['name' => 'Mei L.', 'country' => '🇸🇬 Singapore', 'car' => 'VoltDrive Terra 2025', 'fee' => '$319'],
        ['name' => 'Pablo M.', 'country' => '🇨🇴 Colombia', 'car' => 'VoltDrive Terra 2025', 'fee' => '$349'],
        ['name' => 'Olga P.', 'country' => '🇵🇱 Poland', 'car' => 'VoltDrive Aero 2025', 'fee' => '$329'],
        ['name' => 'Lars E.', 'country' => '🇸🇪 Sweden', 'car' => 'VoltDrive Aero 2024', 'fee' => '$249'],
        ['name' => 'Sara F.', 'country' => '🇩🇰 Denmark', 'car' => 'VoltDrive Luxe 2025', 'fee' => '$399'],
        ['name' => 'Kwame D.', 'country' => '🇬🇭 Ghana', 'car' => 'VoltDrive Aero 2024', 'fee' => '$299'],
        ['name' => 'Nadia B.', 'country' => '🇲🇦 Morocco', 'car' => 'VoltDrive Terra 2024', 'fee' => '$289'],
        ['name' => 'Rafael C.', 'country' => '🇵🇹 Portugal', 'car' => 'VoltDrive Hauler 2025', 'fee' => '$319'],
        ['name' => 'Hana K.', 'country' => '🇨🇿 Czech Republic', 'car' => 'VoltDrive Terra 2025', 'fee' => '$319'],
        ['name' => 'Viktor N.', 'country' => '🇺🇦 Ukraine', 'car' => 'VoltDrive Aero 2025', 'fee' => '$249'],
        ['name' => 'Celine F.', 'country' => '🇨🇭 Switzerland', 'car' => 'VoltDrive Luxe 2024', 'fee' => '$399'],
    ];
}

function carImageHtml(string $type, string $alt = 'Electric car'): string
{
    return '<img src="' . e(carImageUrl($type)) . '" alt="' . e($alt) . '" class="car-photo" loading="lazy">';
}

function carHeaderTheme(string $type): string
{
    $themes = [
        'model3' => 'theme-navy',
        'modely' => 'theme-blue',
        'models' => 'theme-slate',
        'modelx' => 'theme-charcoal',
        'cybertruck' => 'theme-steel',
        'roadster' => 'theme-crimson',
        'model3sr' => 'theme-teal',
        'modelylr' => 'theme-indigo',
        'modelsplaid' => 'theme-black',
    ];

    return $themes[$type] ?? 'theme-navy';
}
