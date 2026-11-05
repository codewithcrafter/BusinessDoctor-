<?php
/**
 * BusinessDoctor Admin Account & Security Settings
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$errors = [];
$successMsg = '';

// Fetch current user details from database
$stmt = $pdo->prepare("SELECT id, username, email, full_name, role, last_login, created_at FROM admin_users WHERE id = ?");
$stmt->execute([$adminUser['id']]);
$userRecord = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Security token invalid or expired. Please refresh and retry.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'update_profile') {
            $fullName = trim($_POST['full_name'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

            if ($fullName === '') $errors[] = 'Full Name cannot be empty.';
            if (!$email) $errors[] = 'A valid corporate email address is required.';

            // Check if email taken by another user
            if (empty($errors)) {
                $check = $pdo->prepare("SELECT id FROM admin_users WHERE email = ? AND id != ?");
                $check->execute([$email, $adminUser['id']]);
                if ($check->fetch()) {
                    $errors[] = 'This email address is already registered to another account.';
                } else {
                    $update = $pdo->prepare("UPDATE admin_users SET full_name = ?, email = ?, updated_at = datetime('now') WHERE id = ?");
                    $update->execute([$fullName, $email, $adminUser['id']]);

                    $_SESSION['admin_user']['full_name'] = $fullName;
                    $_SESSION['admin_user']['email'] = $email;
                    $adminUser['full_name'] = $fullName;
                    $adminUser['email'] = $email;

                    setFlashMessage('success', 'Profile information updated successfully.');
                    header('Location: security.php');
                    exit;
                }
            }
        } elseif ($action === 'change_password') {
            $currentPass = trim($_POST['current_password'] ?? '');
            $newPass = trim($_POST['new_password'] ?? '');
            $confirmPass = trim($_POST['confirm_password'] ?? '');

            if ($currentPass === '') $errors[] = 'Please enter your current password.';
            if (strlen($newPass) < 8) $errors[] = 'New password must be at least 8 characters long.';
            if ($newPass !== $confirmPass) $errors[] = 'New password and confirmation do not match.';

            if (empty($errors)) {
                $pStmt = $pdo->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
                $pStmt->execute([$adminUser['id']]);
                $hash = $pStmt->fetchColumn();

                if (!$hash || !password_verify($currentPass, $hash)) {
                    $errors[] = 'Your current password was entered incorrectly.';
                } else {
                    $newHash = password_hash($newPass, PASSWORD_BCRYPT);
                    $update = $pdo->prepare("UPDATE admin_users SET password_hash = ?, updated_at = datetime('now') WHERE id = ?");
                    $update->execute([$newHash, $adminUser['id']]);

                    setFlashMessage('success', 'Password updated successfully. Please use your new password next time you sign in.');
                    header('Location: security.php');
                    exit;
                }
            }
        }
    }
}

$pageTitle = 'Account & Security';
require_once __DIR__ . '/includes/header.php';
?>

<div style="margin-bottom: 1.5rem;">
  <h2 style="font-size: 1.4rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem; font-family: var(--adm-font-display);">
    Account &amp; Security Controls
  </h2>
  <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.85rem;">
    Manage administrative credentials, profile information, and review security session parameters.
  </p>
</div>

<?php if (!empty($errors)): ?>
  <div class="adm-toast error" style="margin-bottom: 1.5rem; max-width: 100%;">
    <div>
      <strong>Security Notice:</strong>
      <ul style="margin: 0.35rem 0 0; padding-left: 1.25rem;">
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<div class="adm-form-grid">
  
  <!-- Main Column -->
  <div>
    
    <!-- Profile Card -->
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title">Administrative Profile</h3>
        <span class="status-pill status-published">Active Account</span>
      </div>

      <form method="POST" action="security.php">
        <input type="hidden" name="action" value="update_profile">
        <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

        <div class="adm-form-group">
          <label class="adm-label" for="usernameDisplay">Username (Immutable)</label>
          <input type="text" id="usernameDisplay" value="<?= e($userRecord['username'] ?? 'admin') ?>" disabled class="adm-input" style="opacity: 0.7; font-family: var(--adm-font-mono);">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="profileName">Full Name <span class="required">*</span></label>
          <input type="text" id="profileName" name="full_name" value="<?= e($userRecord['full_name'] ?? '') ?>" required class="adm-input">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="profileEmail">Corporate Email Address <span class="required">*</span></label>
          <input type="email" id="profileEmail" name="email" value="<?= e($userRecord['email'] ?? '') ?>" required class="adm-input">
        </div>

        <button type="submit" class="btn-adm btn-adm-primary">
          Save Profile Changes
        </button>
      </form>
    </div>

    <!-- Password Change Card -->
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title">Change Password</h3>
        <span style="font-size: 0.76rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">BCRYPT HASHING</span>
      </div>

      <form method="POST" action="security.php">
        <input type="hidden" name="action" value="change_password">
        <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

        <div class="adm-form-group">
          <label class="adm-label" for="currentPass">Current Password <span class="required">*</span></label>
          <input type="password" id="currentPass" name="current_password" required placeholder="••••••••••••" class="adm-input">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="newPass">New Password (Min 8 Characters) <span class="required">*</span></label>
          <input type="password" id="newPass" name="new_password" required placeholder="••••••••••••" class="adm-input">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="confirmPass">Confirm New Password <span class="required">*</span></label>
          <input type="password" id="confirmPass" name="confirm_password" required placeholder="••••••••••••" class="adm-input">
        </div>

        <button type="submit" class="btn-adm btn-adm-primary">
          Update Password
        </button>
      </form>
    </div>

  </div>

  <!-- Sidebar Column -->
  <div>
    
    <!-- Security Telemetry Card -->
    <div class="admin-card">
      <h3 class="admin-card-title" style="margin-bottom: 1rem;">System &amp; Security Status</h3>

      <div style="display: flex; flex-direction: column; gap: 0.85rem; font-size: 0.84rem;">
        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--adm-border-subtle); padding-bottom: 0.5rem;">
          <span style="color: var(--adm-text-muted);">Database Driver:</span>
          <span style="font-family: var(--adm-font-mono); font-weight: 700; color: var(--adm-teal);"><?= strtoupper(Database::getDriver()) ?></span>
        </div>

        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--adm-border-subtle); padding-bottom: 0.5rem;">
          <span style="color: var(--adm-text-muted);">Environment:</span>
          <span style="font-family: var(--adm-font-mono); font-weight: 700; color: #34D399;"><?= strtoupper(APP_ENV) ?></span>
        </div>

        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--adm-border-subtle); padding-bottom: 0.5rem;">
          <span style="color: var(--adm-text-muted);">CSRF Defense:</span>
          <span style="font-family: var(--adm-font-mono); color: #34D399;">Active (HMAC SHA-256)</span>
        </div>

        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--adm-border-subtle); padding-bottom: 0.5rem;">
          <span style="color: var(--adm-text-muted);">Session Security:</span>
          <span style="font-family: var(--adm-font-mono); color: #34D399;">HttpOnly &bull; Lax</span>
        </div>

        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--adm-border-subtle); padding-bottom: 0.5rem;">
          <span style="color: var(--adm-text-muted);">Rate Limiting:</span>
          <span style="font-family: var(--adm-font-mono); color: #34D399;">Active (15m Lockout)</span>
        </div>

        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--adm-border-subtle); padding-bottom: 0.5rem;">
          <span style="color: var(--adm-text-muted);">Last Sign-In:</span>
          <span style="font-family: var(--adm-font-mono); font-size: 0.76rem; color: var(--adm-text-dim);"><?= e($userRecord['last_login'] ?? 'Just now') ?></span>
        </div>
      </div>
    </div>

    <!-- Uploads Protection Card -->
    <div class="admin-card">
      <h3 class="admin-card-title" style="margin-bottom: 0.75rem;">Uploads Protection</h3>
      <p style="font-size: 0.8rem; color: var(--adm-text-muted); line-height: 1.5; margin: 0;">
        All uploaded media files are sanitized, validated with server-side MIME inspection, given cryptographically randomized names, and stored in <code>assets/uploads/</code> with PHP script execution strictly disabled via <code>.htaccess</code>.
      </p>
    </div>

  </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

