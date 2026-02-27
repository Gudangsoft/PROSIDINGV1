<?php
// PATCH MIDDLEWARE - Pure PHP tanpa Laravel
// Akses: /patch-middleware.php?token=patch2026
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'patch2026') {
    die('Token: ?token=patch2026');
}

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace;line-height:1.6'>";
echo "<h2 style='color:#38bdf8'>PATCH MIDDLEWARE - Pure PHP</h2>\n\n";

$root = dirname(__DIR__);
$middlewareFile = $root . '/app/Http/Middleware/RoleMiddleware.php';

// Check current state
echo "<h3 style='color:#fbbf24'>1. CHECK CURRENT STATE</h3>\n";
if (!file_exists($middlewareFile)) {
    echo "<span style='color:#f87171'>ERROR: RoleMiddleware.php not found!</span>\n";
    echo "Path: $middlewareFile\n";
    exit;
}

$currentContent = file_get_contents($middlewareFile);
echo "File exists: YES\n";
echo "File size: " . strlen($currentContent) . " bytes\n";
echo "Already patched: " . (str_contains($currentContent, 'comma-separated') ? '<span style="color:#4ade80">YES</span>' : '<span style="color:#f87171">NO</span>') . "\n";

// The correct middleware content
$newMiddleware = '<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \\Closure(\\Illuminate\\Http\\Request): (\\Symfony\\Component\\HttpFoundation\\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(\'login\');
        }

        // Admin bypasses all role restrictions
        if ($user->role === \'admin\') {
            return $next($request);
        }

        // Parse comma-separated roles (e.g., "reviewer,editor" becomes ["reviewer", "editor"])
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(\',\', $role) as $r) {
                $allowedRoles[] = trim($r);
            }
        }

        // Check if user has one of the allowed roles
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, \'Unauthorized action. Your role: \' . $user->role . \' | Allowed: \' . implode(\', \', $allowedRoles));
        }

        return $next($request);
    }
}
';

// Patch the file
echo "\n<h3 style='color:#fbbf24'>2. PATCHING FILE</h3>\n";

// Backup first
$backupFile = $middlewareFile . '.backup.' . date('YmdHis');
if (copy($middlewareFile, $backupFile)) {
    echo "Backup created: " . basename($backupFile) . "\n";
}

// Write new content
$result = file_put_contents($middlewareFile, $newMiddleware);
if ($result !== false) {
    echo "<span style='color:#4ade80'>✓ RoleMiddleware.php PATCHED!</span>\n";
    echo "Bytes written: $result\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to write file!</span>\n";
    echo "Check file permissions!\n";
    exit;
}

// Verify
echo "\n<h3 style='color:#fbbf24'>3. VERIFY PATCH</h3>\n";
clearstatcache(true, $middlewareFile);
$verifyContent = file_get_contents($middlewareFile);
$hasCommaParsing = str_contains($verifyContent, 'comma-separated');
$hasAdminBypass = str_contains($verifyContent, 'Admin bypasses');

echo "Contains 'comma-separated': " . ($hasCommaParsing ? '<span style="color:#4ade80">YES</span>' : '<span style="color:#f87171">NO</span>') . "\n";
echo "Contains 'Admin bypasses': " . ($hasAdminBypass ? '<span style="color:#4ade80">YES</span>' : '<span style="color:#f87171">NO</span>') . "\n";

if ($hasCommaParsing && $hasAdminBypass) {
    echo "\n<span style='color:#4ade80;font-size:18px'>✓ PATCH SUCCESSFUL!</span>\n";
}

// Clear Laravel cache files manually
echo "\n<h3 style='color:#fbbf24'>4. CLEAR CACHE FILES</h3>\n";

$cacheFiles = [
    $root . '/bootstrap/cache/config.php',
    $root . '/bootstrap/cache/routes-v7.php',
    $root . '/bootstrap/cache/services.php',
    $root . '/bootstrap/cache/packages.php',
];

foreach ($cacheFiles as $cacheFile) {
    if (file_exists($cacheFile)) {
        if (unlink($cacheFile)) {
            echo "Deleted: " . basename($cacheFile) . "\n";
        }
    }
}

// Clear view cache
$viewCachePath = $root . '/storage/framework/views';
if (is_dir($viewCachePath)) {
    $count = 0;
    foreach (glob($viewCachePath . '/*.php') as $file) {
        unlink($file);
        $count++;
    }
    echo "Deleted: $count view cache files\n";
}

// Show new middleware content
echo "\n<h3 style='color:#fbbf24'>5. NEW MIDDLEWARE CONTENT</h3>\n";
echo "<div style='background:#0f0f23;padding:15px;margin:10px 0;border-left:3px solid #4ade80'>";
echo htmlspecialchars($verifyContent);
echo "</div>\n";

// Instructions
echo "\n<h3 style='color:#4ade80'>NEXT STEPS</h3>\n";
echo "1. Buka tab baru: <a href='/reviewer/reviews/10' style='color:#38bdf8'>/reviewer/reviews/10</a>\n";
echo "2. Mungkin perlu login ulang jika session bermasalah\n";
echo "3. <span style='color:#f87171'>HAPUS file patch-middleware.php setelah selesai!</span>\n";

echo "\n</pre>";
