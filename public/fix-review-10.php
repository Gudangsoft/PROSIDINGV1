<?php
// DEBUG & FIX REVIEW #10 - Complete Solution
// Akses: /fix-review-10.php?token=fix10
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'fix10') {
    die('Token: ?token=fix10');
}

$root = dirname(__DIR__);
$action = $_GET['action'] ?? 'debug';

echo "<!DOCTYPE html><html><head><title>Fix Review #10</title></head><body>";
echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace;line-height:1.6;max-width:100%;overflow-x:auto'>";
echo "<h2 style='color:#38bdf8'>DEBUG & FIX /reviewer/reviews/10</h2>\n";
echo "<div style='margin-bottom:20px'>";
echo "<a href='?token=fix10&action=debug' style='color:#38bdf8;margin-right:15px'>[DEBUG]</a>";
echo "<a href='?token=fix10&action=fix' style='color:#4ade80;margin-right:15px'>[FIX ALL]</a>";
echo "<a href='?token=fix10&action=test' style='color:#fbbf24'>[TEST ACCESS]</a>";
echo "</div>\n";

// ═══════════════════════════════════════════════════════════════
// BOOTSTRAP LARAVEL
// ═══════════════════════════════════════════════════════════════
$laravelOK = false;
$user = null;

try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    $laravelOK = true;
    
    // Get current user from session
    $user = Illuminate\Support\Facades\Auth::user();
} catch (Throwable $e) {
    echo "<span style='color:#f87171'>Laravel bootstrap failed: " . htmlspecialchars($e->getMessage()) . "</span>\n\n";
}

