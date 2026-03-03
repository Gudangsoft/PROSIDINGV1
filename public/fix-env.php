<?php
/**
 * Emergency .env Fixer for Setup
 * 
 * Akses via: https://conference.areai.or.id/fix-env.php
 * 
 * File ini akan memperbaiki .env agar setup bisa berjalan
 * HAPUS FILE INI SETELAH SETUP SELESAI!
 */

// Security check - must provide token
$token = $_GET['token'] ?? '';
$expectedToken = 'fix-env-2026';

// Read .setup-token if exists
$tokenFile = __DIR__ . '/../.setup-token';
if (file_exists($tokenFile)) {
    $expectedToken = trim(file_get_contents($tokenFile));
}

if ($token !== $expectedToken) {
    http_response_code(403);
    echo "<!DOCTYPE html><html><head><title>Access Denied</title></head><body>";
    echo "<h1>Access Denied</h1>";
    echo "<p>Provide token: <code>?token=YOUR_TOKEN</code></p>";
    echo "<p>Token can be found in <code>.setup-token</code> file or use default: <code>fix-env-2026</code></p>";
    echo "</body></html>";
    exit;
}

$envPath = __DIR__ . '/../.env';
$envExamplePath = __DIR__ . '/../.env.example';
$messages = [];
$success = true;

// Step 1: Check if .env exists, if not copy from .env.example
if (!file_exists($envPath)) {
    if (file_exists($envExamplePath)) {
        if (copy($envExamplePath, $envPath)) {
            $messages[] = ['type' => 'success', 'msg' => '.env file created from .env.example'];
        } else {
            $messages[] = ['type' => 'error', 'msg' => 'Failed to create .env file. Check directory permissions.'];
            $success = false;
        }
    } else {
        // Create minimal .env
        $minimalEnv = <<<'ENV'
APP_NAME="Prosiding Conference"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
ENV;
        if (file_put_contents($envPath, $minimalEnv)) {
            $messages[] = ['type' => 'success', 'msg' => 'Minimal .env file created'];
        } else {
            $messages[] = ['type' => 'error', 'msg' => 'Failed to create .env file'];
            $success = false;
        }
    }
}

// Step 2: Read and fix .env contents
if (file_exists($envPath) && is_readable($envPath)) {
    $envContent = file_get_contents($envPath);
    $originalContent = $envContent;
    
    // Fix 1: Change DATABASE connection from sqlite to mysql if needed
    if (preg_match('/DB_CONNECTION\s*=\s*sqlite/i', $envContent)) {
        $envContent = preg_replace('/DB_CONNECTION\s*=\s*sqlite/i', 'DB_CONNECTION=mysql', $envContent);
        $messages[] = ['type' => 'info', 'msg' => 'Changed DB_CONNECTION from sqlite to mysql'];
    }
    
    // Fix 2: Change SESSION_DRIVER from database to file
    if (preg_match('/SESSION_DRIVER\s*=\s*database/i', $envContent)) {
        $envContent = preg_replace('/SESSION_DRIVER\s*=\s*database/i', 'SESSION_DRIVER=file', $envContent);
        $messages[] = ['type' => 'info', 'msg' => 'Changed SESSION_DRIVER from database to file'];
    }
    
    // Fix 3: Change CACHE_STORE/CACHE_DRIVER from database to file
    if (preg_match('/CACHE_STORE\s*=\s*database/i', $envContent)) {
        $envContent = preg_replace('/CACHE_STORE\s*=\s*database/i', 'CACHE_STORE=file', $envContent);
        $messages[] = ['type' => 'info', 'msg' => 'Changed CACHE_STORE from database to file'];
    }
    if (preg_match('/CACHE_DRIVER\s*=\s*database/i', $envContent)) {
        $envContent = preg_replace('/CACHE_DRIVER\s*=\s*database/i', 'CACHE_DRIVER=file', $envContent);
        $messages[] = ['type' => 'info', 'msg' => 'Changed CACHE_DRIVER from database to file'];
    }
    
    // Fix 4: Change QUEUE_CONNECTION from database to sync
    if (preg_match('/QUEUE_CONNECTION\s*=\s*database/i', $envContent)) {
        $envContent = preg_replace('/QUEUE_CONNECTION\s*=\s*database/i', 'QUEUE_CONNECTION=sync', $envContent);
        $messages[] = ['type' => 'info', 'msg' => 'Changed QUEUE_CONNECTION from database to sync'];
    }
    
    // Fix 5: Ensure APP_DEBUG is true for setup
    if (preg_match('/APP_DEBUG\s*=\s*false/i', $envContent)) {
        $envContent = preg_replace('/APP_DEBUG\s*=\s*false/i', 'APP_DEBUG=true', $envContent);
        $messages[] = ['type' => 'info', 'msg' => 'Changed APP_DEBUG to true'];
    }
    
    // Save if changed
    if ($envContent !== $originalContent) {
        if (file_put_contents($envPath, $envContent)) {
            $messages[] = ['type' => 'success', 'msg' => '.env file updated successfully'];
        } else {
            $messages[] = ['type' => 'error', 'msg' => 'Failed to save .env file'];
            $success = false;
        }
    } else {
        $messages[] = ['type' => 'info', 'msg' => 'No changes needed in .env'];
    }
} else {
    $messages[] = ['type' => 'error', 'msg' => '.env file not readable'];
    $success = false;
}

