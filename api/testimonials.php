<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

echo json_encode([
    'testimonials' => generateTestimonials(),
    'comments' => generateCommentTestimonials(),
]);