// ═══════════════════════════════════════════════════════════════
// DEBUG MODE
// ═══════════════════════════════════════════════════════════════
if ($action === 'debug') {
    echo "<h3 style='color:#fbbf24'>1. CURRENT USER</h3>\n";
    if ($user) {
        echo "ID: {$user->id}\n";
        echo "Name: " . htmlspecialchars($user->name) . "\n";
        echo "Email: " . htmlspecialchars($user->email) . "\n";
        echo "Role: <span style='color:#fbbf24;font-weight:bold'>{$user->role}</span>\n";
        
        $canAccess = in_array($user->role, ['admin', 'editor', 'reviewer']);
        echo "Can access /reviewer/*: " . ($canAccess ? "<span style='color:#4ade80'>YES</span>" : "<span style='color:#f87171'>NO</span>") . "\n";
    } else {
        echo "<span style='color:#f87171'>Tidak ada user yang login!</span>\n";
        echo "Pastikan Anda sudah LOGIN sebelum mengakses halaman ini.\n";
    }
    
    echo "\n<h3 style='color:#fbbf24'>2. REVIEW #10 DATA</h3>\n";
    if ($laravelOK) {
        try {
            $review = App\Models\Review::with(['paper', 'reviewer'])->find(10);
            if ($review) {
                echo "Review #10 exists: <span style='color:#4ade80'>YES</span>\n";
                echo "Paper ID: {$review->paper_id}\n";
                echo "Paper Title: " . htmlspecialchars(Illuminate\Support\Str::limit($review->paper->title ?? 'N/A', 60)) . "\n";
                echo "Reviewer ID: {$review->reviewer_id}\n";
                echo "Reviewer Name: " . htmlspecialchars($review->reviewer->name ?? 'N/A') . "\n";
                echo "Status: {$review->status}\n";
                
                if ($user) {
                    echo "\n<span style='color:#94a3b8'>Access Check for Current User:</span>\n";
                    $isAssigned = $review->reviewer_id === $user->id;
                    $isAdminEditor = in_array($user->role, ['admin', 'editor']);
                    echo "  Is assigned reviewer: " . ($isAssigned ? 'YES' : 'NO') . "\n";
                    echo "  Is admin/editor: " . ($isAdminEditor ? 'YES' : 'NO') . "\n";
                    $canAccess = $isAssigned || $isAdminEditor;
                    echo "  <span style='color:" . ($canAccess ? '#4ade80' : '#f87171') . "'>Result: " . ($canAccess ? 'CAN ACCESS' : 'CANNOT ACCESS') . "</span>\n";
                }
            } else {
                echo "<span style='color:#f87171'>Review #10 NOT FOUND in database!</span>\n";
                
                // List available reviews
                $reviews = App\Models\Review::select('id', 'paper_id', 'reviewer_id', 'status')->limit(10)->get();
                if ($reviews->count() > 0) {
                    echo "\nAvailable reviews:\n";
                    foreach ($reviews as $r) {
                        echo "  - ID: {$r->id} | Paper: {$r->paper_id} | Reviewer: {$r->reviewer_id} | Status: {$r->status}\n";
                    }
                } else {
                    echo "No reviews in database.\n";
                }
            }
        } catch (Throwable $e) {
            echo "<span style='color:#f87171'>Error: " . htmlspecialchars($e->getMessage()) . "</span>\n";
        }
    }
    
    echo "\n<h3 style='color:#fbbf24'>3. FILE STATUS</h3>\n";
    
    $files = [
        'RoleMiddleware' => $root . '/app/Http/Middleware/RoleMiddleware.php',
        'ReviewForm' => $root . '/app/Livewire/Reviewer/ReviewForm.php',
        'ReviewList' => $root . '/app/Livewire/Reviewer/ReviewList.php',
    ];
    
    foreach ($files as $name => $path) {
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $size = strlen($content);
            
            $checks = [];
            if ($name === 'RoleMiddleware') {
                $checks['Admin bypasses'] = str_contains($content, 'Admin bypasses');
                $checks['comma-separated'] = str_contains($content, 'comma-separated') || str_contains($content, "explode(',', \$role)");
            } else {
                $checks['isAdminOrEditor'] = str_contains($content, 'isAdminOrEditor');
            }
            
            $allOk = !in_array(false, $checks, true);
            $status = $allOk ? '<span style="color:#4ade80">OK</span>' : '<span style="color:#f87171">NEEDS FIX</span>';
            echo "$name ($size bytes): $status\n";
            
            foreach ($checks as $check => $result) {
                $icon = $result ? '✓' : '✗';
                $color = $result ? '#4ade80' : '#f87171';
                echo "  <span style='color:$color'>$icon $check</span>\n";
            }
        } else {
            echo "$name: <span style='color:#f87171'>FILE NOT FOUND!</span>\n";
        }
    }
    
    echo "\n<h3 style='color:#fbbf24'>4. MIDDLEWARE SIMULATION</h3>\n";
    echo "Route: /reviewer/reviews/{review}\n";
    echo "Middleware: role:reviewer,editor\n\n";
    
    if ($user) {
        // Simulate middleware
        $userRole = $user->role;
        
        // Step 1: Admin bypass
        if ($userRole === 'admin') {
            echo "Step 1: User is ADMIN → <span style='color:#4ade80'>BYPASS ALL (PASS)</span>\n";
        } else {
            echo "Step 1: User is '$userRole' (not admin)\n";
            
            // Step 2: Parse roles
            $rawRoles = ['reviewer,editor'];
            echo "Step 2: Parse 'reviewer,editor' → ";
            $allowedRoles = [];
            foreach ($rawRoles as $role) {
                foreach (explode(',', $role) as $r) {
                    $allowedRoles[] = trim($r);
                }
            }
            echo json_encode($allowedRoles) . "\n";
            
            // Step 3: Check
            $allowed = in_array($userRole, $allowedRoles);
            echo "Step 3: in_array('$userRole', " . json_encode($allowedRoles) . ") = ";
            echo ($allowed ? "<span style='color:#4ade80'>TRUE (PASS)</span>" : "<span style='color:#f87171'>FALSE (403!)</span>") . "\n";
        }
    } else {
        echo "<span style='color:#f87171'>No user logged in - cannot simulate</span>\n";
    }
}

