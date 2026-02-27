<?php
// FIX REVIEWER ROLE - Complete Solution
// Akses: /fix-reviewer-role.php?token=fixrole2026
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'fixrole2026') {
    die('Token: ?token=fixrole2026');
}

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace;line-height:1.6'>";
echo "<h2 style='color:#38bdf8'>FIX REVIEWER ROLE - Complete Solution</h2>\n\n";

$root = dirname(__DIR__);

// ═══════════════════════════════════════════════════════════════
// 1. FIX ROLE MIDDLEWARE
// ═══════════════════════════════════════════════════════════════
echo "<h3 style='color:#fbbf24'>1. FIX ROLE MIDDLEWARE</h3>\n";

$middlewareFile = $root . '/app/Http/Middleware/RoleMiddleware.php';
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
            abort(403, \'Unauthorized.\');
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
            abort(403, \'Unauthorized.\');
        }

        return $next($request);
    }
}
';

if (file_put_contents($middlewareFile, $middlewareContent) !== false) {
    echo "<span style='color:#4ade80'>✓ RoleMiddleware.php updated</span>\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to update RoleMiddleware.php</span>\n";
}

// ═══════════════════════════════════════════════════════════════
// 2. FIX REVIEW LIST
// ═══════════════════════════════════════════════════════════════
echo "\n<h3 style='color:#fbbf24'>2. FIX REVIEW LIST</h3>\n";

$reviewListFile = $root . '/app/Livewire/Reviewer/ReviewList.php';
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

if (file_put_contents($reviewListFile, $reviewListContent) !== false) {
    echo "<span style='color:#4ade80'>✓ ReviewList.php updated</span>\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to update ReviewList.php</span>\n";
}

// ═══════════════════════════════════════════════════════════════
// 3. FIX REVIEW FORM
// ═══════════════════════════════════════════════════════════════
echo "\n<h3 style='color:#fbbf24'>3. FIX REVIEW FORM</h3>\n";

