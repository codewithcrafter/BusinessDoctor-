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
      <button class="menu-toggle" aria-label="Toggle mobile navigation menu" aria-expanded="false" id="menuToggleBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Drawer Menu -->
  <div class="mobile-drawer" id="mobileDrawer" aria-label="Mobile Navigation">
    <div class="mobile-drawer-content">
      <a href="index.php" class="mobile-nav-link <?= isActivePage('index.php') ?>">Home</a>
      <a href="about.php" class="mobile-nav-link <?= isActivePage('about.php') ?>">About BusinessDoctor</a>
      
      <div class="mobile-nav-group">
        <div class="mobile-nav-label">IT & DIGITAL CAPABILITIES</div>
        <?php foreach ($practiceAreas as $slug => $p): ?>
          <a href="service-detail.php?slug=<?= urlencode($slug) ?>" class="mobile-nav-sublink">
            <span class="mobile-sublink-num"><?= e($p['number']) ?></span>
            <span><?= e($p['name']) ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <a href="audit.php" class="mobile-nav-link <?= isActivePage('audit.php', 'diagnostic.php') ?>">Free Digital Audit</a>
      <a href="case-studies.php" class="mobile-nav-link <?= isActivePage('case-studies.php') ?>">Client Case Studies</a>
      <a href="insights.php" class="mobile-nav-link <?= isActivePage('insights.php', 'insight-detail.php', 'blog.php', 'blog-detail.php') ?>">Blog</a>
      <a href="contact.php" class="mobile-nav-link <?= isActivePage('contact.php') ?>">Contact & Project Inquiries</a>
      
      <div class="mobile-drawer-cta">
        <a href="contact.php" class="btn btn-primary" style="width: 100%;">
          Start an Enterprise Project
        </a>
        <a href="audit.php" class="btn btn-secondary" style="width: 100%; margin-top: 0.5rem;">
          Request Free Digital Audit
        </a>
      </div>
    </div>
  </div>
</header>
