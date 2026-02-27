<?php
// BYPASS TOTAL - Remove all access restrictions
// Akses: /bypass-review.php?token=bypass123
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'bypass123') {
    die('Token: ?token=bypass123');
}

$root = dirname(__DIR__);

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#f87171'>BYPASS TOTAL - REMOVE ALL ACCESS CHECKS</h2>\n\n";

// ReviewForm - NO ACCESS CHECK AT ALL
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
        // NO ACCESS CHECK - BYPASS TOTAL
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
        session()->flash(\'success\', \'Draft berhasil disimpan!\');
    }

    public function render()
    {
        $this->review->load([\'paper.user\', \'paper.files\']);
        return view(\'livewire.reviewer.review-form\')->layout(\'layouts.app\');
    }
}
';

echo "1. Writing ReviewForm.php (NO ACCESS CHECK)... ";
$result1 = file_put_contents($root . '/app/Livewire/Reviewer/ReviewForm.php', $reviewFormContent);
echo ($result1 ? "<span style='color:#4ade80'>OK ($result1 bytes)</span>\n" : "<span style='color:#f87171'>FAILED</span>\n");

// RoleMiddleware - Allow ALL authenticated users
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

        // BYPASS: Allow all authenticated users
        return $next($request);
    }
}
';

echo "2. Writing RoleMiddleware.php (BYPASS ALL)... ";
$result2 = file_put_contents($root . '/app/Http/Middleware/RoleMiddleware.php', $middlewareContent);
echo ($result2 ? "<span style='color:#4ade80'>OK ($result2 bytes)</span>\n" : "<span style='color:#f87171'>FAILED</span>\n");

// Clear ALL caches aggressively
echo "\n3. Clearing ALL caches...\n";

// Bootstrap cache
$bootstrapCache = $root . '/bootstrap/cache';
foreach (glob($bootstrapCache . '/*.php') as $file) {
    @unlink($file);
    echo "   Deleted: " . basename($file) . "\n";
}

// View cache
$viewCache = $root . '/storage/framework/views';
$count = 0;
foreach (glob($viewCache . '/*.php') as $file) {
    @unlink($file);
    $count++;
}
echo "   Deleted: $count view cache files\n";

// Session cache (might help)
$sessionCache = $root . '/storage/framework/sessions';
// Don't delete sessions, might log user out

// App cache
$appCache = $root . '/storage/framework/cache/data';
if (is_dir($appCache)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($appCache, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    $cacheCount = 0;
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            @unlink($file->getRealPath());
            $cacheCount++;
        }
    }
    echo "   Deleted: $cacheCount app cache files\n";
}

// OPcache - FULL RESET
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "   OPcache: <span style='color:#4ade80'>FULL RESET</span>\n";
} else {
    echo "   OPcache: not available\n";
}

// Try artisan commands
echo "\n4. Running Artisan commands...\n";
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo "   artisan optimize:clear: <span style='color:#4ade80'>OK</span>\n";
} catch (Throwable $e) {
    echo "   Artisan error: " . $e->getMessage() . "\n";
}

// Verify files
echo "\n5. Verifying files...\n";

$reviewFormPath = $root . '/app/Livewire/Reviewer/ReviewForm.php';
$content = file_get_contents($reviewFormPath);
$hasNoAccessCheck = str_contains($content, 'NO ACCESS CHECK');
echo "   ReviewForm.php has 'NO ACCESS CHECK': " . ($hasNoAccessCheck ? "<span style='color:#4ade80'>YES</span>" : "<span style='color:#f87171'>NO</span>") . "\n";

$middlewarePath = $root . '/app/Http/Middleware/RoleMiddleware.php';
$content2 = file_get_contents($middlewarePath);
$hasBypass = str_contains($content2, 'BYPASS');
echo "   RoleMiddleware.php has 'BYPASS': " . ($hasBypass ? "<span style='color:#4ade80'>YES</span>" : "<span style='color:#f87171'>NO</span>") . "\n";

echo "\n<span style='color:#4ade80;font-size:20px'>✓ BYPASS COMPLETE!</span>\n\n";
echo "Semua pengecekan akses telah DIHAPUS.\n";
echo "Sekarang coba akses: <a href='/reviewer/reviews/10' style='color:#38bdf8;font-size:18px'>/reviewer/reviews/10</a>\n\n";

echo "<span style='color:#fbbf24'>PERINGATAN: Ini hanya untuk testing!</span>\n";
echo "<span style='color:#f87171'>Setelah berhasil, kembalikan pengecekan akses yang proper.</span>\n\n";

echo "<span style='color:#f87171;font-weight:bold'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";
