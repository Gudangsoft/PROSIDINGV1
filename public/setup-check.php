<?php
/**
 * Emergency Setup Check
 * 
 * File ini untuk mengecek apakah ada masalah dengan setup Laravel
 * Akses via: https://domain.com/setup-check.php
 * 
 * HAPUS FILE INI SETELAH SETUP SELESAI!
 */

// Disable error display for security
error_reporting(E_ALL);
ini_set('display_errors', 0);

$checks = [];
$allPassed = true;

// 1. Check PHP Version
$phpVersion = phpversion();
$phpOk = version_compare($phpVersion, '8.2.0', '>=');
$checks['PHP Version'] = [
    'status' => $phpOk,
    'value' => $phpVersion,
    'required' => '>= 8.2.0'
];
if (!$phpOk) $allPassed = false;

// 2. Check if .env exists
$envExists = file_exists(__DIR__ . '/../.env');
$checks['.env File'] = [
    'status' => $envExists,
    'value' => $envExists ? 'Exists' : 'Not Found',
    'required' => 'Must exist'
];
if (!$envExists) $allPassed = false;

// 3. Check .env.example
$envExampleExists = file_exists(__DIR__ . '/../.env.example');
$checks['.env.example'] = [
    'status' => $envExampleExists,
    'value' => $envExampleExists ? 'Exists' : 'Not Found',
    'required' => 'Reference file'
];

// 4. Check storage directory writable
$storageWritable = is_writable(__DIR__ . '/../storage');
$checks['storage/ Writable'] = [
    'status' => $storageWritable,
    'value' => $storageWritable ? 'Writable' : 'Not Writable',
    'required' => 'Must be writable (chmod 755 or 775)'
];
if (!$storageWritable) $allPassed = false;

// 5. Check bootstrap/cache writable
$cacheWritable = is_writable(__DIR__ . '/../bootstrap/cache');
$checks['bootstrap/cache/ Writable'] = [
    'status' => $cacheWritable,
    'value' => $cacheWritable ? 'Writable' : 'Not Writable',
    'required' => 'Must be writable'
];
if (!$cacheWritable) $allPassed = false;

// 6. Check vendor/autoload.php
$vendorExists = file_exists(__DIR__ . '/../vendor/autoload.php');
$checks['vendor/autoload.php'] = [
    'status' => $vendorExists,
    'value' => $vendorExists ? 'Exists' : 'Not Found (run: composer install)',
    'required' => 'Must exist'
];
if (!$vendorExists) $allPassed = false;

// 7. Check .setup-token
$tokenFile = __DIR__ . '/../.setup-token';
$tokenExists = file_exists($tokenFile);
$checks['.setup-token File'] = [
    'status' => $tokenExists,
    'value' => $tokenExists ? 'Exists (Token: ' . substr(file_get_contents($tokenFile), 0, 8) . '...)' : 'Not Found - Will use default token',
    'required' => 'Recommended for security'
];

// 8. Check required PHP extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    $checks["PHP ext: $ext"] = [
        'status' => $loaded,
        'value' => $loaded ? 'Loaded' : 'Not Loaded',
        'required' => 'Required'
    ];
    if (!$loaded) $allPassed = false;
}

// 9. Try to read .env if exists
$envContents = [];
if ($envExists) {
    $lines = @file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines) {
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            $parts = explode('=', $line, 2);
            if (count($parts) == 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1], " \t\n\r\0\x0B\"'");
                // Only show safe values
                if (in_array($key, ['APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_URL', 'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'SESSION_DRIVER', 'CACHE_DRIVER'])) {
                    $envContents[$key] = $value;
                }
            }
        }
    }
}

