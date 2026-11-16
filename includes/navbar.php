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
      <img src="<?= getAssetUrl('assets/img/bdr_logo_transparent.png') ?>" alt="BusinessDoctor Logo" class="brand-logo-img">
    </a>

    <!-- Desktop Navigation Menu -->
    <nav class="nav-menu" aria-label="Main Navigation">
      <a href="<?= appUrl() ?>" class="nav-link <?= isActivePage('index.php') ?>">Home</a>
      <a href="<?= getAboutUrl() ?>" class="nav-link <?= isActivePage('about.php') ?>">About Us</a>

      <!-- Services Mega Menu Parent -->
      <div class="nav-item has-mega-menu">
        <a href="<?= getServicesOverviewUrl() ?>"
          class="nav-link nav-link-dropdown <?= isActivePage('services.php', 'service-detail.php') ?>"
          aria-haspopup="true" aria-expanded="false">
          <span>IT Services</span>
          <svg class="dropdown-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
              clip-rule="evenodd" />
          </svg>
        </a>

        <!-- Mega Menu Flyout Panel -->
        <div class="mega-menu" role="region" aria-label="Services Mega Menu">
          <div class="mega-menu-inner container">
            <!-- Header -->
            <div class="mega-menu-header">
              <div class="mega-header-text">
                <div class="mega-eyebrow-badge">
                  <span class="mega-eyebrow-dot"></span>
                  <span class="mega-eyebrow">OUR SERVICES</span>
                </div>
                <h3 class="mega-heading">Digital &amp; Technology Services</h3>
                <p class="mega-subhead">Explore our specialized digital capabilities engineered to scale modern businesses.</p>
              </div>
              <div class="mega-header-action">
                <a href="<?= getServicesOverviewUrl() ?>" class="mega-overview-btn">
                  <span>Explore All Services</span>
                  <svg class="mega-btn-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- Main Content Grid -->
            <div class="mega-menu-grid">
              <!-- Services List (2 columns of 5 services) -->
              <div class="mega-services-cols">
                <?php
                $megaSlugs = [
                  'smo', 'google-business-profile', 'ppc-paid-ads', 'ecommerce-management',
                  'graphic-design', 'seo', 'social-media-marketing', 'product-photography',
                  'video-editing', 'web-development'
                ];
                foreach ($megaSlugs as $slug):
                  if (!isset($practiceAreas[$slug])) continue;
                  $p = $practiceAreas[$slug];
                ?>
                  <a href="<?= getServiceUrl($slug) ?>" class="mega-service-item">
                    <div class="mega-item-icon"><?= $p['icon'] ?></div>
                    <div class="mega-item-text">
                      <div class="mega-item-title">
                        <span class="mega-item-num"><?= e($p['number']) ?>.</span>
                        <span class="mega-item-name"><?= e($p['name']) ?></span>
                      </div>
                      <p class="mega-item-desc"><?= e($p['summary']) ?></p>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>

              <!-- Mega Menu Highlight / Action Column -->
              <div class="mega-highlight-col">
                <div class="mega-highlight-card">
                  <div class="mega-highlight-body">
                    <div class="pill-tag small" style="margin-bottom: 0.75rem;">
                      <span class="pill-dot"></span>
                      <span>DIGITAL ASSESSMENT</span>
                    </div>
                    <h4 class="mega-highlight-title">Assess Your Technology &amp; Growth Health</h4>
                    <p class="mega-highlight-desc">Uncover bottlenecks in website performance, organic acquisition, and digital conversions.</p>
                  </div>
                  <div class="mega-highlight-action">
                    <a href="<?= getAuditUrl() ?>" class="btn btn-accent btn-sm mega-cta-btn">
                      <span>Free Digital Audit &rarr;</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Bottom Footer -->
            <div class="mega-menu-footer">
              <div class="mega-footer-bar">
                <span class="mega-footer-prompt">Not sure what you need?</span>
                <a href="<?= getContactUrl() ?>" class="mega-footer-cta">
                  <span>Get a Free Consultation &rarr;</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <a href="<?= getAuditUrl() ?>" class="nav-link <?= isActivePage('audit.php', 'diagnostic.php') ?>">Digital Audit</a>
      <a href="<?= appUrl('case-studies') ?>" class="nav-link <?= isActivePage('case-studies.php') ?>">Case Studies</a>
      <a href="<?= getBlogListingUrl() ?>"
        class="nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php') ?>">Blog</a>
      <a href="<?= getContactUrl() ?>" class="nav-link <?= isActivePage('contact.php') ?>">Contact</a>
    </nav>

    <!-- Header Actions -->
    <div class="nav-actions">
      <a href="<?= getContactUrl() ?>" class="btn btn-primary btn-sm">
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
      <a href="<?= getAboutUrl() ?>" class="mobile-nav-link <?= isActivePage('about.php') ?>">About Us</a>

      <!-- 3. IT Services (Expandable Accordion) -->
      <div class="mobile-nav-accordion" id="mobileServicesAccordion">
        <div class="mobile-accordion-row">
          <a href="<?= getServicesOverviewUrl() ?>"
            class="mobile-nav-link mobile-accordion-link <?= isActivePage('services.php', 'service-detail.php') ?>">
            <span>IT Services</span>
          </a>
          <button type="button" class="mobile-accordion-toggle" id="mobileServicesToggle" aria-expanded="false"
            aria-controls="mobileServicesSubmenu" aria-label="Toggle IT Services Submenu">
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
            <div class="mobile-submenu-eyebrow">DIGITAL &amp; TECHNOLOGY SERVICES</div>
            <a href="<?= getServicesOverviewUrl() ?>"
              class="mobile-submenu-link mobile-submenu-overview <?= isActivePage('services.php') ?>">
              <span class="mobile-sublink-num">&rarr;</span>
              <span class="mobile-sublink-name">Overview &ndash; All Services</span>
            </a>
            <?php
            $currentNavSlug = $_GET['slug'] ?? '';
            if ($currentNavSlug === '') {
              $currPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
              if ($currPath && preg_match('#^/(?:services/|company/|)([a-zA-Z0-9_-]+)#', $currPath, $m)) {
                $currentNavSlug = $m[1];
              }
            }
            foreach ($practiceAreas as $slug => $p):
              ?>
              <a href="<?= getServiceUrl($slug) ?>"
                class="mobile-submenu-link <?= ($currentNavSlug === $slug) ? 'active' : '' ?>">
                <span class="mobile-sublink-num"><?= e($p['number']) ?>.</span>
                <span class="mobile-sublink-name"><?= e($p['name']) ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- 4. Digital Audit -->
      <a href="<?= getAuditUrl() ?>"
        class="mobile-nav-link <?= isActivePage('audit.php', 'diagnostic.php') ?>">Digital Audit</a>

      <!-- 5. Case Studies -->
      <a href="<?= appUrl('case-studies') ?>" class="mobile-nav-link <?= isActivePage('case-studies.php') ?>">Case Studies</a>

      <!-- 6. Blog -->
      <a href="<?= getBlogListingUrl() ?>"
        class="mobile-nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php') ?>">Blog</a>

      <!-- 7. Contact -->
      <a href="<?= getContactUrl() ?>" class="mobile-nav-link <?= isActivePage('contact.php') ?>">Contact</a>
    </nav>

    <!-- 8. Start a Project (Primary CTA) & Secondary Action -->
    <div class="mobile-drawer-cta">
      <a href="<?= getContactUrl() ?>" class="btn btn-primary" style="width: 100%;">
        <span>Start a Project</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </a>
      <a href="<?= getAuditUrl() ?>" class="btn btn-secondary" style="width: 100%;">
        <span>Request Free Digital Audit</span>
      </a>
    </div>
  </div>
</aside>