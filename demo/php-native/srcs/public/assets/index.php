<?php
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/surreal.jpg';
$imageUrl  = '/assets/img/surreal.jpg';

$availableTypes = [
    'text/html'  => 'text/html',
    'image/avif' => 'image/avif',
    'image/webp' => 'image/webp',
    'image/jpeg' => 'image/jpeg',
    'image/png'  => 'image/png',
    'image/svg+xml' => 'image/svg+xml',
];

function parseAcceptHeader(string $header): array {
    $types = explode(',', $header);
    $parsed = [];
    foreach ($types as $type) {
        $parts = explode(';', trim($type));
        $mime = trim($parts[0]);
        $q = 1.0;
        if (isset($parts[1]) && str_starts_with(trim($parts[1]), 'q=')) {
            $q = floatval(substr(trim($parts[1]), 2));
        }
        $parsed[$mime] = $q;
    }
    arsort($parsed);
    return $parsed;
}

$acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';
$acceptedTypes = parseAcceptHeader($acceptHeader);

foreach ($acceptedTypes as $mime => $q) {
    if ($q <= 0) continue;
    foreach ($availableTypes as $ourMime) {
        if ($mime === $ourMime || $mime === '*/*' || ($mime === 'image/*' && str_starts_with($ourMime, 'image/'))) {
            if ($ourMime === 'text/html') {
                include __DIR__ . '/template.php';
                exit;
            } else {
                if (!file_exists($imagePath)) {
                    http_response_code(404);
                    echo 'Image non trouvée';
                    exit;
                }
                header('Content-Type: ' . $ourMime);
                header('Content-Length: ' . filesize($imagePath));
                readfile($imagePath);
                exit;
            }
        }
    }
}

http_response_code(406);
echo 'Type non acceptable';
exit;
