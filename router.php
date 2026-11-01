<?php
declare(strict_types=1);

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if ($uri === '/health' || $uri === '/healthz') {
    header('Content-Type: text/plain');
    echo "ok";
    return true;
}

if (preg_match('#^/data(/|$)#', $uri) === 1) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

$file = __DIR__ . $uri;
if ($uri !== '/' && is_file($file)) {
    return false;
}

if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

return false;
