<?php
/**
 * BusinessDoctor Executive Navigation Bar - Enterprise IT & Digital Solutions
 */

declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$practiceAreas = getPracticeAreas();
?>
<header class="site-header" id="siteHeader">
  <div class="container navbar">
    <!-- Brand Logo -->
    <a href="<?= appUrl() ?>" class="brand-logo" aria-label="BusinessDoctor Home">
      <img src="<?= getAssetUrl('assets/img/bdr_logo_transparent.png') ?>" alt="BusinessDoctor Logo" class="brand-logo-img" width="1816" height="1131">
    </a>

    <!-- Desktop Navigation Menu -->
    <nav class="nav-menu" aria-label="Main Navigation">
      <a href="<?= appUrl() ?>" class="nav-link <?= isActivePage('index.php') ?>">Home</a>
      <a href="<?= appUrl('about') ?>" class="nav-link <?= isActivePage('about.php', 'about') ?>">About Us</a>

      <!-- Services Mega Menu Parent -->
      <div class="nav-item has-mega-menu" id="servicesNavItem">
        <a href="<?= getServicesOverviewUrl() ?>"
          class="nav-link nav-link-dropdown <?= isActivePage('services.php', 'service-detail.php') ?>"
          aria-haspopup="true" aria-expanded="false" id="servicesDropdownTrigger">
          <span>Services</span>
          <svg class="dropdown-chevron" viewBox="0 0 20 20" width="16" height="16" fill="currentColor" aria-hidden="true" style="width: 16px !important; height: 16px !important; min-width: 16px !important; min-height: 16px !important; max-width: 16px !important; max-height: 16px !important; flex-shrink: 0 !important;">
            <path fill-rule="evenodd"
              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
              clip-rule="evenodd" />
          </svg>
        </a>

        <!-- Mega Menu Flyout Panel (Clean Services Navigation) -->
        <div class="mega-menu" role="region" aria-label="Digital Marketing Services">
          <div class="mega-menu-inner">
            <!-- Header -->
            <div class="mega-menu-topbar">
              <div class="mega-menu-header-text">
                <span class="mega-menu-title">Digital Marketing Services</span>
                <p class="mega-menu-subtitle">Targeted growth solutions for businesses in Delhi NCR</p>
              </div>
              <a href="<?= getServicesOverviewUrl() ?>" class="mega-menu-overview-btn" aria-label="Services Overview">
                <span>Overview</span>
                <svg viewBox="0 0 20 20" width="15" height="15" fill="currentColor" class="mega-overview-icon" aria-hidden="true" style="width: 15px !important; height: 15px !important; min-width: 15px !important; min-height: 15px !important; max-width: 15px !important; max-height: 15px !important; flex-shrink: 0 !important; display: inline-block !important;">
                  <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>

            <!-- Spacious 2-Column Services Grid -->
            <div class="mega-services-grid" style="background: #071A2C !important;">
              <?php foreach ($practiceAreas as $slug => $p): 
                $displayTitle = ($slug === 'smo') ? 'SMO' : $p['name'];
                $iconSvg = $p['icon'];
                // Ensure SVG strictly has width, height and cannot blow out layout
                $iconSvg = preg_replace('/\s+(width|height)=["\'][^"\']*["\']/i', '', $iconSvg);
                $iconSvg = preg_replace('/<svg\b/i', '<svg width="18" height="18" style="width: 18px !important; height: 18px !important; min-width: 18px !important; min-height: 18px !important; max-width: 18px !important; max-height: 18px !important; flex-shrink: 0 !important; display: block !important;"', $iconSvg);
              ?>
                <a href="<?= getServiceUrl($slug) ?>" class="mega-service-card">
                  <div class="mega-icon-circle" style="width: 38px !important; height: 38px !important; min-width: 38px !important; min-height: 38px !important; max-width: 38px !important; max-height: 38px !important; overflow: hidden !important; flex-shrink: 0 !important;">
                    <?= $iconSvg ?>
                  </div>
                  <div class="mega-service-info">
                    <span class="mega-service-name" style="color: #FFFFFF !important;"><?= e($displayTitle) ?></span>
                    <p class="mega-service-desc" style="color: #8FA3B8 !important;"><?= e($p['summary']) ?></p>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>

            <!-- Footer Strip -->
            <div class="mega-menu-bottom-bar">
              <span class="mega-footer-question">Not sure what you need?</span>
              <a href="<?= appUrl('contact') ?>" class="mega-footer-action">
                <span>Get a Free Consultation</span>
                <svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor" class="mega-footer-arrow" aria-hidden="true" style="width: 16px !important; height: 16px !important; min-width: 16px !important; min-height: 16px !important; max-width: 16px !important; max-height: 16px !important; flex-shrink: 0 !important; display: inline-block !important;">
                  <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <a href="<?= appUrl('audit') ?>" class="nav-link <?= isActivePage('audit.php', 'diagnostic.php', 'audit') ?>">Digital
        Audit</a>
      <a href="<?= appUrl('case-studies') ?>" class="nav-link <?= isActivePage('case-studies.php', 'case-studies') ?>">Case
        Studies</a>
      <a href="<?= getBlogListingUrl() ?>"
        class="nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php', 'blog', 'insights') ?>">Blog</a>
      <a href="<?= appUrl('contact') ?>" class="nav-link <?= isActivePage('contact.php', 'contact') ?>">Contact</a>
    </nav>

    <!-- Header Actions -->
    <div class="nav-actions">
      <a href="<?= appUrl('contact') ?>" class="btn btn-primary btn-sm">
        <span>Start a Project</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </a>

      <!-- Mobile Hamburger Toggle -->
      <button class="menu-toggle" aria-label="Toggle mobile navigation menu" aria-expanded="false"
        aria-controls="mobileDrawer" id="menuToggleBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <line x1="3" y1="12" x2="21" y2="12" />
          <line x1="3" y1="6" x2="21" y2="6" />
          <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Drawer Backdrop Overlay -->