$reviewFormFile = $root . '/app/Livewire/Reviewer/ReviewForm.php';
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
            abort(403);
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
        ], [
            \'comments.required\' => \'Komentar review wajib diisi.\',
            \'comments.min\' => \'Komentar minimal 20 karakter.\',
            \'recommendation.required\' => \'Rekomendasi wajib dipilih.\',
            \'reviewFile.mimes\' => \'File harus berformat Word (.doc, .docx).\',
            \'reviewFile.max\' => \'Ukuran file maksimal 20MB.\',
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

        // Send notification to admins/editors
        $adminIds = \App\Models\User::whereIn(\'role\', [\'admin\', \'editor\'])->pluck(\'id\');
        \App\Models\Notification::createForUsers(
            $adminIds,
            \'info\',
            \'Review Selesai\',
            \'Review untuk paper "\' . \Illuminate\Support\Str::limit($this->review->paper->title, 50) . \'" telah selesai.\',
            route(\'admin.paper.detail\', $this->review->paper),
            \'Lihat Paper\'
        );

        session()->flash(\'success\', \'Review berhasil disimpan!\');
        return redirect()->route(\'reviewer.reviews\');
    }

    public function render()
    {
        return view(\'livewire.reviewer.review-form\')->layout(\'layouts.app\');
    }
}
';

if (file_put_contents($reviewFormFile, $reviewFormContent) !== false) {
    echo "<span style='color:#4ade80'>✓ ReviewForm.php updated</span>\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to update ReviewForm.php</span>\n";
}

// ═══════════════════════════════════════════════════════════════
// 4. CLEAR ALL CACHES
// ═══════════════════════════════════════════════════════════════
echo "\n<h3 style='color:#fbbf24'>4. CLEAR ALL CACHES</h3>\n";

// Bootstrap cache
$cacheFiles = [
    $root . '/bootstrap/cache/config.php',
    $root . '/bootstrap/cache/routes-v7.php',
    $root . '/bootstrap/cache/services.php',
    $root . '/bootstrap/cache/packages.php',
];

foreach ($cacheFiles as $cacheFile) {
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
        echo "Deleted: " . basename($cacheFile) . "\n";
    }
}

// View cache
$viewCachePath = $root . '/storage/framework/views';
if (is_dir($viewCachePath)) {
    $count = 0;
    foreach (glob($viewCachePath . '/*.php') as $file) {
        unlink($file);
        $count++;
    }
    echo "Deleted: $count view cache files\n";
}

// App cache
$appCachePath = $root . '/storage/framework/cache/data';
if (is_dir($appCachePath)) {
    $count = 0;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($appCachePath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            unlink($file->getRealPath());
            $count++;
        }
    }
    echo "Deleted: $count app cache files\n";
}

// OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache: RESET\n";
} else {
    echo "OPcache: not available\n";
}

// ═══════════════════════════════════════════════════════════════
// 5. VERIFY FILES
// ═══════════════════════════════════════════════════════════════
echo "\n<h3 style='color:#fbbf24'>5. VERIFY FILES</h3>\n";

$files = [
    'RoleMiddleware' => $middlewareFile,
    'ReviewList' => $reviewListFile,
    'ReviewForm' => $reviewFormFile,
];

foreach ($files as $name => $file) {
    $content = file_get_contents($file);
    $checks = [];
    
    if ($name === 'RoleMiddleware') {
        $checks['comma-separated'] = str_contains($content, 'comma-separated');
        $checks['Admin bypasses'] = str_contains($content, 'Admin bypasses');
    } else {
        $checks['isAdminOrEditor'] = str_contains($content, 'isAdminOrEditor');
    }
    
    $allPassed = !in_array(false, $checks, true);
    $status = $allPassed ? '<span style="color:#4ade80">OK</span>' : '<span style="color:#f87171">FAIL</span>';
    
    echo "$name: $status\n";
    foreach ($checks as $check => $result) {
        echo "  - $check: " . ($result ? 'YES' : 'NO') . "\n";
    }
}

// ═══════════════════════════════════════════════════════════════
// 6. TEST USER (if Laravel can bootstrap)
// ═══════════════════════════════════════════════════════════════
echo "\n<h3 style='color:#fbbf24'>6. TEST MIDDLEWARE LOGIC</h3>\n";

// Simulate middleware check
function testMiddlewareCheck($userRole, $routeRoles) {
    // Admin bypass
    if ($userRole === 'admin') {
        return true;
    }
    
    // Parse comma-separated
    $allowedRoles = [];
    foreach ($routeRoles as $role) {
        foreach (explode(',', $role) as $r) {
            $allowedRoles[] = trim($r);
        }
    }
    
    return in_array($userRole, $allowedRoles);
}

$testCases = [
    ['admin', ['reviewer,editor'], true, 'Admin accessing /reviewer/*'],
    ['editor', ['reviewer,editor'], true, 'Editor accessing /reviewer/*'],
    ['reviewer', ['reviewer,editor'], true, 'Reviewer accessing /reviewer/*'],
    ['author', ['reviewer,editor'], false, 'Author accessing /reviewer/* (should fail)'],
    ['reviewer', ['admin'], false, 'Reviewer accessing /admin/* (should fail)'],
];

foreach ($testCases as $case) {
    [$userRole, $routeRoles, $expected, $desc] = $case;
    $result = testMiddlewareCheck($userRole, $routeRoles);
    $passed = $result === $expected;
    $icon = $passed ? '✓' : '✗';
    $color = $passed ? '#4ade80' : '#f87171';
    echo "<span style='color:$color'>$icon $desc: " . ($result ? 'ALLOWED' : 'DENIED') . "</span>\n";
}

// ═══════════════════════════════════════════════════════════════
// SUMMARY
// ═══════════════════════════════════════════════════════════════
echo "\n<h3 style='color:#4ade80'>DONE!</h3>\n";
echo "Semua file telah diupdate. Sekarang coba:\n\n";
echo "1. Login sebagai user dengan role 'reviewer'\n";
echo "2. Akses: <a href='/reviewer/reviews' style='color:#38bdf8'>/reviewer/reviews</a>\n";
echo "3. Atau login sebagai admin/editor untuk melihat semua review\n\n";

echo "<span style='color:#f87171;font-weight:bold'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "rm public/fix-reviewer-role.php\n";
echo "</pre>";
