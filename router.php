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

// 3. Clean Services Overview: /company-in-delhi -> services.php
if (preg_match('#^/company-in-delhi/?$#', $uri)) {
    require __DIR__ . '/services.php';
    return true;
}

// 4. Clean Individual Service URLs: /{slug}-company-in-delhi -> service-detail.php?slug={slug}
if (preg_match('#^/([a-zA-Z0-9_-]+)-company-in-delhi/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/service-detail.php';
    return true;
}

// 5. Clean Blog Listing: /blog -> insights.php
if (preg_match('#^/blog/?$#', $uri)) {
    require __DIR__ . '/insights.php';
    return true;
}

// 6. Clean Individual Blog URLs: /blog/{slug} -> insight-detail.php?slug={slug}
if (preg_match('#^/blog/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/insight-detail.php';
    return true;
}

// 7. Legacy Service 301 Permanent Redirects
if (preg_match('#^/(?:services|company)/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $s = strtolower($matches[1]);
    $legacyMap = [
        'seo-services' => 'seo',
        'smo-services' => 'smo',
        'digital-marketing' => 'social-media-marketing',
        'strategic-consulting' => 'web-development',
        'digital-engineering' => 'web-development',
        'performance-marketing' => 'seo',
        'brand-architecture' => 'graphic-design',
        'brand-creative-direction' => 'graphic-design',
        'ecommerce-acceleration' => 'ecommerce-management',
        'creative-production' => 'video-editing',
        'web-software-development' => 'web-development',
        'ai-automation-workflows' => 'web-development',
        'digital-marketing-seo' => 'seo',
        'ui-ux-branding' => 'graphic-design',
        'ecommerce-marketplaces' => 'ecommerce-management',
        'creative-video-production' => 'video-editing',
        'cloud-it-consulting' => 'web-development',
    ];
    $targetSlug = $legacyMap[$s] ?? $s;
    header("Location: /" . $targetSlug . "-company-in-delhi", true, 301);
    return true;
}
if (preg_match('#^/(?:services|company)/?$#', $uri) || $uri === '/services.php') {
    header("Location: /company-in-delhi", true, 301);
    return true;
}

// 8. Legacy Blog 301 Permanent Redirects
if (preg_match('#^/insights/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    header("Location: /blog/" . $matches[1], true, 301);
    return true;
}
if (preg_match('#^/insights/?$#', $uri) || $uri === '/insights.php') {
    header("Location: /blog", true, 301);
    return true;
}

// 9. Clean Case Study URLs: /case-studies/{slug} -> case-study-detail.php?slug={slug}
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