<div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop" aria-hidden="true"></div>

<!-- Mobile Drawer Menu -->
<aside class="mobile-drawer" id="mobileDrawer" role="dialog" aria-modal="true" aria-label="Mobile Navigation Menu"
  aria-hidden="true">
  <div class="mobile-drawer-topbar">
    <div class="mobile-drawer-badge">
      <span class="mobile-drawer-dot"></span>
      <span class="mobile-drawer-label">NAVIGATION</span>
    </div>
    <button type="button" class="mobile-drawer-close" id="mobileDrawerCloseBtn" aria-label="Close navigation menu">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
        stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
      <span>Close</span>
    </button>
  </div>

  <div class="mobile-drawer-content mobile-drawer-scroll-body" id="mobileDrawerScrollBody">
    <nav class="mobile-nav-list" aria-label="Mobile Main Navigation">
      <!-- 1. Home -->
      <a href="<?= appUrl() ?>" class="mobile-nav-link <?= isActivePage('index.php') ?>">Home</a>

      <!-- 2. About Us -->
      <a href="<?= appUrl('about') ?>" class="mobile-nav-link <?= isActivePage('about.php', 'about') ?>">About Us</a>

      <!-- 3. IT Services (Expandable Accordion) -->
      <div class="mobile-nav-accordion" id="mobileServicesAccordion">
        <div class="mobile-accordion-row">
          <a href="<?= getServicesOverviewUrl() ?>"
            class="mobile-nav-link mobile-accordion-link <?= isActivePage('services.php', 'service-detail.php', 'services', 'service') ?>">
            <span>Services</span>
          </a>
          <button type="button" class="mobile-accordion-toggle" id="mobileServicesToggle" aria-expanded="false"
            aria-controls="mobileServicesSubmenu" aria-label="Toggle Services Submenu">
            <span class="accordion-toggle-text">Expand</span>
            <svg class="mobile-accordion-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
            </svg>
          </button>
        </div>

        <div class="mobile-submenu-panel" id="mobileServicesSubmenu" role="region"
          aria-labelledby="mobileServicesToggle">
          <div class="mobile-submenu-inner">
            <div class="mobile-submenu-eyebrow">DIGITAL MARKETING SERVICES</div>
            <a href="<?= getServicesOverviewUrl() ?>"
              class="mobile-submenu-link mobile-submenu-overview <?= isActivePage('services.php', 'services') ?>">
              <span class="mobile-sublink-num">&rarr;</span>
              <span class="mobile-sublink-name">Overview &ndash; All 10 Services</span>
            </a>
            <?php
            $currentNavSlug = $_GET['slug'] ?? '';
            if ($currentNavSlug === '') {
              $currPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
              if ($currPath && preg_match('#^/service/([a-zA-Z0-9_-]+)#', $currPath, $m)) {
                $currentNavSlug = ($m[1] === 'ppc') ? 'ppc-paid-ads' : $m[1];
              } elseif ($currPath && preg_match('#^/([a-zA-Z0-9_-]+)-company-in-delhi#', $currPath, $m)) {
                $currentNavSlug = ($m[1] === 'ppc') ? 'ppc-paid-ads' : $m[1];
              }
            }
            foreach ($practiceAreas as $slug => $p):
              $displayTitle = ($slug === 'smo') ? 'SMO' : $p['name'];
              ?>
              <a href="<?= getServiceUrl($slug) ?>"
                class="mobile-submenu-link <?= ($currentNavSlug === $slug) ? 'active' : '' ?>">
                <span class="mobile-sublink-num"><?= e($p['number']) ?>.</span>
                <span class="mobile-sublink-name"><?= e($displayTitle) ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- 4. Digital Audit -->
      <a href="<?= appUrl('audit') ?>"
        class="mobile-nav-link <?= isActivePage('audit.php', 'diagnostic.php', 'audit') ?>">Digital Audit</a>

      <!-- 5. Case Studies -->
      <a href="<?= appUrl('case-studies') ?>" class="mobile-nav-link <?= isActivePage('case-studies.php', 'case-studies') ?>">Case
        Studies</a>

      <!-- 6. Blog -->
      <a href="<?= getBlogListingUrl() ?>"
        class="mobile-nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php', 'blog', 'insights') ?>">Blog</a>

      <!-- 7. Contact -->
      <a href="<?= appUrl('contact') ?>" class="mobile-nav-link <?= isActivePage('contact.php', 'contact') ?>">Contact</a>
    </nav>

    <!-- 8. Start a Project (Primary CTA) & Secondary Action -->
    <div class="mobile-drawer-cta">
      <a href="<?= appUrl('contact') ?>" class="btn btn-primary" style="width: 100%;">
        <span>Start a Project</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </a>
      <a href="<?= appUrl('audit') ?>" class="btn btn-secondary" style="width: 100%;">
        <span>Request Free Digital Audit</span>
      </a>
    </div>
  </div>
</aside>