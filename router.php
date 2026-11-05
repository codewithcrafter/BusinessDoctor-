<?php
/**
 * BusinessDoctor Built-in PHP Server Router
 * Usage: php -S localhost:8000 router.php
 */

declare(strict_types=1);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// 1. Clean Admin Controller Route: /admin or /admin/ (Login & Dashboard)
if ($uri === '/admin' || $uri === '/admin/') {
    require __DIR__ . '/admin/index.php';
    return true;
}

// 2. Serve existing physical files directly (CSS, JS, images, PHP scripts)
$filePath = __DIR__ . $uri;
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

// 3. Clean Services routing: /services/{slug} and /services
if (preg_match('#^/services/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/service-detail.php';
    return true;
}
if ($uri === '/services' || $uri === '/services/') {
    require __DIR__ . '/services.php';
    return true;
}

// 4. Clean Case Studies routing: /case-studies/{slug} and /case-studies
if (preg_match('#^/case-studies/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/case-study-detail.php';
    return true;
}
if ($uri === '/case-studies' || $uri === '/case-studies/') {
    require __DIR__ . '/case-studies.php';
    return true;
}

// 5. Clean Insights / Blogs routing: /insights/{slug} or /blogs/{slug}
if (preg_match('#^/(?:insights|blogs)/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/insight-detail.php';
    return true;
}
if ($uri === '/insights' || $uri === '/insights/' || $uri === '/blogs' || $uri === '/blogs/') {
    require __DIR__ . '/insights.php';
    return true;
}

// 6. Direct PHP script without .php extension (e.g. /about -> /about.php)
$cleanPhp = __DIR__ . '/' . trim($uri, '/') . '.php';
if (file_exists($cleanPhp) && !is_dir($cleanPhp)) {
    require $cleanPhp;
    return true;
}

// 7. Homepage
if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

// 8. 404 Not Found fallback
http_response_code(404);
echo "404 Not Found";
return true;

