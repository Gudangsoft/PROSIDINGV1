<?php
// DIRECT REVIEW ACCESS - Bypass all middleware
// Akses: /direct-review.php?token=direct2026&id=10
// HAPUS SETELAH SELESAI!

$token = $_GET['token'] ?? '';
$reviewId = $_GET['id'] ?? 10;

if ($token !== 'direct2026') {
    die('Usage: /direct-review.php?token=direct2026&id=10');
}

$root = dirname(__DIR__);

// Bootstrap Laravel
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = Illuminate\Support\Facades\Auth::user();

// Action handlers
$action = $_GET['action'] ?? 'info';

if ($action === 'info') {
    header('Content-Type: text/html; charset=utf-8');
    echo "<!DOCTYPE html><html><head><title>Direct Review Access</title></head><body>";
    echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
    echo "<h2 style='color:#38bdf8'>DIRECT REVIEW ACCESS DEBUG</h2>\n\n";
    
    echo "<h3 style='color:#fbbf24'>1. CURRENT USER SESSION</h3>\n";
    if ($user) {
        echo "Logged in: YES\n";
        echo "User ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: <span style='color:#4ade80;font-weight:bold'>{$user->role}</span>\n";
    } else {
        echo "<span style='color:#f87171'>NOT LOGGED IN!</span>\n";
        echo "Anda harus login terlebih dahulu.\n";
    }
    
    echo "\n<h3 style='color:#fbbf24'>2. REVIEW #{$reviewId} DATA</h3>\n";
    $review = App\Models\Review::with(['paper', 'reviewer'])->find($reviewId);
    if ($review) {
        echo "Exists: YES\n";
        echo "Paper ID: {$review->paper_id}\n";
        echo "Paper Title: " . htmlspecialchars($review->paper->title ?? 'N/A') . "\n";
        echo "Assigned Reviewer ID: {$review->reviewer_id}\n";
        echo "Assigned Reviewer: " . ($review->reviewer->name ?? 'N/A') . "\n";
        echo "Status: {$review->status}\n";
    } else {
        echo "<span style='color:#f87171'>NOT FOUND!</span>\n";
        
        // Show available reviews
        $reviews = App\Models\Review::select('id', 'paper_id', 'reviewer_id')->get();
        echo "\nAvailable reviews:\n";
        foreach ($reviews as $r) {
            echo "  - ID {$r->id}: Paper #{$r->paper_id}, Reviewer #{$r->reviewer_id}\n";
        }
    }
    
    echo "\n<h3 style='color:#fbbf24'>3. ACCESS CHECK</h3>\n";
    if ($user && $review) {
        $isAssigned = $review->reviewer_id === $user->id;
        $isAdmin = $user->role === 'admin';
        $isEditor = $user->role === 'editor';
        $isReviewer = $user->role === 'reviewer';
        
        echo "User role: {$user->role}\n";
        echo "Is Admin: " . ($isAdmin ? 'YES' : 'NO') . "\n";
        echo "Is Editor: " . ($isEditor ? 'YES' : 'NO') . "\n";
        echo "Is Reviewer: " . ($isReviewer ? 'YES' : 'NO') . "\n";
        echo "Is Assigned to this Review: " . ($isAssigned ? 'YES' : 'NO') . "\n";
        
        $canAccess = $isAdmin || $isEditor || $isAssigned;
        echo "\n<span style='color:" . ($canAccess ? '#4ade80' : '#f87171') . ";font-size:18px'>";
        echo "Result: " . ($canAccess ? "CAN ACCESS" : "CANNOT ACCESS") . "</span>\n";
        
        if (!$canAccess && $isReviewer && !$isAssigned) {
            echo "\n<span style='color:#fbbf24'>Note: Anda adalah reviewer tapi tidak ditugaskan ke review ini.</span>\n";
            echo "Review ini ditugaskan ke reviewer ID: {$review->reviewer_id}\n";
            echo "ID Anda: {$user->id}\n";
        }
    }
    
    echo "\n<h3 style='color:#fbbf24'>4. MIDDLEWARE FILE CHECK</h3>\n";
    $middlewarePath = $root . '/app/Http/Middleware/RoleMiddleware.php';
    $content = file_get_contents($middlewarePath);
    
    echo "File exists: " . (file_exists($middlewarePath) ? 'YES' : 'NO') . "\n";
    echo "Contains 'Admin bypasses': " . (str_contains($content, 'Admin bypasses') ? '<span style="color:#4ade80">YES</span>' : '<span style="color:#f87171">NO</span>') . "\n";
    echo "Contains explode for comma: " . (str_contains($content, "explode(',',") ? '<span style="color:#4ade80">YES</span>' : '<span style="color:#f87171">NO</span>') . "\n";
    
    echo "\n<h3 style='color:#fbbf24'>5. ACTIONS</h3>\n";
    echo "<a href='?token=direct2026&id={$reviewId}&action=fix_user' style='color:#4ade80'>[Make current user ADMIN]</a>\n";
    echo "<a href='?token=direct2026&id={$reviewId}&action=assign_me' style='color:#38bdf8'>[Assign this review to me]</a>\n";
    echo "<a href='?token=direct2026&id={$reviewId}&action=fix_middleware' style='color:#fbbf24'>[Fix Middleware File]</a>\n";
    echo "<a href='?token=direct2026&id={$reviewId}&action=clear_cache' style='color:#f87171'>[Clear All Cache]</a>\n";
    
    echo "\n</pre></body></html>";
}

