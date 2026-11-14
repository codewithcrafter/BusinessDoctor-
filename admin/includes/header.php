<?php
/**
 * BusinessDoctor Admin CMS Header Component
 */

declare(strict_types=1);

if (!isset($adminUser)) {
    require_once __DIR__ . '/auth.php';
}

$pageTitle = $pageTitle ?? 'Admin Console';
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
function isNavActive(string ...$pages): string {
    global $currentScript;
    return in_array($currentScript, $pages, true) ? 'active' : '';
}
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?> — BusinessDoctor CMS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/variables.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

  <!-- Sidebar Overlay for Mobile -->
  <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header">
      <a href="<?= appUrl('admin/dashboard.php') ?>" class="admin-logo" style="display: flex; align-items: center; gap: 0.45rem;">
        <img src="<?= getAssetUrl('assets/img/bdr_logo_transparent.png') ?>" alt="BusinessDoctor Logo" style="height: 28px; width: auto; object-fit: contain; aspect-ratio: 1816 / 1131; display: inline-block;">
        <span>Business<span style="color: var(--adm-teal);">Doctor</span></span>
      </a>
    </div>

    <ul class="admin-sidebar-menu">
      <li class="admin-menu-header">OVERVIEW</li>
      <li class="admin-menu-item">
        <a href="dashboard.php" class="admin-menu-link <?= isNavActive('dashboard.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="admin-menu-header">BLOG &amp; INSIGHTS</li>
      <li class="admin-menu-item">
        <a href="blogs.php" class="admin-menu-link <?= isNavActive('blogs.php', 'blog-edit.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          <span>All Blogs</span>
        </a>
      </li>
      <li class="admin-menu-item">
        <a href="blog-create.php" class="admin-menu-link <?= isNavActive('blog-create.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          <span>Create Blog</span>
        </a>
      </li>

            <li class="admin-menu-header">SERVICES</li>
      <li class="admin-menu-item">
        <a href="services.php" class="admin-menu-link <?= isNavActive('services.php', 'service-edit.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          <span>Services Manager</span>
        </a>
      </li>

      <li class="admin-menu-header">CASE STUDIES</li>
      <li class="admin-menu-item">
        <a href="case-studies.php" class="admin-menu-link <?= isNavActive('case-studies.php', 'case-study-edit.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
          <span>All Case Studies</span>
        </a>
      </li>
      <li class="admin-menu-item">
        <a href="case-study-create.php" class="admin-menu-link <?= isNavActive('case-study-create.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          <span>Create Case Study</span>
        </a>
      </li>

      <li class="admin-menu-header">SEO &amp; STRUCTURED DATA</li>
      <li class="admin-menu-item">
        <a href="schema-manager.php" class="admin-menu-link <?= isNavActive('schema-manager.php', 'schema-edit.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          <span>Schema Manager</span>
        </a>
      </li>
      <li class="admin-menu-item">
        <a href="markdown-health.php" class="admin-menu-link <?= isNavActive('markdown-health.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          <span>Markdown Health</span>
        </a>
      </li>
      <li class="admin-menu-item">
        <a href="../insights.php" target="_blank" class="admin-menu-link" style="color: var(--adm-teal);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          <span>View Live Blogs ↗</span>
        </a>
      </li>

      <li class="admin-menu-header">SETTINGS</li>
      <li class="admin-menu-item">
        <a href="security.php" class="admin-menu-link <?= isNavActive('security.php') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <span>Account &amp; Security</span>
        </a>
      </li>
    </ul>

    <div class="admin-sidebar-footer">
      <div class="admin-user-pill">
        <div class="admin-user-avatar">
          <?= strtoupper(substr($adminUser['full_name'] ?? 'AD', 0, 2)) ?>
        </div>
        <div class="admin-user-info">
          <div class="admin-user-name"><?= e($adminUser['full_name'] ?? 'Admin') ?></div>
          <div class="admin-user-role"><?= e($adminUser['role'] ?? 'Consultant') ?></div>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <main class="admin-main">
    
    <!-- Topbar -->
    <header class="admin-topbar">
      <div class="admin-topbar-left">
        <button type="button" class="admin-toggle-btn" id="sidebarToggle" aria-label="Toggle Navigation">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <h1 class="admin-topbar-title"><?= e($pageTitle) ?></h1>
      </div>

      <div class="admin-topbar-right">
        <a href="../index.php" target="_blank" class="btn-adm btn-adm-secondary btn-adm-sm">
          <span>View Website ↗</span>
        </a>
        <a href="logout.php" class="btn-adm btn-adm-primary btn-adm-sm">
          <span>Sign Out</span>
        </a>
      </div>
    </header>

    <!-- Flash Notification if Present -->
    <?php if ($flash): ?>
      <div style="padding: 1.25rem 2rem 0;">
        <div class="adm-toast <?= $flash['type'] === 'error' ? 'error' : '' ?>" style="max-width: 100%; border-radius: var(--adm-radius);">
          <div>
            <strong><?= $flash['type'] === 'error' ? 'Notice:' : 'Success:' ?></strong> <?= e($flash['message']) ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="admin-content">

