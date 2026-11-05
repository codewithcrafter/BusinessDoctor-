<?php
/**
 * BusinessDoctor Global Header Template - IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? APP_NAME . ' — Leading IT Solutions & Digital Services Company';
$pageDescription = $pageDescription ?? 'BusinessDoctor is a full-service IT company specializing in custom web development, digital marketing, SEO, UI/UX design, marketplace management, and cloud solutions.';

// Canonical URL Resolution
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUri = parse_url($requestUri);
$cleanPath = $parsedUri['path'] ?? '/';
$canonicalParams = '';

$prodBase = 'https://businessdoctor.com';
if (defined('BASE_URL') && !empty(BASE_URL)) {
    $parsedHost = parse_url(BASE_URL, PHP_URL_HOST);
    if ($parsedHost && !in_array($parsedHost, ['localhost', '127.0.0.1', '::1', '0.0.0.0'], true) && !str_ends_with($parsedHost, '.local')) {
        $prodBase = rtrim(BASE_URL, '/');
    }
}

if (!empty($parsedUri['query'])) {
    parse_str($parsedUri['query'], $qp);
    if (!empty($qp['slug'])) {
        if (str_contains($cleanPath, 'service-detail') || str_contains($cleanPath, 'services')) {
            $cleanPath = '/services/' . rawurlencode($qp['slug']);
        } elseif (str_contains($cleanPath, 'case-study-detail') || str_contains($cleanPath, 'case-studies')) {
            $cleanPath = '/case-studies/' . rawurlencode($qp['slug']);
        } elseif (str_contains($cleanPath, 'insight-detail') || str_contains($cleanPath, 'blog-detail') || str_contains($cleanPath, 'insights') || str_contains($cleanPath, 'blogs')) {
            $cleanPath = '/insights/' . rawurlencode($qp['slug']);
        } else {
            $canonicalParams = '?slug=' . urlencode($qp['slug']);
        }
    }
}
$canonicalUrl = $canonicalUrl ?? ($prodBase . $cleanPath . $canonicalParams);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta name="theme-color" content="#061326">
  <link rel="canonical" href="<?= e($canonicalUrl) ?>">
  <?php if (!empty($markdownUrl)): ?>
  <link rel="alternate" type="text/markdown" title="Markdown representation" href="<?= e($markdownUrl) ?>">
  <?php endif; ?>

  <!-- Open Graph Protocol -->
  <meta property="og:type" content="<?= e($ogType ?? 'website') ?>">
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($pageDescription) ?>">
  <meta property="og:url" content="<?= e($canonicalUrl) ?>">
  <meta property="og:site_name" content="<?= APP_NAME ?>">
  <meta property="og:image" content="<?= e(BASE_URL . '/assets/img/og-preview.svg') ?>">

  <!-- Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($pageTitle) ?>">
  <meta name="twitter:description" content="<?= e($pageDescription) ?>">
  <meta name="twitter:url" content="<?= e($canonicalUrl) ?>">
  <meta name="twitter:image" content="<?= e(BASE_URL . '/assets/img/og-preview.svg') ?>">

  <!-- Structured Data: Dynamic Schema.org JSON-LD CMS -->
  <?php
  require_once __DIR__ . '/schema-renderer.php';
  echo renderPageSchemas($schemaPageKey ?? null, $schemaContextData ?? []);
  ?>

  <!-- Typography: Plus Jakarta Sans, Inter, JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Core Stylesheets -->
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/components.css">
  <link rel="stylesheet" href="/assets/css/responsive.css">

  <!-- Favicon & Touch Icons -->
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="180x180" href="/assets/img/favicon-180x180.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon-180x180.png">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to main content</a>
<?php require_once __DIR__ . '/navbar.php'; ?>
<main id="main-content">
