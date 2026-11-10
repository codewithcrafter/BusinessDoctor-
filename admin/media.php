<?php
/**
 * BusinessDoctor Media Management (CMS)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$errors = [];

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'Security session expired. Please retry.');
        header('Location: media.php');
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT file_path FROM media WHERE id = ?");
        $stmt->execute([$id]);
        $filePath = $stmt->fetchColumn();

        if ($filePath) {
            $fullPath = ROOT_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                @unlink($fullPath);
            }
            $delStmt = $pdo->prepare("DELETE FROM media WHERE id = ?");
            $delStmt->execute([$id]);
            setFlashMessage('success', 'Media asset deleted successfully.');
        }
    }
    header('Location: media.php');
    exit;
}

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media_files'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Security session expired. Please retry.';
    } else {
        $files = $_FILES['media_files'];
        $count = is_array($files['name']) ? count($files['name']) : 1;
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
        $uploadDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $successCount = 0;

        for ($i = 0; $i < $count; $i++) {
            $err = is_array($files['error']) ? $files['error'][$i] : $files['error'];
            if ($err !== UPLOAD_ERR_OK) {
                continue;
            }

            $tmpName = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
            $origName = is_array($files['name']) ? $files['name'][$i] : $files['name'];
            $size = is_array($files['size']) ? $files['size'][$i] : $files['size'];

            if ($size > 5 * 1024 * 1024) {
                $errors[] = "File '{$origName}' exceeds the 5MB size limit.";
                continue;
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($tmpName);
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

            if (!in_array($mime, $allowedMimes, true) || !in_array($ext, $allowedExts, true)) {
                $errors[] = "File '{$origName}' is not an authorized image format (JPG, PNG, WebP only).";
                continue;
            }

            // Verify image integrity with getimagesize
            $imgInfo = @getimagesize($tmpName);
            if ($imgInfo === false) {
                $errors[] = "File '{$origName}' is corrupted or not a valid image.";
                continue;
            }

            $safeName = 'media_' . bin2hex(random_bytes(10)) . '.' . $ext;
            $destination = $uploadDir . DIRECTORY_SEPARATOR . $safeName;

            if (move_uploaded_file($tmpName, $destination)) {
                $relPath = 'assets/uploads/' . $safeName;
                $stmt = $pdo->prepare("
                    INSERT INTO media (filename, original_name, file_path, file_size, mime_type, created_at)
                    VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
                ");
                $stmt->execute([$safeName, $origName, $relPath, $size, $mime]);
                $successCount++;
            } else {
                $errors[] = "Failed to save '{$origName}'.";
            }
        }

        if ($successCount > 0) {
            setFlashMessage('success', "Uploaded {$successCount} image(s) to media library.");
            header('Location: media.php');
            exit;
        }
    }
}

// Fetch Media List
$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM media WHERE original_name LIKE ? OR filename LIKE ? ORDER BY id DESC");
    $stmt->execute(["%{$search}%", "%{$search}%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM media ORDER BY id DESC");
}
$mediaItems = $stmt->fetchAll();
$totalCount = (int)$pdo->query("SELECT COUNT(*) FROM media")->fetchColumn();

$pageTitle = 'Media Library';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Toolbar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.4rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem; font-family: var(--adm-font-display);">
      Media Library
    </h2>
    <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.85rem;">
      Upload and manage high-resolution featured images, case study visuals, and brand assets.
    </p>
  </div>
  <div style="font-family: var(--adm-font-mono); font-size: 0.85rem; color: var(--adm-teal);">
    Total Uploads: <?= $totalCount ?>
  </div>
</div>

<?php if (!empty($errors)): ?>
  <div class="adm-toast error" style="margin-bottom: 1.5rem; max-width: 100%;">
    <div>
      <strong>Upload Notice:</strong>
      <ul style="margin: 0.35rem 0 0; padding-left: 1.25rem;">
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<!-- Drag & Drop Upload Card -->
<div class="admin-card" style="margin-bottom: 1.75rem;">
  <form method="POST" action="media.php" enctype="multipart/form-data" id="uploadForm">
    <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
    
    <label for="mediaInput" class="adm-dropzone" id="dropzoneBox" style="display: block;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      <div style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">
        Click to Upload or Drag &amp; Drop Images Here
      </div>
      <div style="font-size: 0.82rem; color: var(--adm-text-muted);">
        Supports JPG, JPEG, PNG, and WebP (Max 5MB each). Multiple files supported.
      </div>
      <input type="file" id="mediaInput" name="media_files[]" multiple accept=".jpg,.jpeg,.png,.webp" style="display: none;" onchange="document.getElementById('uploadForm').submit();">
    </label>
  </form>
</div>

<!-- Search Bar -->
<div class="admin-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
  <form method="GET" action="media.php" class="admin-toolbar" style="margin: 0;">
    <div class="admin-toolbar-group" style="flex: 1;">
      <div class="adm-search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search media by filename..." class="adm-input">
      </div>
      <button type="submit" class="btn-adm btn-adm-secondary">Search</button>
      <?php if ($search !== ''): ?>
        <a href="media.php" class="btn-adm btn-adm-secondary" style="color: var(--adm-text-dim);">Reset</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<!-- Media Grid -->
<div class="admin-card" style="padding: 1.5rem;">
  <?php if (empty($mediaItems)): ?>
    <div style="text-align: center; padding: 3rem 1.5rem;">
      <div style="width: 48px; height: 48px; margin: 0 auto 1rem; border-radius: 50%; background: var(--adm-teal-dim); display: flex; align-items: center; justify-content: center; color: var(--adm-teal);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="24" height="24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
      </div>
      <h3 style="color: #ffffff; margin-bottom: 0.5rem;">No media items found</h3>
      <p style="color: var(--adm-text-muted); margin-bottom: 0;">Upload your first image above to start building the media library.</p>
    </div>
  <?php else: ?>
    <div class="admin-media-grid">
      <?php foreach ($mediaItems as $item): ?>
        <div class="admin-media-card">
          <img src="../<?= e($item['file_path']) ?>" alt="<?= e($item['original_name']) ?>" class="admin-media-thumb" loading="lazy">
          
          <div class="admin-media-details">
            <div class="admin-media-name" title="<?= e($item['original_name']) ?>">
              <?= e($item['original_name']) ?>
            </div>
            
            <div class="admin-media-meta">
              <?= round($item['file_size'] / 1024, 1) ?> KB &bull; <?= e(strtoupper(str_replace('image/', '', $item['mime_type']))) ?>
            </div>

            <div class="admin-media-actions">
              <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" style="flex: 1;" data-copy="<?= e($item['file_path']) ?>" title="Copy Path for use in Blog / Case Study">
                Copy Path
              </button>

              <form method="POST" action="media.php" style="display: inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                <button type="submit" class="btn-adm btn-adm-danger btn-adm-sm btn-adm-icon" data-confirm="Permanently delete this image file from the server?" title="Delete Image">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<script>
// Enable Drag and Drop on dropzoneBox
const dropzone = document.getElementById('dropzoneBox');
const fileInput = document.getElementById('mediaInput');
if (dropzone && fileInput) {
  ['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.add('dragover');
    }, false);
  });
  ['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.remove('dragover');
    }, false);
  });
  dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    if (files.length > 0) {
      fileInput.files = files;
      document.getElementById('uploadForm').submit();
    }
  }, false);
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

