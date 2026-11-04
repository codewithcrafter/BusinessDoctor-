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
if (!empty($parsedUri['query'])) {
    parse_str($parsedUri['query'], $qp);
    if (!empty($qp['slug'])) {
        $canonicalParams = '?slug=' . urlencode($qp['slug']);
    }
}
$canonicalUrl = $canonicalUrl ?? (BASE_URL . $cleanPath . $canonicalParams);
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
  <meta name="twitter:image" content="<?= e(BASE_URL . '/assets/img/og-preview.svg') ?>">

  <!-- Structured Data: Schema.org JSON-LD -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "<?= APP_NAME ?>",
    "legalName": "<?= APP_LEGAL_NAME ?>",
    "url": "<?= BASE_URL ?>",
    "description": "<?= APP_TAGLINE ?>",
    "telephone": "<?= APP_PHONE ?>",
    "email": "<?= APP_EMAIL ?>",
    "priceRange": "$$$",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?= APP_HEADQUARTERS ?>"
    },
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "IT & Digital Services Portfolio",
      "itemListElement": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Web & Custom Software Development"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Digital Marketing & Performance SEO"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "UI/UX Design & Brand Identity"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "E-Commerce & Marketplace Management"
          }
        }
      ]
    }
  }
  </script>

  <!-- Typography: Plus Jakarta Sans, Inter, JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Core Stylesheets -->
  <link rel="stylesheet" href="assets/css/variables.css">
  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/responsive.css">

  <!-- Favicon SVG (Code brackets / IT tech icon) -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%230d9488' stroke-width='2.5'><polyline points='16 18 22 12 16 6'/><polyline points='8 6 2 12 8 18'/></svg>">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to main content</a>
<?php require_once __DIR__ . '/navbar.php'; ?>
<main id="main-content">
