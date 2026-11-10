<?php
/**
 * BusinessDoctor Executive Admin Login - IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $rateLimit = checkLoginRateLimit($clientIp);

    if (!$rateLimit['allowed']) {
        $error = $rateLimit['message'];
    } else {
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            $error = 'Security session expired. Please refresh and try again.';
        } else {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($username) && !empty($password)) {
                try {
                    $pdo = Database::getConnection();
                    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ? LIMIT 1");
                    $stmt->execute([$username, $username]);
                    $user = $stmt->fetch();

                    if ($user && password_verify($password, $user['password_hash'])) {
                        // Clear any rate-limit failures for this client IP
                        clearLoginAttempts($clientIp);

                        // Security: Regenerate session ID upon privilege elevation to prevent Session Fixation
                        session_regenerate_id(true);

                        $update = $pdo->prepare("UPDATE admin_users SET last_login = " . (Database::getDriver() === 'sqlite' ? "datetime('now')" : "NOW()") . " WHERE id = ?");
                        $update->execute([$user['id']]);

                        $_SESSION['admin_user'] = [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'full_name' => $user['full_name'],
                            'role' => $user['role']
                        ];

                        header("Location: dashboard.php");
                        exit;
                    } else {
                        recordFailedLogin($clientIp);
                        $error = 'Invalid credentials. Please verify your username and password.';
                    }
                } catch (Exception $e) {
                    $error = 'Authentication service encountered a database exception.';
                }
            } else {
                $error = 'Please provide both username and password.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Projects & Management Console — BusinessDoctor</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/variables.css">
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>
<body style="background-color: var(--color-obsidian); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 2rem;">

  <div class="card" style="width: 100%; max-width: 440px; background: var(--color-dark-surface); border-color: rgba(255,255,255,0.1); color: var(--color-white); box-shadow: var(--shadow-xl);">
    <div style="text-align: center; margin-bottom: 2rem;">
      <a href="<?= appUrl() ?>" class="brand-logo" style="justify-content: center; color: #ffffff; margin-bottom: 1.25rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;" aria-label="BusinessDoctor Home">
        <img src="<?= getAssetUrl('assets/img/bdr_logo_transparent.png') ?>" alt="BusinessDoctor Logo" style="height: 68px; width: auto; object-fit: contain; aspect-ratio: 1816 / 1131; display: block; margin: 0 auto;">
      </a>
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-teal-400);">
        ● CLIENT PROJECTS & AUDIT CONSOLE
      </div>
    </div>

    <?php if ($error): ?>
      <div class="form-alert error" style="margin-bottom: 1.5rem; font-size: 0.88rem;">
        <?= e($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

      <div class="form-group">
        <label class="form-label" style="color: #F5F7FA;" for="username">Administrator Username or Email</label>
        <input type="text" id="username" name="username" required class="form-control" style="background: rgba(255,255,255,0.06); border-color: rgba(6, 181, 249, 0.25); color: #F5F7FA;" placeholder="admin" autofocus>
      </div>

      <div class="form-group">
        <label class="form-label" style="color: #F5F7FA;" for="password">Security Password</label>
        <input type="password" id="password" name="password" required class="form-control" style="background: rgba(255,255,255,0.06); border-color: rgba(6, 181, 249, 0.25); color: #F5F7FA;" placeholder="••••••••••••••••">
      </div>

      <div style="margin-top: 2rem;">
        <button type="submit" class="btn btn-primary" style="width: 100%;">
          <span>Sign In to Project Console</span>
          <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </button>
      </div>

      <div style="margin-top: 1.5rem; text-align: center; font-size: 0.8rem; color: #B8C7D9;">
        Default Credentials: <code style="color: #06B5F9; font-family: var(--font-mono);">admin</code> / <code style="color: #06B5F9; font-family: var(--font-mono);">Admin@BusinessDoctor2026</code>
      </div>
    </form>
  </div>

</body>
</html>