// ═══════════════════════════════════════════════════════════════
// FIX MODE
// ═══════════════════════════════════════════════════════════════
if ($action === 'fix') {
    echo "<h3 style='color:#4ade80'>FIXING ALL FILES...</h3>\n\n";
    
    // Fix RoleMiddleware
    echo "1. RoleMiddleware.php... ";
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

        // Parse comma-separated roles (e.g., \'reviewer,editor\' -> [\'reviewer\', \'editor\'])
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(\',\', $role) as $r) {
                $allowedRoles[] = trim($r);
            }
        }

        if (!in_array($user->role, $allowedRoles)) {
            abort(403, \'Unauthorized. Your role: \' . $user->role);
        }

        return $next($request);
    }
}
';
    
    $result = file_put_contents($root . '/app/Http/Middleware/RoleMiddleware.php', $middlewareContent);
    echo ($result !== false ? "<span style='color:#4ade80'>OK</span>\n" : "<span style='color:#f87171'>FAILED</span>\n");
    
    // Fix ReviewForm
    echo "2. ReviewForm.php... ";
    $reviewFormContent = '<?php

namespace App\Livewire\Reviewer;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ReviewForm extends Component
{
    use WithFileUploads;

    public Review $review;
    public string $comments = \'\';
    public string $commentsForEditor = \'\';
    public string $recommendation = \'\';
    public $reviewFile;

