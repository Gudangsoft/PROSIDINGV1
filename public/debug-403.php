<?php
// DEBUG FILE - Akses: /debug-403.php?token=debug123
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'debug123') {
    die('Token: ?token=debug123');
}

$root = dirname(__DIR__);
echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#38bdf8'>DEBUG 403 - conference.stifar.ac.id</h2>\n\n";

// 1. Check files exist and content
echo "<h3 style='color:#fbbf24'>1. FILE CHECK</h3>\n";

$middlewareFile = $root . '/app/Http/Middleware/RoleMiddleware.php';
echo "RoleMiddleware.php exists: " . (file_exists($middlewareFile) ? 'YES' : 'NO') . "\n";
if (file_exists($middlewareFile)) {
    $content = file_get_contents($middlewareFile);
    echo "Contains 'comma-separated': " . (str_contains($content, 'comma-separated') ? '<span style="color:#4ade80">YES (PATCHED)</span>' : '<span style="color:#f87171">NO (OLD VERSION)</span>') . "\n";
    echo "Contains 'Admin bypasses': " . (str_contains($content, 'Admin bypasses') ? 'YES' : 'NO') . "\n";
    echo "\nMiddleware content (lines 18-40):\n";
    echo "<div style='background:#0f0f23;padding:10px;margin:10px 0'>";
    $lines = explode("\n", $content);
    echo htmlspecialchars(implode("\n", array_slice($lines, 17, 25)));
    echo "</div>\n";
}

// 2. Bootstrap Laravel
echo "\n<h3 style='color:#fbbf24'>2. LARAVEL BOOTSTRAP</h3>\n";
$laravelOK = false;
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    $laravelOK = true;
    echo "<span style='color:#4ade80'>Laravel bootstrap OK</span>\n";
} catch (Throwable $e) {
    echo "<span style='color:#f87171'>Laravel bootstrap FAILED: " . htmlspecialchars($e->getMessage()) . "</span>\n";
}

// 3. Check authenticated user
echo "\n<h3 style='color:#fbbf24'>3. AUTHENTICATED USER</h3>\n";
if ($laravelOK) {
    try {
        $user = Illuminate\Support\Facades\Auth::user();
        if ($user) {
            echo "User ID: " . $user->id . "\n";
            echo "Name: " . htmlspecialchars($user->name) . "\n";
            echo "Email: " . htmlspecialchars($user->email) . "\n";
            echo "Role: <span style='color:#fbbf24;font-weight:bold'>" . htmlspecialchars($user->role ?? 'NULL') . "</span>\n";
            
            // Simulate middleware check
            echo "\n<h3 style='color:#fbbf24'>4. SIMULATE MIDDLEWARE CHECK</h3>\n";
            $userRole = $user->role;
            
            echo "Checking route: /reviewer/reviews/{id}\n";
            echo "Route middleware: role:reviewer,editor\n\n";
            
            // Step 1: Admin bypass
            echo "Step 1 - Admin check:\n";
            echo "  \$user->role === 'admin' ? " . ($userRole === 'admin' ? '<span style="color:#4ade80">TRUE → BYPASS ALL</span>' : '<span style="color:#94a3b8">FALSE</span>') . "\n";
            
            if ($userRole !== 'admin') {
                // Step 2: Parse roles
                echo "\nStep 2 - Parse comma-separated roles:\n";
                $rawRoles = ['reviewer,editor']; // This is what Laravel passes
                echo "  Raw \$roles from middleware: " . json_encode($rawRoles) . "\n";
                
                $allowedRoles = [];
                foreach ($rawRoles as $role) {
                    foreach (explode(',', $role) as $r) {
                        $allowedRoles[] = trim($r);
                    }
                }
                echo "  Parsed \$allowedRoles: " . json_encode($allowedRoles) . "\n";
                
                // Step 3: Check
                echo "\nStep 3 - Final check:\n";
                echo "  in_array('" . $userRole . "', " . json_encode($allowedRoles) . ") = ";
                echo (in_array($userRole, $allowedRoles) ? '<span style="color:#4ade80">TRUE → ALLOW</span>' : '<span style="color:#f87171">FALSE → 403!</span>') . "\n";
            }
            
            // Conclusion
            echo "\n<h3 style='color:#fbbf24'>5. CONCLUSION</h3>\n";
            $shouldAllow = ($userRole === 'admin') || in_array($userRole, ['reviewer', 'editor']);
            if ($shouldAllow) {
                echo "<span style='color:#4ade80;font-size:18px'>✓ User SEHARUSNYA bisa akses /reviewer/reviews</span>\n";
                echo "\nJika masih 403, kemungkinan:\n";
                echo "- OPcache belum clear (restart PHP-FPM)\n";
                echo "- File middleware di server BELUM terupdate\n";
                echo "- Ada cache di nginx/apache\n";
            } else {
                echo "<span style='color:#f87171;font-size:18px'>✗ User TIDAK punya akses!</span>\n";
                echo "\nRole user: " . $userRole . "\n";
                echo "Allowed: admin, reviewer, editor\n";
                echo "\nSOLUSI: Ubah role user menjadi admin/reviewer/editor\n";
            }
            
        } else {
            echo "<span style='color:#f87171'>Tidak ada user yang login!</span>\n";
            echo "\nPastikan Anda sudah LOGIN ke aplikasi sebelum mengakses /reviewer/reviews\n";
        }
    } catch (Throwable $e) {
        echo "<span style='color:#f87171'>Error: " . htmlspecialchars($e->getMessage()) . "</span>\n";
    }
}

