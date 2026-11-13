<?php
// BusinessDoctor PHP Built-in Server Router for Local Development
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

// 1. Static physical files (excluding directories)
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    if (str_ends_with($uri, '.md')) {
        header('Content-Type: text/markdown; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');
        header('X-Robots-Tag: index, follow');
        readfile($file);
        return true;
    }
    return false; // serve directly
}

// ============================================================
// Universal Markdown Request Interception (*.md, /.md, /md)
// ============================================================
if (str_ends_with($uri, '.md') || $uri === '/.md' || $uri === '/md' || $uri === '/md/' || str_starts_with($uri, '/md/')) {
    require_once __DIR__ . '/includes/markdown-router.php';
    MarkdownRouter::handleRequest($_SERVER['REQUEST_URI']);
    return true;
}

// 2. Admin clean URL handling
if ($uri === '/admin' || $uri === '/admin/') {
    require __DIR__ . '/admin/index.php';
    return true;
}

if (str_starts_with($uri, '/admin/')) {
    $adminScript = __DIR__ . $uri . '.php';
    if (file_exists($adminScript)) {
        require $adminScript;
        return true;
    }
}

// 3. Clean Service URLs: /services/{slug} -> service-detail.php?slug={slug}
if (preg_match('#^/services/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/service-detail.php';
    return true;
}

// 4. Clean Services Index: /services -> services.php
if (preg_match('#^/services/?$#', $uri)) {
    require __DIR__ . '/services.php';
    return true;
}

// Clean Insight URLs: /insights/{slug} -> insight-detail.php?slug={slug}
if (preg_match('#^/insights/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/insight-detail.php';
    return true;
}
if (preg_match('#^/insights/?$#', $uri)) {
    require __DIR__ . '/insights.php';
    return true;
}

// Clean Case Study URLs: /case-studies/{slug} -> case-study-detail.php?slug={slug}
if (preg_match('#^/case-studies/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/case-study-detail.php';
    return true;
}
if (preg_match('#^/case-studies/?$#', $uri)) {
    require __DIR__ . '/case-studies.php';
    return true;
}

// 5. Home
if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

// 6. Direct PHP extension fallback (e.g. /about -> about.php)
if (file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    return true;
}

return false;