    public function mount(Review $review)
    {
        $user = Auth::user();
        
        // Allow: assigned reviewer, admin, or editor
        $isAssignedReviewer = $review->reviewer_id === $user->id;
        $isAdminOrEditor = in_array($user->role, [\'admin\', \'editor\']);
        
        if (!$isAssignedReviewer && !$isAdminOrEditor) {
            abort(403, \'You are not authorized to view this review.\');
        }

        $this->review = $review;
        $this->comments = $review->comments ?? \'\';
        $this->commentsForEditor = $review->comments_for_editor ?? \'\';
        $this->recommendation = $review->recommendation ?? \'\';
    }

    public function saveReview()
    {
        $this->validate([
            \'comments\' => \'required|min:20\',
            \'recommendation\' => \'required|in:accept,minor_revision,major_revision,reject\',
            \'reviewFile\' => \'nullable|file|mimes:doc,docx|max:20480\',
        ]);

        $data = [
            \'comments\' => $this->comments,
            \'comments_for_editor\' => $this->commentsForEditor,
            \'recommendation\' => $this->recommendation,
            \'status\' => \'completed\',
            \'reviewed_at\' => now(),
        ];

        if ($this->reviewFile) {
            $path = $this->reviewFile->store(\'reviews/\' . $this->review->paper_id, \'public\');
            $data[\'review_file_path\'] = $path;
            $data[\'review_file_name\'] = $this->reviewFile->getClientOriginalName();
        }

        $this->review->update($data);

        session()->flash(\'success\', \'Review berhasil disimpan!\');
        return redirect()->route(\'reviewer.reviews\');
    }

    public function saveDraft()
    {
        $this->review->update([
            \'comments\' => $this->comments,
            \'comments_for_editor\' => $this->commentsForEditor,
            \'recommendation\' => $this->recommendation ?: null,
            \'status\' => \'in_progress\',
        ]);

        session()->flash(\'success\', \'Draft review berhasil disimpan!\');
    }

    public function render()
    {
        $this->review->load([\'paper.user\', \'paper.files\']);
        return view(\'livewire.reviewer.review-form\')->layout(\'layouts.app\');
    }
}
';
    
    $result = file_put_contents($root . '/app/Livewire/Reviewer/ReviewForm.php', $reviewFormContent);
    echo ($result !== false ? "<span style='color:#4ade80'>OK</span>\n" : "<span style='color:#f87171'>FAILED</span>\n");
    
    // Fix ReviewList
    echo "3. ReviewList.php... ";
    $reviewListContent = '<?php

namespace App\Livewire\Reviewer;

use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReviewList extends Component
{
    public string $statusFilter = \'\';

    public function render()
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user->role, [\'admin\', \'editor\']);
        
        $reviews = Review::with([\'paper.user\', \'paper.files\', \'reviewer\'])
            ->when(!$isAdminOrEditor, fn($q) => $q->where(\'reviewer_id\', $user->id))
            ->when($this->statusFilter, fn($q) => $q->where(\'status\', $this->statusFilter))
            ->latest()
            ->paginate(10);

        return view(\'livewire.reviewer.review-list\', compact(\'reviews\', \'isAdminOrEditor\'))->layout(\'layouts.app\');
    }
}
';
    
    $result = file_put_contents($root . '/app/Livewire/Reviewer/ReviewList.php', $reviewListContent);
    echo ($result !== false ? "<span style='color:#4ade80'>OK</span>\n" : "<span style='color:#f87171'>FAILED</span>\n");
    
    // Clear caches
    echo "\n4. Clearing caches...\n";
    
    $cacheFiles = [
        $root . '/bootstrap/cache/config.php',
        $root . '/bootstrap/cache/routes-v7.php', 
        $root . '/bootstrap/cache/services.php',
        $root . '/bootstrap/cache/packages.php',
    ];
    
    foreach ($cacheFiles as $file) {
        if (file_exists($file)) {
            unlink($file);
            echo "   Deleted: " . basename($file) . "\n";
        }
    }
    
    // View cache
    $viewPath = $root . '/storage/framework/views';
    $count = 0;
    foreach (glob($viewPath . '/*.php') as $file) {
        unlink($file);
        $count++;
    }
    echo "   Deleted: $count view cache files\n";
    
    // OPcache
    if (function_exists('opcache_reset')) {
        opcache_reset();
        echo "   OPcache: RESET\n";
    }
    
    echo "\n<span style='color:#4ade80;font-size:18px'>✓ ALL FILES FIXED!</span>\n";
    echo "\nSekarang coba akses: <a href='/reviewer/reviews/10' style='color:#38bdf8'>/reviewer/reviews/10</a>\n";
}

// ═══════════════════════════════════════════════════════════════
// TEST MODE
// ═══════════════════════════════════════════════════════════════
if ($action === 'test') {
    echo "<h3 style='color:#fbbf24'>TESTING ACCESS TO /reviewer/reviews/10</h3>\n\n";
    
    if (!$user) {
        echo "<span style='color:#f87171'>ERROR: Tidak ada user yang login!</span>\n";
        echo "Silakan login terlebih dahulu, lalu akses halaman ini lagi.\n";
    } else {
        echo "Current User: {$user->name} ({$user->email})\n";
        echo "Role: <span style='color:#fbbf24'>{$user->role}</span>\n\n";
        
        // Check middleware
        $middlewarePass = false;
        if ($user->role === 'admin') {
            echo "Middleware Check: <span style='color:#4ade80'>PASS (admin bypass)</span>\n";
            $middlewarePass = true;
        } elseif (in_array($user->role, ['reviewer', 'editor'])) {
            echo "Middleware Check: <span style='color:#4ade80'>PASS (role allowed)</span>\n";
            $middlewarePass = true;
        } else {
            echo "Middleware Check: <span style='color:#f87171'>FAIL (role '{$user->role}' not allowed)</span>\n";
        }
        
        if ($middlewarePass && $laravelOK) {
            $review = App\Models\Review::find(10);
            if ($review) {
                $isAssigned = $review->reviewer_id === $user->id;
                $isAdminEditor = in_array($user->role, ['admin', 'editor']);
                
                echo "Review #10 Exists: YES\n";
                echo "Is Assigned Reviewer: " . ($isAssigned ? 'YES' : 'NO') . "\n";
                echo "Is Admin/Editor: " . ($isAdminEditor ? 'YES' : 'NO') . "\n";
                
                if ($isAssigned || $isAdminEditor) {
                    echo "\n<span style='color:#4ade80;font-size:18px'>✓ ACCESS SHOULD BE ALLOWED!</span>\n";
                    echo "\nCoba akses langsung: <a href='/reviewer/reviews/10' style='color:#38bdf8' target='_blank'>/reviewer/reviews/10</a>\n";
                } else {
                    echo "\n<span style='color:#f87171;font-size:18px'>✗ ACCESS DENIED - Not assigned reviewer</span>\n";
                    echo "\nReview #10 ditugaskan ke reviewer ID: {$review->reviewer_id}\n";
                    echo "User Anda memiliki ID: {$user->id}\n";
                }
            } else {
                echo "Review #10 Exists: <span style='color:#f87171'>NO</span>\n";
                echo "\nReview dengan ID 10 tidak ditemukan di database.\n";
            }
        }
    }
}

echo "\n<hr style='border-color:#333'>";
echo "<span style='color:#f87171'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "Path: public/fix-review-10.php\n";
echo "</pre></body></html>";
