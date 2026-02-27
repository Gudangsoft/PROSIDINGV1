<?php
// FIX REVIEW FORM - Direct patch
// Akses: /fix-reviewform.php?token=fixform2026
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'fixform2026') {
    die('Token: ?token=fixform2026');
}

$root = dirname(__DIR__);

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#38bdf8'>FIX REVIEW FORM</h2>\n\n";

// The fixed ReviewForm.php content
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
    public bool $isAdminOrEditor = false;

    public function mount(Review $review)
    {
        $user = Auth::user();
        
        // Check user role - FIXED: ensure proper comparison
        $userRole = strtolower(trim($user->role ?? \'\'));
        
        $this->isAdminOrEditor = in_array($userRole, [\'admin\', \'editor\']);
        $isAssignedReviewer = ($review->reviewer_id == $user->id); // Use == for loose comparison
        
        // Allow access if: admin, editor, or assigned reviewer
        if (!$this->isAdminOrEditor && !$isAssignedReviewer) {
            // Log for debugging
            \Log::warning("Review access denied", [
                \'user_id\' => $user->id,
                \'user_role\' => $userRole,
                \'review_id\' => $review->id,
                \'reviewer_id\' => $review->reviewer_id,
                \'isAdminOrEditor\' => $this->isAdminOrEditor,
                \'isAssignedReviewer\' => $isAssignedReviewer,
            ]);
            abort(403, \'Access denied. Role: \' . $userRole);
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

$filePath = $root . '/app/Livewire/Reviewer/ReviewForm.php';

// Backup
copy($filePath, $filePath . '.bak.' . date('His'));

// Write new content
$result = file_put_contents($filePath, $reviewFormContent);

if ($result !== false) {
    echo "<span style='color:#4ade80'>✓ ReviewForm.php UPDATED ($result bytes)</span>\n\n";
} else {
    echo "<span style='color:#f87171'>✗ Failed to update ReviewForm.php</span>\n\n";
}

// Clear caches
echo "Clearing caches...\n";

// Bootstrap cache
foreach (glob($root . '/bootstrap/cache/*.php') as $file) {
    unlink($file);
    echo "  Deleted: " . basename($file) . "\n";
}

// View cache  
$viewCount = 0;
foreach (glob($root . '/storage/framework/views/*.php') as $file) {
    unlink($file);
    $viewCount++;
}
echo "  Deleted: $viewCount view cache files\n";

// OPcache
if (function_exists('opcache_invalidate')) {
    opcache_invalidate($filePath, true);
    echo "  OPcache: invalidated ReviewForm.php\n";
}
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "  OPcache: RESET\n";
}

echo "\n<span style='color:#4ade80;font-size:18px'>DONE!</span>\n\n";
echo "Sekarang coba akses: <a href='/reviewer/reviews/10' style='color:#38bdf8'>/reviewer/reviews/10</a>\n\n";

// Show current user info
echo "<h3 style='color:#fbbf24'>DEBUG: Current User</h3>\n";
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    $user = Illuminate\Support\Facades\Auth::user();
    if ($user) {
        echo "User: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: '{$user->role}'\n";
        echo "Role (lowercase): '" . strtolower(trim($user->role ?? '')) . "'\n";
        
        $isAdmin = strtolower(trim($user->role ?? '')) === 'admin';
        echo "Is Admin: " . ($isAdmin ? 'YES' : 'NO') . "\n";
    } else {
        echo "<span style='color:#f87171'>Not logged in!</span>\n";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n<span style='color:#f87171'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";
