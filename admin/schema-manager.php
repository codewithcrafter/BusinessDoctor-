<?php
/**
 * BusinessDoctor Executive Admin — SEO Schema Manager Dashboard
 * Manage, audit, preview, and validate Schema.org JSON-LD structured data.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/schema-renderer.php';

// Handle Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'Security token expired. Please retry.');
    } else {
        $deleteId = (int)($_POST['id'] ?? 0);
        if ($deleteId > 0) {
            $stmt = $pdo->prepare("SELECT schema_name FROM page_schemas WHERE id = ?");
            $stmt->execute([$deleteId]);
            $sch = $stmt->fetch();
            if ($sch) {
                $del = $pdo->prepare("DELETE FROM page_schemas WHERE id = ?");
                $del->execute([$deleteId]);
                setFlashMessage('success', "Schema '{$sch['schema_name']}' deleted successfully.");
            }
        }
    }
    header('Location: schema-manager.php');
    exit;
}

// Filters & Search
$search = trim($_GET['search'] ?? '');
$filterType = trim($_GET['type'] ?? '');
$filterStatus = trim($_GET['status'] ?? '');

// Fetch all schemas from DB
$query = "SELECT * FROM page_schemas WHERE 1=1";
$params = [];

if ($search !== '') {
    $query .= " AND (page_key LIKE ? OR schema_name LIKE ? OR page_url LIKE ? OR schema_type LIKE ?)";
    $like = '%' . $search . '%';
    $params = array_merge($params, [$like, $like, $like, $like]);
}

if ($filterType !== '') {
    $query .= " AND schema_type = ?";
    $params[] = $filterType;
}

if ($filterStatus !== '') {
    $query .= " AND status = ?";
    $params[] = $filterStatus;
}

$query .= " ORDER BY page_key ASC, id ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$schemas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Metrics
$totalActive = (int)$pdo->query("SELECT COUNT(*) FROM page_schemas WHERE status = 'active'")->fetchColumn();
$totalDraft = (int)$pdo->query("SELECT COUNT(*) FROM page_schemas WHERE status = 'draft'")->fetchColumn();
$totalSchemas = (int)$pdo->query("SELECT COUNT(*) FROM page_schemas")->fetchColumn();

$supportedPages = getSupportedSchemaPages();
$totalSupportedPages = count($supportedPages);

// Group schemas by page_key for dashboard view
$schemasByPage = [];
foreach ($schemas as $s) {
    $schemasByPage[$s['page_key']][] = $s;
}

// Available Schema.org types for filter
$availableTypes = [
    'Organization',
    'WebSite',
    'WebPage',
    'AboutPage',
    'ContactPage',
    'Service',
    'Article',
    'BlogPosting',
    'BreadcrumbList',
    'ProfessionalService'
];

$pageTitle = 'Schema Management CMS';
$activeNav = 'schema-manager';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.5rem; font-weight: 700; color: #FFFFFF; margin: 0 0 0.35rem; font-family: var(--adm-font-display);">
      Structured Data &amp; SEO Schema CMS
    </h2>
    <p style="color: var(--adm-text-muted); font-size: 0.88rem; margin: 0;">
      Centrally author, validate, and inject Schema.org JSON-LD structured data into Google search engine knowledge graphs.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center;">
    <a href="schema-edit.php" class="btn-adm btn-adm-primary" style="font-weight: 700; box-shadow: 0 4px 15px rgba(0, 201, 193, 0.35);">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      <span>+ Create New Schema</span>
    </a>
  </div>
</div>

<!-- Metrics Overview Cards -->
<div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); margin-bottom: 1.75rem;">
  <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
    <div class="admin-stat-icon" style="background: rgba(0, 201, 193, 0.15); color: var(--adm-teal);">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
    </div>
    <div>
      <div class="admin-stat-val" style="color: var(--adm-teal);"><?= $totalSchemas ?></div>
      <div class="admin-stat-lbl">Configured Schemas</div>
    </div>
  </div>

  <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
    <div class="admin-stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #34D399;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <div>
      <div class="admin-stat-val" style="color: #34D399;"><?= $totalActive ?></div>
      <div class="admin-stat-lbl">Live on Website</div>
    </div>
  </div>

  <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
    <div class="admin-stat-icon" style="background: rgba(245, 158, 11, 0.15); color: #FBBF24;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
    </div>
    <div>
      <div class="admin-stat-val" style="color: #FBBF24;"><?= $totalDraft ?></div>
      <div class="admin-stat-lbl">Draft Schemas</div>
    </div>
  </div>

  <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
    <div class="admin-stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #60A5FA;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
    </div>
    <div>
      <div class="admin-stat-val"><?= $totalSupportedPages ?></div>
      <div class="admin-stat-lbl">Supported Templates</div>
    </div>
  </div>
</div>

<!-- Filters Toolbar -->
<div class="admin-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
  <form method="GET" action="schema-manager.php" class="admin-toolbar" style="margin: 0; display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; flex: 1;">
      <!-- Search Input -->
      <div class="adm-search-box" style="min-width: 260px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search by Page Name, URL, or Schema Name..." class="adm-input">
      </div>

      <!-- Type Filter -->
      <select name="type" class="adm-select" style="width: auto; min-width: 170px;">
        <option value="">All Schema Types</option>
        <?php foreach ($availableTypes as $t): ?>
          <option value="<?= $t ?>" <?= $filterType === $t ? 'selected' : '' ?>><?= $t ?></option>
        <?php endforeach; ?>
      </select>

      <!-- Status Filter -->
      <select name="status" class="adm-select" style="width: auto; min-width: 140px;">
        <option value="">All Statuses</option>
        <option value="active" <?= $filterStatus === 'active' ? 'selected' : '' ?>>Active (Published)</option>
        <option value="draft" <?= $filterStatus === 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="inactive" <?= $filterStatus === 'inactive' ? 'selected' : '' ?>>Inactive</option>
      </select>

      <button type="submit" class="btn-adm btn-adm-secondary btn-adm-sm">Filter</button>
      <?php if ($search !== '' || $filterType !== '' || $filterStatus !== ''): ?>
        <a href="schema-manager.php" class="btn-adm btn-adm-secondary btn-adm-sm" style="color: var(--adm-text-dim);">Reset</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<!-- Schemas Data Table -->
<div class="admin-card" style="padding: 0; overflow: hidden;">
  <div class="admin-table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 22%;">Page Name &amp; Category</th>
          <th style="width: 18%;">Page URL</th>
          <th style="width: 26%;">Configured Schema(s)</th>
          <th style="width: 10%;">Status</th>
          <th style="width: 12%;">Last Updated</th>
          <th style="width: 12%; text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($schemas)): ?>
          <tr>
            <td colspan="6" style="text-align: center; padding: 3rem 1.5rem; color: var(--adm-text-muted);">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="40" height="40" style="margin: 0 auto 0.75rem; opacity: 0.35;"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
              <div style="font-size: 1rem; font-weight: 600; color: #E2E8F0; margin-bottom: 0.25rem;">No Schemas Match Your Filter</div>
              <p style="font-size: 0.85rem; margin: 0;">Try adjusting your search criteria or create a new Schema.org definition.</p>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($schemas as $s): 
            $pageInfo = $supportedPages[$s['page_key']] ?? null;
            $displayName = $pageInfo ? $pageInfo['name'] : ucfirst(str_replace('-', ' ', $s['page_key']));
            $isDynamic = $pageInfo['is_dynamic'] ?? false;
          ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: #FFFFFF; font-size: 0.95rem; margin-bottom: 0.25rem;">
                  <?= e($displayName) ?>
                </div>
                <div style="display: flex; gap: 0.4rem; align-items: center;">
                  <span style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: var(--adm-teal); background: rgba(0, 201, 193, 0.1); padding: 2px 6px; border-radius: 3px;">
                    key: <?= e($s['page_key']) ?>
                  </span>
                  <?php if ($isDynamic): ?>
                    <span style="font-size: 0.7rem; color: #60A5FA; background: rgba(59, 130, 246, 0.15); padding: 2px 6px; border-radius: 3px; font-weight: 600;">
                      Dynamic Template
                    </span>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <a href="../<?= ltrim($s['page_url'], '/') ?>" target="_blank" rel="noopener" style="color: #60A5FA; text-decoration: none; font-family: var(--adm-font-mono); font-size: 0.82rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                  <span><?= e($s['page_url']) ?></span>
                  <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
              </td>
              <td>
                <div style="font-weight: 600; color: #E2E8F0; font-size: 0.9rem; margin-bottom: 0.25rem;">
                  <?= e($s['schema_name']) ?>
                </div>
                <span class="status-pill" style="background: rgba(14, 37, 63, 0.8); color: var(--adm-teal); border: 1px solid rgba(0, 201, 193, 0.3); font-size: 0.74rem;">
                  @type: <?= e($s['schema_type']) ?>
                </span>
              </td>
              <td>
                <span class="status-pill status-<?= $s['status'] === 'active' ? 'published' : ($s['status'] === 'draft' ? 'draft' : 'deleted') ?>">
                  ● <?= ucfirst($s['status']) ?>
                </span>
              </td>
              <td>
                <div style="font-size: 0.82rem; color: var(--adm-text-muted); font-family: var(--adm-font-mono);">
                  <?= date('M j, Y', strtotime($s['updated_at'])) ?><br>
                  <span style="font-size: 0.74rem; color: var(--adm-text-dim);"><?= date('H:i', strtotime($s['updated_at'])) ?></span>
                </div>
              </td>
              <td style="text-align: right;">
                <div style="display: inline-flex; gap: 0.35rem; align-items: center;">
                  <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="previewSchema(<?= (int)$s['id'] ?>)" title="Preview JSON-LD Output">
                    Preview
                  </button>
                  <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="validateSchema(<?= (int)$s['id'] ?>)" title="Validate Schema Structure">
                    Validate
                  </button>
                  <a href="schema-edit.php?id=<?= (int)$s['id'] ?>" class="btn-adm btn-adm-secondary btn-adm-sm" style="color: var(--adm-teal);" title="Edit Schema">
                    Edit
                  </a>
                  <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" style="color: #F87171;" onclick="confirmDeleteSchema(<?= (int)$s['id'] ?>, '<?= e(addslashes($s['schema_name'])) ?>')" title="Delete">
                    &times;
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ================= MODALS ================= -->

<!-- Preview Modal -->
<div class="adm-modal-overlay" id="previewSchemaModal">
  <div class="adm-modal-card" style="max-width: 680px;">
    <div class="adm-modal-header">
      <h4 class="adm-modal-title" id="previewModalTitle">JSON-LD Output Preview</h4>
      <button type="button" class="adm-modal-close" onclick="closeModal('previewSchemaModal')">&times;</button>
    </div>
    <div class="adm-modal-body" style="padding: 1.25rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
        <span style="font-size: 0.78rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
          Exact markup injected into `<head>`
        </span>
        <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" id="copySchemaBtn" onclick="copyPreviewJson()">
          Copy JSON-LD
        </button>
      </div>
      <pre id="previewJsonOutput" style="background: #040E1B; border: 1px solid var(--adm-border); border-radius: 6px; padding: 1.25rem; font-family: var(--adm-font-mono); font-size: 0.85rem; color: #14E5D4; max-height: 440px; overflow: auto; white-space: pre; margin: 0;"></pre>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('previewSchemaModal')">Close</button>
    </div>
  </div>
</div>

<!-- Validate Modal -->
<div class="adm-modal-overlay" id="validateSchemaModal">
  <div class="adm-modal-card" style="max-width: 620px;">
    <div class="adm-modal-header">
      <h4 class="adm-modal-title" id="validateModalTitle">Schema Quality &amp; Syntax Audit</h4>
      <button type="button" class="adm-modal-close" onclick="closeModal('validateSchemaModal')">&times;</button>
    </div>
    <div class="adm-modal-body" style="padding: 1.5rem;">
      <div id="validationStatusBanner" style="padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.25rem;"></div>

      <div style="font-size: 0.82rem; font-weight: 700; color: #E2E8F0; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
        Structural Rule Checks:
      </div>
      <ul id="validationChecksList" style="list-style: none; padding: 0; margin: 0 0 1.5rem; font-size: 0.86rem;"></ul>

      <div style="background: #081F38; border: 1px solid var(--adm-border); border-radius: 6px; padding: 1rem; font-size: 0.82rem; color: var(--adm-text-muted);">
        <strong style="color: var(--adm-teal);">Google Rich Results Test:</strong>
        <p style="margin: 0.35rem 0 0.75rem;">
          You can test this page's live rendered structured data directly on Google's official Rich Results Test.
        </p>
        <a id="googleRichResultsBtn" href="https://search.google.com/test/rich-results" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary btn-adm-sm" style="display: inline-flex; align-items: center; gap: 0.4rem;">
          <span>Open Google Rich Results Test ↗</span>
        </a>
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('validateSchemaModal')">Close</button>
    </div>
  </div>
</div>

<!-- Delete Confirmation Form -->
<form method="POST" action="schema-manager.php" id="deleteSchemaForm" style="display: none;">
  <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
  <input type="hidden" name="action" value="delete">
  <input type="hidden" name="id" id="deleteSchemaId" value="0">
</form>

<script>
// JSON cache of loaded schemas
const schemasData = <?= json_encode($schemas, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

function getById(id) {
  return schemasData.find(s => parseInt(s.id) === parseInt(id));
}

function previewSchema(id) {
  const schema = getById(id);
  if (!schema) return;

  document.getElementById('previewModalTitle').textContent = `Preview: ${schema.schema_name}`;
  try {
    const parsed = JSON.parse(schema.schema_json);
    document.getElementById('previewJsonOutput').textContent = JSON.stringify(parsed, null, 2);
  } catch (e) {
    document.getElementById('previewJsonOutput').textContent = schema.schema_json;
  }
  openModal('previewSchemaModal');
}

function copyPreviewJson() {
  const text = document.getElementById('previewJsonOutput').textContent;
  navigator.clipboard.writeText(text).then(() => {
    const btn = document.getElementById('copySchemaBtn');
    btn.textContent = '✓ Copied!';
    setTimeout(() => { btn.textContent = 'Copy JSON-LD'; }, 2000);
  });
}

function validateSchema(id) {
  const schema = getById(id);
  if (!schema) return;

  document.getElementById('validateModalTitle').textContent = `Validate: ${schema.schema_name}`;
  const banner = document.getElementById('validationStatusBanner');
  const list = document.getElementById('validationChecksList');
  list.innerHTML = '';

  let isValidJson = false;
  let parsed = null;
  const checks = [];

  try {
    parsed = JSON.parse(schema.schema_json);
    isValidJson = true;
    checks.push({ ok: true, text: 'JSON syntax is well-formed with zero parse errors.' });
  } catch (e) {
    checks.push({ ok: false, text: `JSON syntax error: ${e.message}` });
  }

  if (isValidJson && parsed) {
    // Check @context
    if (parsed['@context'] === 'https://schema.org' || parsed['@context'] === 'http://schema.org') {
      checks.push({ ok: true, text: 'Valid Schema.org namespace declaration (`@context`: "https://schema.org")' });
    } else {
      checks.push({ ok: false, text: 'Missing or invalid `@context`. Must be "https://schema.org"' });
    }

    // Check @type
    if (parsed['@type']) {
      checks.push({ ok: true, text: `Schema entity type properly declared as \`${parsed['@type']}\`` });
    } else {
      checks.push({ ok: false, text: 'Missing required `@type` attribute.' });
    }

    // Check name or headline
    if (parsed['name'] || parsed['headline']) {
      checks.push({ ok: true, text: `Name/headline descriptor provided: "${parsed['name'] || parsed['headline']}"` });
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
    banner.innerHTML = '<strong>✓ High Quality Schema:</strong> Passed all syntax and semantic checks with zero errors.';
  } else {
    banner.style.background = 'rgba(239, 68, 68, 0.15)';
    banner.style.border = '1px solid #EF4444';
    banner.style.color = '#F87171';
    banner.innerHTML = '<strong>⚠ Quality Issues Detected:</strong> Please review and resolve the flagged items below.';
  }

  checks.forEach(c => {
    const li = document.createElement('li');
    li.style.display = 'flex';
    li.style.alignItems = 'center';
    li.style.gap = '0.5rem';
    li.style.marginBottom = '0.5rem';
    li.innerHTML = `
      <span style="font-weight: 800; color: ${c.ok ? '#34D399' : '#F87171'}; font-size: 1.1rem;">${c.ok ? '✓' : '✕'}</span>
      <span style="color: ${c.ok ? '#E2E8F0' : '#FCA5A5'};">${c.text}</span>
    `;
    list.appendChild(li);
  });

  // Setup Google Rich Results URL
  const testUrl = 'https://search.google.com/test/rich-results?url=' + encodeURIComponent('https://demo.businessdoctor.com' + schema.page_url);
  document.getElementById('googleRichResultsBtn').href = testUrl;

  openModal('validateSchemaModal');
}

function confirmDeleteSchema(id, name) {
  if (confirm(`Are you sure you want to permanently delete schema '${name}'?\nThis will remove it from the website head output.`)) {
    document.getElementById('deleteSchemaId').value = id;
    document.getElementById('deleteSchemaForm').submit();
  }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

