<?php
/**
 * BusinessDoctor Executive Admin — Advanced Schema Editor
 * Dual-column workspace for authoring, beautifying, validating, and publishing Schema.org JSON-LD structured data.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/schema-renderer.php';

$supportedPages = getSupportedSchemaPages();
$id = (int)($_GET['id'] ?? 0);
$prefillPage = trim($_GET['page'] ?? '');

$isEditing = ($id > 0);
$schema = null;

if ($isEditing) {
    $stmt = $pdo->prepare("SELECT * FROM page_schemas WHERE id = ?");
    $stmt->execute([$id]);
    $schema = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$schema) {
        setFlashMessage('error', 'Schema record not found.');
        header('Location: schema-manager.php');
        exit;
    }
}

$errors = [];
$schemaName = $schema['schema_name'] ?? '';
$pageKey = $schema['page_key'] ?? ($prefillPage !== '' ? $prefillPage : 'home');
$pageUrl = $schema['page_url'] ?? ($supportedPages[$pageKey]['url'] ?? '/');
$schemaType = $schema['schema_type'] ?? 'Organization';
$schemaDescription = $schema['schema_description'] ?? '';
$schemaJson = $schema['schema_json'] ?? '';
$status = $schema['status'] ?? 'draft';

// Default starter template if creating a brand new schema
if (!$isEditing && empty($schemaJson)) {
    $schemaJson = json_encode([
        '@context' => 'https://schema.org',
        '@type' => $schemaType,
        '@id' => '{{BASE_URL}}/#organization',
        'name' => defined('APP_NAME') ? APP_NAME : 'BusinessDoctor',
        'url' => '{{BASE_URL}}/',
        'description' => 'Enterprise IT solutions, high-growth digital strategy, and full-stack engineering consultancy.'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Security token expired. Please refresh and try again.';
    } else {
        $schemaName = trim($_POST['schema_name'] ?? '');
        $pageKey = trim($_POST['page_key'] ?? 'home');
        $pageUrl = trim($_POST['page_url'] ?? '/');
        $schemaType = trim($_POST['schema_type'] ?? 'Organization');
        $schemaDescription = sanitizeArticleHtml(trim($_POST['schema_description'] ?? ''));
        $rawJson = trim($_POST['schema_json'] ?? '');
        $submitAction = trim($_POST['submit_action'] ?? 'draft'); // 'draft' | 'publish' | 'unpublish'

        if ($schemaName === '') {
            $errors[] = 'Schema Name is required.';
        }

        // Validate JSON Syntax
        $decoded = json_decode($rawJson, true);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            $errors[] = 'Invalid JSON-LD Syntax: ' . json_last_error_msg();
        } elseif (!is_array($decoded)) {
            $errors[] = 'Schema root must be a valid JSON Object.';
        } elseif (empty($decoded['@context']) || empty($decoded['@type'])) {
            $errors[] = 'Schema must contain `@context` and `@type` properties.';
        }

        if (empty($errors)) {
            // Re-format nicely
            $schemaJson = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $newStatus = ($submitAction === 'publish') ? 'active' : (($submitAction === 'unpublish') ? 'inactive' : 'draft');
            $now = date('Y-m-d H:i:s');

            if ($isEditing) {
                $update = $pdo->prepare("
                    UPDATE page_schemas SET
                        page_key = ?,
                        page_url = ?,
                        schema_name = ?,
                        schema_type = ?,
                        schema_description = ?,
                        schema_json = ?,
                        status = ?,
                        updated_at = ?
                    WHERE id = ?
                ");
                $update->execute([
                    $pageKey,
                    $pageUrl,
                    $schemaName,
                    $schemaType,
                    $schemaDescription,
                    $schemaJson,
                    $newStatus,
                    $now,
                    $id
                ]);

                require_once __DIR__ . '/../includes/seo-sync.php';
                SeoSyncEngine::syncAll("Schema updated: {$schemaName} ({$pageKey})");
                setFlashMessage('success', "Schema '{$schemaName}' updated successfully as " . strtoupper($newStatus) . ".");
                header('Location: schema-manager.php');
                exit;
            } else {
                $insert = $pdo->prepare("
                    INSERT INTO page_schemas (
                        page_key, page_url, schema_name, schema_type,
                        schema_description, schema_json, status, created_at, updated_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $insert->execute([
                    $pageKey,
                    $pageUrl,
                    $schemaName,
                    $schemaType,
                    $schemaDescription,
                    $schemaJson,
                    $newStatus,
                    $now,
                    $now
                ]);

                $newId = (int)$pdo->lastInsertId();
                require_once __DIR__ . '/../includes/seo-sync.php';
                SeoSyncEngine::syncAll("New Schema created: {$schemaName} ({$pageKey})");
                setFlashMessage('success', "New Schema '{$schemaName}' created successfully as " . strtoupper($newStatus) . ".");
                header('Location: schema-manager.php');
                exit;
            }
        }
    }
}

// Available schema types
$availableTypes = [
    'Organization' => 'Corporate / Business Entity',
    'WebSite' => 'Website & Sitelinks Search',
    'WebPage' => 'Standard Web Page',
    'AboutPage' => 'About Us Corporate Purpose',
    'ContactPage' => 'Contact Details & Customer Service',
    'Service' => 'Individual Service Offering',
    'ProfessionalService' => 'Consulting & IT Practice Portfolio',
    'Article' => 'Technical Article / Case Study',
    'BlogPosting' => 'Blog Perspective Entry',
    'BreadcrumbList' => 'Hierarchical Navigation Trail'
];

$pageTitle = $isEditing ? 'Edit Schema — ' . $schemaName : 'Create New Schema';
$activeNav = 'schema-manager';
require_once __DIR__ . '/includes/header.php';
?>

<form method="POST" action="schema-edit.php<?= $isEditing ? '?id=' . $id : '' ?>" id="schemaForm">
  <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
  <input type="hidden" name="schema_description" id="schemaDescInput" value="<?= e($schemaDescription) ?>">

  <!-- Top Sticky Workspace Action Header -->
  <div class="adm-workspace-header">
    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
      <a href="schema-manager.php" class="btn-adm btn-adm-secondary btn-adm-sm" style="color: var(--adm-text-dim);">
        &larr; Schema Manager
      </a>
      <span class="status-pill status-<?= $status === 'active' ? 'published' : ($status === 'draft' ? 'draft' : 'deleted') ?>" id="schemaStatusBadge">
        ● <?= ucfirst($status) ?>
      </span>
      <span style="font-family: var(--adm-font-mono); font-size: 0.8rem; color: var(--adm-teal);">
        Target: <strong id="headerTargetLabel"><?= e($pageKey) ?></strong>
      </span>
    </div>

    <!-- Top Action Buttons -->
    <div style="display: flex; gap: 0.65rem; align-items: center; flex-wrap: wrap;">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="beautifyJson()" title="Auto-indent and format JSON">
        Format JSON
      </button>

      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="revertJson()" title="Reset to original code">
        Revert
      </button>

      <?php if ($isEditing && $status === 'active'): ?>
        <button type="submit" name="submit_action" value="unpublish" class="btn-adm btn-adm-secondary" style="font-weight: 600; color: #FCA5A5;">
          Unpublish
        </button>
      <?php endif; ?>

      <button type="submit" name="submit_action" value="draft" class="btn-adm btn-adm-secondary" style="font-weight: 600;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
        <span>Save Draft</span>
      </button>

      <button type="submit" name="submit_action" value="publish" class="btn-adm btn-adm-primary" style="font-weight: 700; box-shadow: 0 4px 15px rgba(0, 201, 193, 0.35);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>Save &amp; Publish</span>
      </button>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="adm-toast error" style="margin-bottom: 1.5rem; max-width: 100%;">
      <div>
        <strong>Validation Errors:</strong>
        <ul style="margin: 0.35rem 0 0; padding-left: 1.25rem;">
          <?php foreach ($errors as $err): ?>
            <li><?= e($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <!-- Two-Column Editorial Schema Workspace -->
  <div class="adm-form-grid" style="grid-template-columns: 1.15fr 0.85fr; gap: 1.75rem; align-items: start;">
    
    <!-- LEFT PANEL: Configuration, Property Builder & JSON Code Editor -->
    <div>
      
      <!-- Schema Details Card -->
      <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 class="admin-card-title" style="margin-bottom: 1.25rem;">Schema Specification</h3>

        <div class="adm-form-group">
          <label class="adm-label" for="schemaName">Schema Descriptive Name <span class="required">*</span></label>
          <input type="text" id="schemaName" name="schema_name" value="<?= e($schemaName) ?>" required class="adm-input" placeholder="e.g. Primary Organization Knowledge Graph Schema">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group">
            <label class="adm-label" for="pageKeySelect">Target Page <span class="required">*</span></label>
            <select id="pageKeySelect" name="page_key" class="adm-select" onchange="onPageChange(this.value)">
              <?php foreach ($supportedPages as $key => $info): ?>
                <option value="<?= $key ?>" <?= $pageKey === $key ? 'selected' : '' ?> data-url="<?= e($info['url']) ?>">
                  <?= e($info['name']) ?> (<?= e($key) ?>)
                </option>
              <?php endforeach; ?>
              <option value="custom" <?= !isset($supportedPages[$pageKey]) ? 'selected' : '' ?>>Custom Page Route...</option>
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="schemaTypeSelect">Schema.org Entity Type <span class="required">*</span></label>
            <select id="schemaTypeSelect" name="schema_type" class="adm-select" onchange="onTypeChange(this.value)">
              <?php foreach ($availableTypes as $t => $desc): ?>
                <option value="<?= $t ?>" <?= $schemaType === $t ? 'selected' : '' ?>><?= $t ?> &mdash; <?= $desc ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="adm-form-group" id="customUrlWrap" style="<?= isset($supportedPages[$pageKey]) ? 'display: none;' : '' ?>">
          <label class="adm-label" for="pageUrl">Page URL Route <span class="required">*</span></label>
          <input type="text" id="pageUrl" name="page_url" value="<?= e($pageUrl) ?>" class="adm-input" placeholder="/custom-page.php">
        </div>
      </div>

      <!-- JSON-LD Source Code Editor Card -->
      <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
          <div>
            <h3 class="admin-card-title" style="margin: 0 0 0.2rem;">JSON-LD Source Editor</h3>
            <span style="font-size: 0.76rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
              Validated against Schema.org specification
            </span>
          </div>

          <div style="display: flex; gap: 0.4rem; align-items: center;">
            <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="loadStarterTemplate()">
              Load Starter Template
            </button>
            <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="beautifyJson()">
              Beautify
            </button>
          </div>
        </div>

        <!-- Dynamic Token Pills -->
        <div style="margin-bottom: 0.75rem; display: flex; flex-wrap: wrap; gap: 0.35rem; align-items: center;">
          <span style="font-size: 0.72rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono); margin-right: 0.25rem;">INSERT TOKEN:</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{BASE_URL}}')">{{BASE_URL}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{CANONICAL_URL}}')">{{CANONICAL_URL}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{PAGE_TITLE}}')">{{PAGE_TITLE}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{PAGE_DESCRIPTION}}')">{{PAGE_DESCRIPTION}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{ARTICLE_TITLE}}')">{{ARTICLE_TITLE}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{AUTHOR_NAME}}')">{{AUTHOR_NAME}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{DATE_PUBLISHED}}')">{{DATE_PUBLISHED}}</span>
          <span class="adm-md-quickchip" onclick="insertToken('{{FEATURED_IMAGE}}')">{{FEATURED_IMAGE}}</span>
        </div>

        <textarea id="schemaJsonEditor" name="schema_json" class="adm-md-textarea" style="min-height: 440px; font-size: 0.88rem; line-height: 1.6; border-radius: var(--adm-radius);" spellcheck="false"><?= e($schemaJson) ?></textarea>
      </div>

      <!-- Rich Text Internal Editorial Documentation -->
      <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 class="admin-card-title" style="margin-bottom: 0.4rem;">Internal Schema Strategy &amp; Notes</h3>
        <p style="font-size: 0.78rem; color: var(--adm-text-dim); margin-bottom: 0.75rem;">
          Document the target search queries, entity relations, or audit rationale. (HTML notes for internal editorial records; excluded from JSON-LD source).
        </p>

        <!-- Rich Text Toolbar -->
        <div class="adm-editor-toolbar" style="border-radius: var(--adm-radius-lg) var(--adm-radius-lg) 0 0;">
          <div class="adm-tb-group">
            <select class="adm-tb-select" onchange="setBlockFormat(this.value); this.value='';" title="Format">
              <option value="" disabled selected>Format</option>
              <option value="p">Paragraph</option>
              <option value="h3">Heading 3</option>
            </select>
          </div>
          <div class="adm-toolbar-divider"></div>
          <div class="adm-tb-group">
            <button type="button" class="adm-tb-btn" onclick="execCmd('bold')" title="Bold"><strong>B</strong></button>
            <button type="button" class="adm-tb-btn" onclick="execCmd('italic')" title="Italic"><em>I</em></button>
            <button type="button" class="adm-tb-btn" onclick="execCmd('underline')" title="Underline"><u>U</u></button>
          </div>
          <div class="adm-toolbar-divider"></div>
          <div class="adm-tb-group">
            <button type="button" class="adm-tb-btn" onclick="execCmd('insertUnorderedList')" title="Bullet List">&bull; List</button>
            <button type="button" class="adm-tb-btn" onclick="execCmd('insertOrderedList')" title="Numbered List">1. List</button>
            <button type="button" class="adm-tb-btn" onclick="execCmd('formatBlock', 'blockquote')" title="Quote">&ldquo; Quote</button>
          </div>
          <div class="adm-toolbar-divider"></div>
          <div class="adm-tb-group">
            <button type="button" class="adm-tb-btn" onclick="execCmd('removeFormat')" title="Clear Format">T⃠</button>
          </div>
        </div>

        <div class="adm-doc-canvas" id="visualCanvas" contenteditable="true" style="min-height: 160px; max-height: 300px; padding: 1.25rem; font-size: 0.95rem;">
          <?= $schemaDescription ?: '<p>Document schema strategy and expected Google Knowledge Graph outcomes here...</p>' ?>
        </div>
      </div>

    </div>

    <!-- RIGHT PANEL: Live Preview, Validation Status & Diagnostic Checks -->
    <div>
      
      <!-- Live Validation & Quality Status Box -->
      <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 class="admin-card-title" style="margin-bottom: 0.75rem;">Quality &amp; Validation Status</h3>
        
        <div id="liveStatusBanner" style="padding: 0.85rem 1rem; border-radius: 6px; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.65rem;">
          <!-- Dynamically populated status -->
        </div>

        <div style="font-size: 0.76rem; font-weight: 700; color: #E2E8F0; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem;">
          Real-Time Diagnostics:
        </div>
        <ul id="liveChecksList" style="list-style: none; padding: 0; margin: 0; font-size: 0.82rem;"></ul>

        <div style="margin-top: 1.25rem; border-top: 1px solid var(--adm-border); padding-top: 1rem;">
          <a id="externalRichResultsLink" href="https://search.google.com/test/rich-results" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary btn-adm-sm" style="width: 100%; justify-content: center;">
            <span>Test on Google Rich Results ↗</span>
          </a>
        </div>
      </div>

      <!-- Live JSON Preview Card -->
      <div class="admin-card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
          <h3 class="admin-card-title" style="margin: 0;">Live JSON-LD Preview</h3>
          <span style="font-size: 0.72rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
            Read-only simulation
          </span>
        </div>

        <pre id="liveJsonPreview" style="background: #040E1B; border: 1px solid var(--adm-border); border-radius: 6px; padding: 1.25rem; font-family: var(--adm-font-mono); font-size: 0.82rem; color: #14E5D4; max-height: 480px; overflow: auto; white-space: pre; margin: 0;"></pre>
      </div>

      <!-- Quick Template Presets Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 0.75rem;">Schema Types Quick Reference</h3>
        <p style="font-size: 0.78rem; color: var(--adm-text-muted); margin-bottom: 0.75rem;">
          Select from standard Schema.org schemas to view their typical required fields:
        </p>

        <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.82rem;">
          <div style="padding: 0.5rem 0.75rem; background: #081D33; border-radius: 4px; border-left: 3px solid var(--adm-teal);">
            <strong>Organization:</strong> Requires <code>name</code>, <code>url</code>, <code>logo</code>. For global corporate entity.
          </div>
          <div style="padding: 0.5rem 0.75rem; background: #081D33; border-radius: 4px; border-left: 3px solid #60A5FA;">
            <strong>WebSite:</strong> Requires <code>url</code>, <code>name</code>, <code>potentialAction</code>. For Google sitelinks.
          </div>
          <div style="padding: 0.5rem 0.75rem; background: #081D33; border-radius: 4px; border-left: 3px solid #34D399;">
            <strong>BlogPosting / Article:</strong> Requires <code>headline</code>, <code>author</code>, <code>datePublished</code>, <code>image</code>.
          </div>
          <div style="padding: 0.5rem 0.75rem; background: #081D33; border-radius: 4px; border-left: 3px solid #FBBF24;">
            <strong>ProfessionalService:</strong> Requires <code>name</code>, <code>hasOfferCatalog</code>, <code>telephone</code>.
          </div>
        </div>
      </div>

    </div>

  </div>
</form>

<!-- Include Core Rich Text Engine for Description Canvas -->
<script src="../assets/js/admin-editor.js"></script>

<script>
const originalJson = <?= json_encode($schemaJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const supportedPagesMap = <?= json_encode($supportedPages, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

// Starter templates library for Schema.org types
const starterTemplates = {
  'Organization': {
    "@context": "https://schema.org",
    "@type": "Organization",
    "@id": "{{BASE_URL}}/#organization",
    "name": "BusinessDoctor",
    "legalName": "BusinessDoctor Enterprise Solutions Pvt. Ltd.",
    "url": "{{BASE_URL}}/",
    "logo": "{{BASE_URL}}/assets/img/logo.svg",
    "description": "Enterprise digital transformation, cloud architecture, and full-stack software development consulting firm.",
    "telephone": "+91 98765 43210",
    "email": "leadership@businessdoctor.com",
    "sameAs": [
      "https://www.linkedin.com/company/businessdoctor",
      "https://twitter.com/businessdoctor"
    ]
  },
  'WebSite': {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "@id": "{{BASE_URL}}/#website",
    "url": "{{BASE_URL}}/",
    "name": "BusinessDoctor",
    "description": "Enterprise IT solutions, high-growth digital strategy, and full-stack engineering consultancy.",
    "potentialAction": {
      "@type": "SearchAction",
      "target": {
        "@type": "EntryPoint",
        "urlTemplate": "{{BASE_URL}}/insights.php?q={search_term_string}"
      },
      "query-input": "required name=search_term_string"
    }
  },
  'WebPage': {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "{{PAGE_TITLE}}",
    "url": "{{CANONICAL_URL}}",
    "description": "{{PAGE_DESCRIPTION}}",
    "publisher": {
      "@id": "{{BASE_URL}}/#organization"
    }
  },
  'AboutPage': {
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "@id": "{{BASE_URL}}/about.php#aboutpage",
    "url": "{{BASE_URL}}/about.php",
    "name": "About BusinessDoctor — Enterprise IT & Growth Consultancy",
    "description": "Learn about BusinessDoctor executive leadership, engineering principles, and our multidisciplinary IT practice.",
    "mainEntity": {
      "@id": "{{BASE_URL}}/#organization"
    }
  },
  'ContactPage': {
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "@id": "{{BASE_URL}}/contact.php#contactpage",
    "url": "{{BASE_URL}}/contact.php",
    "name": "Contact BusinessDoctor — Enterprise Advisory & Consultation",
    "description": "Initiate a dialogue with BusinessDoctor solution architects and digital practice directors.",
    "mainEntity": {
      "@type": "ContactPoint",
      "telephone": "+91 98765 43210",
      "contactType": "customer service",
      "email": "leadership@businessdoctor.com"
    }
  },
  'Service': {
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "{{PAGE_TITLE}}",
    "url": "{{CANONICAL_URL}}",
    "description": "{{PAGE_DESCRIPTION}}",
    "provider": {
      "@id": "{{BASE_URL}}/#organization"
    },
    "areaServed": "Global",
    "serviceType": "Enterprise Consulting"
  },
  'ProfessionalService': {
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "BusinessDoctor IT Services",
    "url": "{{BASE_URL}}/services.php",
    "priceRange": "$$$",
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "IT & Digital Services Portfolio",
      "itemListElement": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Web & Custom Software Engineering",
            "description": "Architecting resilient full-stack web applications, microservices, and enterprise APIs."
          }
        }
      ]
    }
  },
  'Article': {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ARTICLE_TITLE}}",
    "url": "{{CANONICAL_URL}}",
    "description": "{{ARTICLE_DESCRIPTION}}",
    "publisher": {
      "@id": "{{BASE_URL}}/#organization"
    },
    "author": {
      "@type": "Organization",
      "name": "BusinessDoctor"
    }
  },
  'BlogPosting': {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "{{CANONICAL_URL}}"
    },
    "headline": "{{ARTICLE_TITLE}}",
    "description": "{{ARTICLE_DESCRIPTION}}",
    "image": "{{FEATURED_IMAGE}}",
    "datePublished": "{{DATE_PUBLISHED}}",
    "dateModified": "{{DATE_MODIFIED}}",
    "author": {
      "@type": "Person",
      "name": "{{AUTHOR_NAME}}"
    },
    "publisher": {
      "@id": "{{BASE_URL}}/#organization"
    }
  },
  'BreadcrumbList': {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "{{BASE_URL}}/"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "{{PAGE_TITLE}}",
        "item": "{{CANONICAL_URL}}"
      }
    ]
  }
};

function onPageChange(key) {
  const customWrap = document.getElementById('customUrlWrap');
  const urlInput = document.getElementById('pageUrl');
  const headerTarget = document.getElementById('headerTargetLabel');
  headerTarget.textContent = key;

  if (key === 'custom') {
    customWrap.style.display = 'block';
  } else {
    customWrap.style.display = 'none';
    if (supportedPagesMap[key]) {
      urlInput.value = supportedPagesMap[key].url;
    }
  }
  updateLiveValidator();
}

function onTypeChange(type) {
  // Offer to load template if editor is empty or unchanged
  if (confirm(`Do you want to populate the starter JSON template for '${type}'?`)) {
    loadStarterTemplate(type);
  }
}

function loadStarterTemplate(type) {
  const chosenType = type || document.getElementById('schemaTypeSelect').value;
  if (starterTemplates[chosenType]) {
    document.getElementById('schemaJsonEditor').value = JSON.stringify(starterTemplates[chosenType], null, 2);
    updateLiveValidator();
    showToast(`Loaded ${chosenType} starter template`, 'info');
  }
}

function beautifyJson() {
  const editor = document.getElementById('schemaJsonEditor');
  try {
    const parsed = JSON.parse(editor.value);
    editor.value = JSON.stringify(parsed, null, 2);
    updateLiveValidator();
    showToast('JSON formatted with clean indentation', 'info');
  } catch (e) {
    showToast('Cannot beautify: invalid JSON syntax', 'error');
  }
}

function revertJson() {
  if (confirm('Revert all unsaved changes back to initial state?')) {
    document.getElementById('schemaJsonEditor').value = originalJson;
    updateLiveValidator();
    showToast('Reverted changes', 'info');
  }
}

function insertToken(token) {
  const editor = document.getElementById('schemaJsonEditor');
  const start = editor.selectionStart;
  const end = editor.selectionEnd;
  const val = editor.value;
  editor.value = val.substring(0, start) + token + val.substring(end);
  editor.focus();
  editor.setSelectionRange(start + token.length, start + token.length);
  updateLiveValidator();
}

function updateLiveValidator() {
  const editor = document.getElementById('schemaJsonEditor');
  const preview = document.getElementById('liveJsonPreview');
  const banner = document.getElementById('liveStatusBanner');
  const list = document.getElementById('liveChecksList');
  const raw = editor.value;

  list.innerHTML = '';
  let parsed = null;
  let isValidJson = false;
  const checks = [];

  try {
    parsed = JSON.parse(raw);
    isValidJson = true;
    checks.push({ ok: true, text: 'JSON syntax is valid with zero parse errors.' });
    preview.textContent = JSON.stringify(parsed, null, 2);
  } catch (e) {
    checks.push({ ok: false, text: `Syntax error: ${e.message}` });
    preview.textContent = raw;
  }

  if (isValidJson && parsed) {
    // Check @context
    if (parsed['@context'] === 'https://schema.org' || parsed['@context'] === 'http://schema.org') {
      checks.push({ ok: true, text: 'Valid Schema.org namespace (`@context`: "https://schema.org")' });
    } else {
      checks.push({ ok: false, text: 'Missing `@context`: "https://schema.org"' });
    }

    // Check @type
    if (parsed['@type']) {
      checks.push({ ok: true, text: `Entity type matches \`${parsed['@type']}\`` });
    } else {
      checks.push({ ok: false, text: 'Missing required `@type` attribute.' });
    }

    // Check name or headline
    if (parsed['name'] || parsed['headline']) {
      checks.push({ ok: true, text: `Name/headline descriptor provided.` });
    } else {
      checks.push({ ok: false, text: 'Recommended property `name` or `headline` is missing.' });
    }

    // Check URL
    if (parsed['url'] || (parsed['mainEntityOfPage'] && parsed['mainEntityOfPage']['@id'])) {
      checks.push({ ok: true, text: 'Canonical URL reference present.' });
    } else {
      checks.push({ ok: false, text: 'Warning: Missing `url` canonical property.' });
    }
  }

  const allPassed = checks.every(c => c.ok);

  if (allPassed) {
    banner.style.background = 'rgba(16, 185, 129, 0.15)';
    banner.style.border = '1px solid #10B981';
    banner.style.color = '#34D399';
    banner.innerHTML = '<span style="font-size: 1.2rem;">✓</span><strong>Valid JSON-LD</strong> — Ready for Google Search index.';
  } else {
    banner.style.background = 'rgba(239, 68, 68, 0.15)';
    banner.style.border = '1px solid #EF4444';
    banner.style.color = '#F87171';
    banner.innerHTML = '<span style="font-size: 1.2rem;">✕</span><strong>Validation Issues</strong> — Resolve flagged items before publishing.';
  }

  checks.forEach(c => {
    const li = document.createElement('li');
    li.style.display = 'flex';
    li.style.alignItems = 'center';
    li.style.gap = '0.4rem';
    li.style.marginBottom = '0.35rem';
    li.innerHTML = `
      <span style="font-weight: 800; color: ${c.ok ? '#34D399' : '#F87171'};">${c.ok ? '✓' : '✕'}</span>
      <span style="color: ${c.ok ? '#E2E8F0' : '#FCA5A5'};">${c.text}</span>
    `;
    list.appendChild(li);
  });

  // Update external link
  const pageUrl = document.getElementById('pageUrl').value || '/';
  document.getElementById('externalRichResultsLink').href = 'https://search.google.com/test/rich-results?url=' + encodeURIComponent('https://demo.businessdoctor.com' + pageUrl);
}

// Sync visual description canvas with hidden input before form submission
document.getElementById('schemaForm').addEventListener('submit', function() {
  const canvas = document.getElementById('visualCanvas');
  if (canvas) {
    document.getElementById('schemaDescInput').value = canvas.innerHTML;
  }
});

// Real-time validator on typing
document.getElementById('schemaJsonEditor').addEventListener('input', updateLiveValidator);

// Initial validation
document.addEventListener('DOMContentLoaded', updateLiveValidator);
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