if ($action === 'fix_user' && $user) {
    // Make user admin temporarily
    $user->role = 'admin';
    $user->save();
    
    header('Content-Type: text/html');
    echo "<pre style='background:#1a1a2e;color:#4ade80;padding:20px'>";
    echo "User {$user->email} role changed to: ADMIN\n\n";
    echo "Sekarang coba akses: <a href='/reviewer/reviews/{$reviewId}' style='color:#38bdf8'>/reviewer/reviews/{$reviewId}</a>\n";
    echo "\n<a href='?token=direct2026&id={$reviewId}' style='color:#fbbf24'>← Back to debug</a>";
    echo "</pre>";
}

if ($action === 'assign_me' && $user && $review) {
    $review->reviewer_id = $user->id;
    $review->save();
    
    header('Content-Type: text/html');
    echo "<pre style='background:#1a1a2e;color:#4ade80;padding:20px'>";
    echo "Review #{$reviewId} assigned to user: {$user->email} (ID: {$user->id})\n\n";
    echo "Sekarang coba akses: <a href='/reviewer/reviews/{$reviewId}' style='color:#38bdf8'>/reviewer/reviews/{$reviewId}</a>\n";
    echo "\n<a href='?token=direct2026&id={$reviewId}' style='color:#fbbf24'>← Back to debug</a>";
    echo "</pre>";
}

if ($action === 'fix_middleware') {
    $middlewareContent = '<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route(\'login\');
        }

        // Admin bypasses all role restrictions
        if ($user->role === \'admin\') {
            return $next($request);
        }

        // Parse comma-separated roles
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(\',\', $role) as $r) {
                $allowedRoles[] = trim($r);
            }
        }

        if (!in_array($user->role, $allowedRoles)) {
            abort(403, \'Access denied. Your role: \' . $user->role . \' | Required: \' . implode(\', \', $allowedRoles));
        }

        return $next($request);
    }
}
';
    
    file_put_contents($root . '/app/Http/Middleware/RoleMiddleware.php', $middlewareContent);
    
    // Also clear opcache for this file
    if (function_exists('opcache_invalidate')) {
        opcache_invalidate($root . '/app/Http/Middleware/RoleMiddleware.php', true);
    }
    
    header('Content-Type: text/html');
    echo "<pre style='background:#1a1a2e;color:#4ade80;padding:20px'>";
    echo "RoleMiddleware.php FIXED!\n\n";
    echo "<a href='?token=direct2026&id={$reviewId}&action=clear_cache' style='color:#fbbf24'>[Clear Cache Now]</a>\n";
    echo "<a href='?token=direct2026&id={$reviewId}' style='color:#38bdf8'>← Back to debug</a>";
    echo "</pre>";
}

if ($action === 'clear_cache') {
    // Clear all caches
    $cleared = [];
    
    // Bootstrap cache
    foreach (['config.php', 'routes-v7.php', 'services.php', 'packages.php'] as $file) {
        $path = $root . '/bootstrap/cache/' . $file;
        if (file_exists($path)) {
            unlink($path);
            $cleared[] = $file;
        }
    }
    
    // View cache
    $viewCount = 0;
    foreach (glob($root . '/storage/framework/views/*.php') as $file) {
        unlink($file);
        $viewCount++;
    }
    
    // OPcache
    $opcacheStatus = 'N/A';
    if (function_exists('opcache_reset')) {
        opcache_reset();
        $opcacheStatus = 'RESET';
    }
    
    // Run artisan commands
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    Illuminate\Support\Facades\Artisan::call('config:clear');
    Illuminate\Support\Facades\Artisan::call('route:clear');
    Illuminate\Support\Facades\Artisan::call('view:clear');
    
    header('Content-Type: text/html');
    echo "<pre style='background:#1a1a2e;color:#4ade80;padding:20px'>";
    echo "CACHE CLEARED!\n\n";
    echo "Bootstrap cache: " . (count($cleared) > 0 ? implode(', ', $cleared) : 'none') . "\n";
    echo "View cache: {$viewCount} files\n";
    echo "OPcache: {$opcacheStatus}\n";
    echo "Artisan: cache, config, route, view cleared\n\n";
    echo "Sekarang coba akses: <a href='/reviewer/reviews/{$reviewId}' style='color:#38bdf8'>/reviewer/reviews/{$reviewId}</a>\n";
    echo "\n<a href='?token=direct2026&id={$reviewId}' style='color:#fbbf24'>← Back to debug</a>";
    echo "</pre>";
}
