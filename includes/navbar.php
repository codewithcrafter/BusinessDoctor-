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
    <a href="index.php" class="brand-logo" aria-label="BusinessDoctor Home">
      <div class="brand-symbol">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="16 18 22 12 16 6"/>
          <polyline points="8 6 2 12 8 18"/>
        </svg>
      </div>
      <span>Business<span class="brand-text-accent">Doctor</span></span>
    </a>

    <!-- Desktop Navigation Menu -->
    <nav class="nav-menu" aria-label="Main Navigation">
      <a href="index.php" class="nav-link <?= isActivePage('index.php') ?>">Home</a>
      <a href="about.php" class="nav-link <?= isActivePage('about.php') ?>">About Us</a>
      
      <!-- Services Mega Menu Parent -->
      <div class="nav-item has-mega-menu">
        <a href="services.php" class="nav-link nav-link-dropdown <?= isActivePage('services.php', 'service-detail.php') ?>" aria-haspopup="true" aria-expanded="false">
          <span>IT Services</span>
          <svg class="dropdown-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
          </svg>
        </a>

        <!-- Mega Menu Flyout Panel -->
        <div class="mega-menu" role="region" aria-label="Services Mega Menu">
          <div class="mega-menu-inner container">
            <div class="mega-menu-header">
              <span class="mega-eyebrow">ENTERPRISE CAPABILITIES</span>
              <p class="mega-subhead">Engineered technology and full-funnel digital capabilities designed for enterprise growth.</p>
            </div>
            
            <div class="mega-menu-grid">
              <!-- Services List (2 columns of 3 services) -->
              <div class="mega-services-cols">
                <?php foreach ($practiceAreas as $slug => $p): ?>
                  <a href="service-detail.php?slug=<?= urlencode($slug) ?>" class="mega-service-item">
                    <div class="mega-item-icon"><?= $p['icon'] ?></div>
                    <div class="mega-item-text">
                      <div class="mega-item-title">
                        <span class="mega-item-num"><?= e($p['number']) ?>.</span>
                        <span><?= e($p['name']) ?></span>
                      </div>
                      <p class="mega-item-desc"><?= e($p['summary']) ?></p>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>

              <!-- Mega Menu Highlight / Action Column -->
              <div class="mega-highlight-col">
                <div class="mega-highlight-card">
                  <div class="pill-tag small">
                    <span class="pill-dot"></span>
                    <span>DIGITAL ASSESSMENT</span>
                  </div>
                  <h4>Assess Your Technology & Growth Health</h4>
                  <p>Uncover bottlenecks in site performance, organic acquisition, and e-commerce conversions with our technical audit.</p>
                  <a href="audit.php" class="btn btn-accent btn-sm">
                    <span>Free Digital Audit</span>
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <line x1="5" y1="12" x2="19" y2="12"/>
                      <polyline points="12 5 19 12 12 19"/>
                    </svg>
                  </a>
                  <div class="mega-highlight-footer">
                    <a href="services.php" class="text-link">Explore All Capabilities &rarr;</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <a href="audit.php" class="nav-link <?= isActivePage('audit.php', 'diagnostic.php') ?>">Digital Audit</a>
      <a href="case-studies.php" class="nav-link <?= isActivePage('case-studies.php') ?>">Case Studies</a>
      <a href="insights.php" class="nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php') ?>">Blog</a>
      <a href="contact.php" class="nav-link <?= isActivePage('contact.php') ?>">Contact</a>
    </nav>

    <!-- Header Actions -->
    <div class="nav-actions">
      <a href="contact.php" class="btn btn-primary btn-sm">
        <span>Start a Project</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
      
      <!-- Mobile Hamburger Toggle -->
      <button class="menu-toggle" aria-label="Toggle mobile navigation menu" aria-expanded="false" aria-controls="mobileDrawer" id="menuToggleBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Drawer Backdrop Overlay -->
<div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop" aria-hidden="true"></div>

<!-- Mobile Drawer Menu -->
<aside class="mobile-drawer" id="mobileDrawer" role="dialog" aria-modal="true" aria-label="Mobile Navigation Menu" aria-hidden="true">
  <div class="mobile-drawer-topbar">
    <div class="mobile-drawer-badge">
      <span class="mobile-drawer-dot"></span>
      <span class="mobile-drawer-label">NAVIGATION</span>
    </div>
    <button type="button" class="mobile-drawer-close" id="mobileDrawerCloseBtn" aria-label="Close navigation menu">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
      <span>Close</span>
    </button>
  </div>

  <div class="mobile-drawer-content mobile-drawer-scroll-body" id="mobileDrawerScrollBody">
    <nav class="mobile-nav-list" aria-label="Mobile Main Navigation">
      <!-- 1. Home -->
      <a href="index.php" class="mobile-nav-link <?= isActivePage('index.php') ?>">Home</a>

      <!-- 2. About Us -->
      <a href="about.php" class="mobile-nav-link <?= isActivePage('about.php') ?>">About Us</a>

      <!-- 3. IT Services (Expandable Accordion) -->
      <div class="mobile-nav-accordion" id="mobileServicesAccordion">
        <div class="mobile-accordion-row">
          <a href="services.php" class="mobile-nav-link mobile-accordion-link <?= isActivePage('services.php', 'service-detail.php') ?>">
            <span>IT Services</span>
          </a>
          <button type="button" class="mobile-accordion-toggle" id="mobileServicesToggle" aria-expanded="false" aria-controls="mobileServicesSubmenu" aria-label="Toggle IT Services Submenu">
            <span class="accordion-toggle-text">Expand</span>
            <svg class="mobile-accordion-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>

        <div class="mobile-submenu-panel" id="mobileServicesSubmenu" role="region" aria-labelledby="mobileServicesToggle">
          <div class="mobile-submenu-inner">
            <div class="mobile-submenu-eyebrow">ENTERPRISE CAPABILITIES</div>
            <a href="services.php" class="mobile-submenu-link mobile-submenu-overview <?= isActivePage('services.php') ?>">
              <span class="mobile-sublink-num">&rarr;</span>
              <span class="mobile-sublink-name">Overview &ndash; All IT Services</span>
            </a>
            <?php foreach ($practiceAreas as $slug => $p): ?>
              <a href="service-detail.php?slug=<?= urlencode($slug) ?>" class="mobile-submenu-link <?= (isset($_GET['slug']) && $_GET['slug'] === $slug) ? 'active' : '' ?>">
                <span class="mobile-sublink-num"><?= e($p['number']) ?>.</span>
                <span class="mobile-sublink-name"><?= e($p['name']) ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- 4. Digital Audit -->
      <a href="audit.php" class="mobile-nav-link <?= isActivePage('audit.php', 'diagnostic.php') ?>">Digital Audit</a>

      <!-- 5. Case Studies -->
      <a href="case-studies.php" class="mobile-nav-link <?= isActivePage('case-studies.php') ?>">Case Studies</a>

      <!-- 6. Blog -->
      <a href="insights.php" class="mobile-nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php') ?>">Blog</a>

      <!-- 7. Contact -->
      <a href="contact.php" class="mobile-nav-link <?= isActivePage('contact.php') ?>">Contact</a>
    </nav>

    <!-- 8. Start a Project (Primary CTA) & Secondary Action -->
    <div class="mobile-drawer-cta">
      <a href="contact.php" class="btn btn-primary" style="width: 100%;">
        <span>Start a Project</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
      <a href="audit.php" class="btn btn-secondary" style="width: 100%;">
        <span>Request Free Digital Audit</span>
      </a>
    </div>
  </div>
</aside>