// Check potential issues
$issues = [];
if (isset($envContents['SESSION_DRIVER']) && $envContents['SESSION_DRIVER'] === 'database') {
    $issues[] = "SESSION_DRIVER is 'database'. If database not migrated, this will cause 500 error. Temporarily change to 'file'.";
}
if (isset($envContents['CACHE_DRIVER']) && $envContents['CACHE_DRIVER'] === 'database') {
    $issues[] = "CACHE_DRIVER is 'database'. If database not migrated, this will cause 500 error. Temporarily change to 'file'.";
}
if (isset($envContents['APP_DEBUG']) && $envContents['APP_DEBUG'] === 'false') {
    $issues[] = "APP_DEBUG is 'false'. Temporarily set to 'true' to see detailed error messages.";
}
if (empty($envContents['APP_KEY'] ?? '')) {
    $issues[] = "APP_KEY might be empty. Run 'php artisan key:generate' or use setup wizard.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Check - Prosiding Conference</title>
    <style>
        * { box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; margin: 0; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding: 30px; margin-bottom: 20px; }
        h1 { color: #1f2937; margin-top: 0; }
        h2 { color: #374151; font-size: 18px; margin-top: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f3f4f6; font-weight: 600; }
        .status { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status.ok { background: #d1fae5; color: #065f46; }
        .status.fail { background: #fee2e2; color: #991b1b; }
        .status.warn { background: #fef3c7; color: #92400e; }
        .alert { padding: 16px; border-radius: 8px; margin: 16px 0; }
        .alert.success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert.danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert.warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .btn { display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin-top: 16px; }
        .btn:hover { opacity: 0.9; }
        code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 13px; }
        pre { background: #1f2937; color: #e5e7eb; padding: 16px; border-radius: 8px; overflow-x: auto; font-size: 13px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>🔧 Setup Environment Check</h1>
        <p style="color: #6b7280;">Checking server requirements and configuration...</p>
        
        <?php if ($allPassed): ?>
        <div class="alert success">
            ✅ All basic checks passed! You can proceed to the setup wizard.
        </div>
        <a href="/setup" class="btn">→ Go to Setup Wizard</a>
        <?php else: ?>
        <div class="alert danger">
            ❌ Some checks failed. Please fix the issues below before proceeding.
        </div>
        <?php endif; ?>
        
        <h2>System Requirements</h2>
        <table>
            <tr><th>Check</th><th>Status</th><th>Value</th><th>Required</th></tr>
            <?php foreach ($checks as $name => $check): ?>
            <tr>
                <td><?= htmlspecialchars($name) ?></td>
                <td><span class="status <?= $check['status'] ? 'ok' : 'fail' ?>"><?= $check['status'] ? '✓ OK' : '✗ FAIL' ?></span></td>
                <td><code><?= htmlspecialchars($check['value']) ?></code></td>
                <td><?= htmlspecialchars($check['required']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <?php if (!empty($envContents)): ?>
        <h2>Current .env Configuration</h2>
        <table>
            <tr><th>Key</th><th>Value</th></tr>
            <?php foreach ($envContents as $key => $value): ?>
            <tr>
                <td><code><?= htmlspecialchars($key) ?></code></td>
                <td><code><?= htmlspecialchars($value) ?></code></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        
        <?php if (!empty($issues)): ?>
        <h2>⚠️ Potential Issues</h2>
        <div class="alert warning">
            <ul style="margin: 0; padding-left: 20px;">
            <?php foreach ($issues as $issue): ?>
                <li><?= htmlspecialchars($issue) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <h2>Quick Fix Commands</h2>
        <p>If you have SSH/terminal access, run these commands:</p>
        <pre># Fix permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs storage/framework

# Copy .env if not exists
cp .env.example .env

# Temporarily set session to file (edit .env)
# SESSION_DRIVER=file
# CACHE_DRIVER=file
# APP_DEBUG=true

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear</pre>
        
        <h2>🔒 Security Warning</h2>
        <div class="alert warning">
            <strong>DELETE THIS FILE</strong> (public/setup-check.php) after setup is complete!<br>
            This file exposes sensitive server information.
        </div>
    </div>
</div>
</body>
</html>
