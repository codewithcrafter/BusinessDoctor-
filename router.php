<?php
// BusinessDoctor PHP Built-in Server Router for Local Development
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

// ============================================================
// Universal Discovery & Markdown Request Interception (*.md, /llms.txt, /sitemap.xml)
// ============================================================
if (str_ends_with($uri, '.md') || in_array($uri, ['/.md', '/md', '/md/', '/llms.txt', '/sitemap.xml'], true) || str_starts_with($uri, '/md/')) {
    require_once __DIR__ . '/includes/markdown-router.php';
    MarkdownRouter::handleRequest($_SERVER['REQUEST_URI']);
    return true;
}

// 1. Admin clean URL handling
if ($uri === '/admin' || $uri === '/admin/') {
    require __DIR__ . '/admin/index.php';
    return true;
}

if (str_starts_with($uri, '/admin/')) {
    $adminScript = __DIR__ . $uri;
    if (file_exists($adminScript) && !is_dir($adminScript)) {
        return false;
    }
    if (file_exists($adminScript . '.php')) {
        require $adminScript . '.php';
        return true;
    }
}

// 2. 301 Permanent Redirects for any public .php URLs (Clean URL Enforcement)
if (str_ends_with($uri, '.php') && !str_starts_with($uri, '/admin/') && !str_starts_with($uri, '/api/')) {
    require_once __DIR__ . '/includes/functions.php';
    $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

    if ($uri === '/index.php') {
        header("Location: /" . $qs, true, 301);
        exit;
    }
    if ($uri === '/services.php') {
        header("Location: /services" . $qs, true, 301);
        exit;
    }
    if ($uri === '/service-detail.php') {
        $slug = trim($_GET['slug'] ?? '');
        if ($slug !== '') {
            $target = getServiceUrl($slug);
            header("Location: " . parse_url($target, PHP_URL_PATH), true, 301);
        } else {
            header("Location: /services", true, 301);
        }
        exit;
    }
    if ($uri === '/insights.php') {
        header("Location: /blog" . $qs, true, 301);
        exit;
    }
    if ($uri === '/insight-detail.php') {
        $slug = trim($_GET['slug'] ?? '');
        if ($slug !== '') {
            header("Location: /blog/" . rawurlencode($slug), true, 301);
        } else {
            header("Location: /blog", true, 301);
        }
        exit;
    }
    if ($uri === '/case-studies.php') {
        header("Location: /case-studies" . $qs, true, 301);
        exit;
    }
    if ($uri === '/case-study-detail.php') {
        $slug = trim($_GET['slug'] ?? '');
        if ($slug !== '') {
            header("Location: /case-studies/" . rawurlencode($slug), true, 301);
        } else {
            header("Location: /case-studies", true, 301);
        }
        exit;
    }
    if ($uri === '/audit.php' || $uri === '/diagnostic.php') {
        header("Location: /audit" . $qs, true, 301);
        exit;
    }
    if ($uri === '/about.php') {
        header("Location: /about" . $qs, true, 301);
        exit;
    }
    if ($uri === '/contact.php') {
        header("Location: /contact" . $qs, true, 301);
        exit;
    }

    // Generic public .php -> clean URL
    $cleanPath = substr($uri, 0, -4);
    header("Location: " . $cleanPath . $qs, true, 301);
    exit;
}

// 3. Static physical files (assets, images, scripts, etc. - excluding .php handled above)
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // serve directly
}

// 4. Standardized Service URLs: /service/{slug} -> service-detail.php?slug={slug}
if (preg_match('#^/service/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    require_once __DIR__ . '/includes/functions.php';
    $rawSlug = $matches[1];
    $targetUrl = getServiceUrl($rawSlug);
    $targetPath = parse_url($targetUrl, PHP_URL_PATH);
    if ($uri !== $targetPath) {
        $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
        header("Location: " . $targetPath . $qs, true, 301);
        return true;
    }
    $_GET['slug'] = $rawSlug;
    require __DIR__ . '/service-detail.php';
    return true;
}

// 5. Legacy Service 301 Permanent Redirects to /service/{slug} or /services
// /{slug}-company-in-delhi -> /service/{slug}
if (preg_match('#^/([a-zA-Z0-9_-]+)-company-in-delhi/?$#', $uri, $matches)) {
    require_once __DIR__ . '/includes/functions.php';
    $rawSlug = $matches[1];
    $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    if ($rawSlug === 'digital-marketing') {
        header("Location: /services" . $qs, true, 301);
        return true;
    }
    $targetUrl = getServiceUrl($rawSlug);
    $targetPath = parse_url($targetUrl, PHP_URL_PATH);
    header("Location: " . $targetPath . $qs, true, 301);
    return true;
}

// /company/{slug} and /services/{slug} -> /service/{slug}
if (preg_match('#^/(?:company|services)/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    require_once __DIR__ . '/includes/functions.php';
    $targetUrl = getServiceUrl($matches[1]);
    $targetPath = parse_url($targetUrl, PHP_URL_PATH);
    $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header("Location: " . $targetPath . $qs, true, 301);
    return true;
}

// /digital-marketing-company-in-delhi, /company-in-delhi, /company -> /services
if (preg_match('#^/(?:digital-marketing-company-in-delhi|company-in-delhi|company)/?$#', $uri)) {
    $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header("Location: /services" . $qs, true, 301);
    return true;
}

// Clean Services Overview: /services
if ($uri === '/services' || $uri === '/services/') {
    require __DIR__ . '/services.php';
    return true;
}

// 6. Clean Blog Listing & Articles: /blog and /blog/{slug}
if ($uri === '/blog' || $uri === '/blog/') {
    require __DIR__ . '/insights.php';
    return true;
}

if (preg_match('#^/blog/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/insight-detail.php';
    return true;
}

// Legacy Blog 301 Permanent Redirects (/insights and /insights/{slug} -> /blog and /blog/{slug})
if (preg_match('#^/insights/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header("Location: /blog/" . $matches[1] . $qs, true, 301);
    return true;
}
if ($uri === '/insights' || $uri === '/insights/') {
    $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    header("Location: /blog" . $qs, true, 301);
    return true;
}

// 7. Clean Case Study URLs: /case-studies and /case-studies/{slug}
if (preg_match('#^/case-studies/([a-zA-Z0-9_-]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/case-study-detail.php';
    return true;
}
if ($uri === '/case-studies' || $uri === '/case-studies/') {
    require __DIR__ . '/case-studies.php';
    return true;
}

// 8. Clean Core Public Pages (/about, /contact, /audit)
if ($uri === '/about' || $uri === '/about/') {
    require __DIR__ . '/about.php';
    return true;
}

if ($uri === '/contact' || $uri === '/contact/') {
    require __DIR__ . '/contact.php';
    return true;
}

if ($uri === '/audit' || $uri === '/audit/' || $uri === '/diagnostic' || $uri === '/diagnostic/') {
    require __DIR__ . '/audit.php';
    return true;
}

// 9. Home Page
if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

// 10. Direct PHP extension fallback (e.g. /terms -> terms.php)
if (file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    return true;
}

return false;