// Step 3: Clear cache files
$cachePaths = [
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes-v7.php',
    __DIR__ . '/../bootstrap/cache/services.php',
    __DIR__ . '/../bootstrap/cache/packages.php',
];

foreach ($cachePaths as $cachePath) {
    if (file_exists($cachePath)) {
        if (@unlink($cachePath)) {
            $messages[] = ['type' => 'info', 'msg' => 'Deleted cache: ' . basename($cachePath)];
        }
    }
}

// Step 4: Create session directory if needed
$sessionPath = __DIR__ . '/../storage/framework/sessions';
if (!is_dir($sessionPath)) {
    if (@mkdir($sessionPath, 0755, true)) {
        $messages[] = ['type' => 'success', 'msg' => 'Created sessions directory'];
    }
}

// Step 5: Create cache directory if needed
$cachePath = __DIR__ . '/../storage/framework/cache/data';
if (!is_dir($cachePath)) {
    if (@mkdir($cachePath, 0755, true)) {
        $messages[] = ['type' => 'success', 'msg' => 'Created cache directory'];
    }
}

// Step 6: Check directory permissions
$checkDirs = [
    'storage' => __DIR__ . '/../storage',
    'storage/logs' => __DIR__ . '/../storage/logs',
    'storage/framework' => __DIR__ . '/../storage/framework',
    'bootstrap/cache' => __DIR__ . '/../bootstrap/cache',
];

foreach ($checkDirs as $name => $path) {
    if (is_dir($path)) {
        if (!is_writable($path)) {
            $messages[] = ['type' => 'warning', 'msg' => "$name is not writable. Run: chmod 755 $name"];
        }
    }
}

// Read current .env for display
$currentEnv = [];
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) == 2) {
            $key = trim($parts[0]);
            // Only show safe keys
            if (in_array($key, ['APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_URL', 'APP_TIMEZONE', 'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'SESSION_DRIVER', 'CACHE_STORE', 'QUEUE_CONNECTION'])) {
                $currentEnv[$key] = trim($parts[1], " \t\n\r\0\x0B\"'");
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
    <title>Fix .env - Prosiding Conference</title>
    <style>
        * { box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; margin: 0; }
        .container { max-width: 700px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding: 30px; }
        h1 { color: #1f2937; margin-top: 0; }
        .msg { padding: 12px 16px; border-radius: 8px; margin: 8px 0; display: flex; align-items: center; gap: 10px; }
        .msg.success { background: #d1fae5; color: #065f46; }
        .msg.error { background: #fee2e2; color: #991b1b; }
        .msg.info { background: #dbeafe; color: #1e40af; }
        .msg.warning { background: #fef3c7; color: #92400e; }
        .btn { display: inline-block; padding: 14px 28px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin-top: 20px; }
        .btn:hover { opacity: 0.9; }
        .btn.danger { background: #dc2626; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { padding: 8px 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f3f4f6; }
        code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
        .warning-box { background: #fef3c7; border: 1px solid #f59e0b; padding: 16px; border-radius: 8px; margin-top: 20px; color: #92400e; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>🔧 Fix .env Configuration</h1>
        
        <?php foreach ($messages as $msg): ?>
        <div class="msg <?= $msg['type'] ?>">
            <?php if ($msg['type'] === 'success'): ?>✅
            <?php elseif ($msg['type'] === 'error'): ?>❌
            <?php elseif ($msg['type'] === 'warning'): ?>⚠️
            <?php else: ?>ℹ️
            <?php endif; ?>
            <?= htmlspecialchars($msg['msg']) ?>
        </div>
        <?php endforeach; ?>
        
        <?php if (!empty($currentEnv)): ?>
        <h3 style="margin-top: 24px;">Current .env Configuration</h3>
        <table>
            <tr><th>Key</th><th>Value</th></tr>
            <?php foreach ($currentEnv as $key => $value): ?>
            <tr>
                <td><code><?= htmlspecialchars($key) ?></code></td>
                <td><code><?= htmlspecialchars($value ?: '(empty)') ?></code></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <a href="/setup" class="btn">→ Go to Setup Wizard</a>
        <?php else: ?>
        <a href="?token=<?= htmlspecialchars($token) ?>" class="btn">🔄 Try Again</a>
        <?php endif; ?>
        
        <div class="warning-box">
            <strong>⚠️ Security Warning:</strong><br>
            DELETE this file (<code>public/fix-env.php</code>) after setup is complete!
        </div>
    </div>
</div>
</body>
</html>
