<?php
// DIRECT FIX - Upload dan akses: /direct-fix.php?token=stifar2026
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'stifar2026') {
    die('Token salah. Gunakan: ?token=stifar2026');
}

$root = dirname(__DIR__);
$results = [];

// Clear OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    $results[] = 'OPcache cleared';
}

// 1. FIX ROLEMIDDLEWARE - Ini yang paling penting!
$middlewareFile = $root . '/app/Http/Middleware/RoleMiddleware.php';
$middlewareCode = '<?php

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

@chmod($middlewareFile, 0666);
if (file_put_contents($middlewareFile, $middlewareCode)) {
    $results[] = 'OK: RoleMiddleware.php FIXED!';
} else {
    $results[] = 'ERR: RoleMiddleware.php gagal ditulis';
}

// 2. FIX REVIEWFORM
$reviewFormFile = $root . '/app/Livewire/Reviewer/ReviewForm.php';
$reviewFormCode = '<?php

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
        session()->flash(\'success\', \'Draft berhasil disimpan.\');
    }

    public function render()
    {
        $this->review->load([\'paper.user\', \'paper.files\']);
        return view(\'livewire.reviewer.review-form\')->layout(\'layouts.app\');
    }
}
';

@chmod($reviewFormFile, 0666);
if (file_put_contents($reviewFormFile, $reviewFormCode)) {
    $results[] = 'OK: ReviewForm.php FIXED!';
} else {
    $results[] = 'ERR: ReviewForm.php gagal ditulis';
}

// 3. FIX REVIEWLIST
$reviewListFile = $root . '/app/Livewire/Reviewer/ReviewList.php';
$reviewListCode = '<?php

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

@chmod($reviewListFile, 0666);
if (file_put_contents($reviewListFile, $reviewListCode)) {
    $results[] = 'OK: ReviewList.php FIXED!';
} else {
    $results[] = 'ERR: ReviewList.php gagal ditulis';
}

// 4. Clear ALL caches
$vs = glob($root . '/storage/framework/views/*.php') ?: [];
foreach ($vs as $f) @unlink($f);
$results[] = 'Cleared ' . count($vs) . ' view caches';

foreach (['routes-v7.php','routes.php','config.php','events.php','services.php','packages.php'] as $cf) {
    $p = $root . '/bootstrap/cache/' . $cf;
    if (file_exists($p)) @unlink($p);
}
$results[] = 'Cleared bootstrap cache';

// OPcache invalidate specific files
if (function_exists('opcache_invalidate')) {
    opcache_invalidate($middlewareFile, true);
    opcache_invalidate($reviewFormFile, true);
    opcache_invalidate($reviewListFile, true);
    $results[] = 'OPcache invalidated for patched files';
}

// Final OPcache reset
if (function_exists('opcache_reset')) {
    opcache_reset();
}

// Show results
?><!DOCTYPE html>
<html>
<head><title>Direct Fix</title>
<style>
body{font-family:monospace;background:#1a1a2e;color:#eee;padding:30px}
.ok{color:#4ade80}.err{color:#f87171}
pre{background:#0f0f23;padding:15px;border-radius:8px;overflow-x:auto}
a{color:#60a5fa}
</style>
</head>
<body>
<h1>Direct Fix Results</h1>
<?php foreach($results as $r): ?>
<p class="<?=str_contains($r,'OK')?'ok':(str_contains($r,'ERR')?'err':'')?>"><?=htmlspecialchars($r)?></p>
<?php endforeach; ?>

<h2>Verifikasi RoleMiddleware.php:</h2>
<pre><?php
$content = @file_get_contents($middlewareFile);
if ($content) {
    // Show lines 18-35
    $lines = explode("\n", $content);
    echo htmlspecialchars(implode("\n", array_slice($lines, 17, 20)));
} else {
    echo "File tidak bisa dibaca";
}
?></pre>

<h2>Test Links (buka di tab baru):</h2>
<ul>
<li><a href="/reviewer/reviews" target="_blank">/reviewer/reviews</a></li>
<li><a href="/reviewer/reviews/10" target="_blank">/reviewer/reviews/10</a></li>
</ul>

<p style="color:#f87171;margin-top:30px"><strong>HAPUS FILE INI!</strong> Path: public/direct-fix.php</p>
</body>
</html>