// 6. Check Review #10 exists
echo "\n<h3 style='color:#fbbf24'>6. CHECK REVIEW #10</h3>\n";
if ($laravelOK) {
    try {
        $review = App\Models\Review::find(10);
        if ($review) {
            echo "Review #10 exists: YES\n";
            echo "Paper ID: " . $review->paper_id . "\n";
            echo "Reviewer ID: " . $review->reviewer_id . "\n";
            echo "Status: " . $review->status . "\n";
            
            if (isset($user) && $user) {
                echo "\nAccess check for current user:\n";
                echo "- Is assigned reviewer: " . ($review->reviewer_id === $user->id ? 'YES' : 'NO') . "\n";
                echo "- Is admin/editor: " . (in_array($user->role, ['admin', 'editor']) ? 'YES' : 'NO') . "\n";
            }
        } else {
            echo "<span style='color:#f87171'>Review #10 NOT FOUND in database!</span>\n";
            echo "Coba akses review yang ada, misal /reviewer/reviews/1\n";
        }
    } catch (Throwable $e) {
        echo "Error: " . htmlspecialchars($e->getMessage()) . "\n";
    }
}

// 7. OPcache status
echo "\n<h3 style='color:#fbbf24'>7. OPCACHE STATUS</h3>\n";
if (function_exists('opcache_get_status')) {
    $status = opcache_get_status(false);
    if ($status) {
        echo "OPcache enabled: " . ($status['opcache_enabled'] ? 'YES' : 'NO') . "\n";
        echo "Cached scripts: " . ($status['opcache_statistics']['num_cached_scripts'] ?? 'N/A') . "\n";
        
        // Check if middleware is cached
        if (isset($status['scripts'][$middlewareFile])) {
            echo "RoleMiddleware.php in OPcache: YES\n";
            echo "  Last modified: " . date('Y-m-d H:i:s', $status['scripts'][$middlewareFile]['timestamp']) . "\n";
        }
    }
} else {
    echo "OPcache not available\n";
}

echo "\n<h3 style='color:#f87171'>HAPUS FILE INI SETELAH SELESAI!</h3>\n";
echo "Path: public/debug-403.php\n";
echo "</pre>";
