<?php
// EMERGENCY FIX - conference.stifar.ac.id
// Akses: /fix-emergency.php?token=stifar-fix-2026
// HAPUS FILE INI SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'stifar-fix-2026') {
    http_response_code(403);
    die('<h2 style="color:red;font-family:monospace">403</h2><p style="font-family:monospace">Tambahkan: <code>?token=stifar-fix-2026</code></p>');
}

$root = dirname(__DIR__);
$results = [];

// 1. Clear all caches
foreach (['routes-v7.php','routes.php','config.php','events.php','services.php','packages.php'] as $cf) {
    $p = $root . '/bootstrap/cache/' . $cf;
    if (file_exists($p)) { unlink($p); $results[] = "CLEARED cache: $cf"; }
}
$views = glob($root . '/storage/framework/views/*.php') ?: [];
foreach ($views as $f) unlink($f);
$results[] = "CLEARED " . count($views) . " compiled views";

$n = 0;
$cacheDir = $root . '/storage/framework/cache/data';
if (is_dir($cacheDir)) {
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($cacheDir, RecursiveDirectoryIterator::SKIP_DOTS)) as $f) {
        if ($f->isFile()) { unlink($f->getPathname()); $n++; }
    }
}
$results[] = "CLEARED $n app cache files";

// 2. Bootstrap Laravel for DB
$laravelReady = false;
try {
    $app = require $root . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    $laravelReady = true;
    $results[] = "Laravel bootstrap OK";
} catch (Throwable $e) {
    $results[] = "Laravel bootstrap FAILED: " . $e->getMessage();
}

// === FILE CONTENTS ===
$MIDDLEWARE_CONTENT = '<?php

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

        if (!in_array($user->role, $roles)) {
            abort(403, \'Unauthorized.\');
        }

        return $next($request);
    }
}
';

$REVIEW_FORM_CONTENT = '<?php

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

        $adminIds = \\App\\Models\\User::whereIn(\'role\', [\'admin\', \'editor\'])->pluck(\'id\');
        \\App\\Models\\Notification::createForUsers(
            $adminIds,
            \'info\',
            \'Review Selesai\',
            \'Review untuk paper "\' . \\Illuminate\\Support\\Str::limit($this->review->paper->title, 50) . \'" telah selesai.\',
            route(\'admin.paper.detail\', $this->review->paper),
            \'Lihat Paper\'
        );

        session()->flash(\'success\', \'Review berhasil disimpan!\');
        return redirect()->route(\'reviewer.reviews\');
    }

    public function saveDraft()
    {
        $data = [
            \'comments\' => $this->comments,
            \'comments_for_editor\' => $this->commentsForEditor,
            \'recommendation\' => $this->recommendation ?: null,
            \'status\' => \'in_progress\',
        ];
        $this->review->update($data);
        session()->flash(\'success\', \'Draft berhasil disimpan.\');
    }

    public function render()
    {
        return view(\'livewire.reviewer.review-form\')->layout(\'layouts.app\');
    }
}
';

$REVIEW_LIST_CONTENT = '<?php

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

$PAPER_DETAIL_CONTENT = '<?php

namespace App\Livewire\Author;

use App\Models\Paper;
use App\Models\PaperFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PaperDetail extends Component
{
    use WithFileUploads;

    public Paper $paper;
    public $revisionFile;
    public string $revisionNotes = \'\';
    public string $videoUrl = \'\';

    public function mount(Paper $paper)
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user?->role, [\'admin\', \'editor\']);
        $isImpersonating = session()->has(\'impersonating_from\');

        if (! $isAdminOrEditor && ! $isImpersonating && (int) $paper->user_id !== (int) Auth::id()) {
            abort(403);
        }
        $this->paper = $paper;
        $this->videoUrl = Schema::hasColumn(\'papers\', \'video_presentation_url\')
            ? ($paper->video_presentation_url ?? \'\')
            : \'\';
    }

    public function submitRevision()
    {
        $this->validate([
            \'revisionFile\' => \'required|file|mimes:pdf,doc,docx|max:10240\',
        ]);

        $path = $this->revisionFile->store(\'papers/\' . $this->paper->id . \'/revisions\', \'public\');
        PaperFile::create([
            \'paper_id\' => $this->paper->id,
            \'type\' => \'revision\',
            \'file_path\' => $path,
            \'original_name\' => $this->revisionFile->getClientOriginalName(),
            \'mime_type\' => $this->revisionFile->getMimeType(),
            \'file_size\' => $this->revisionFile->getSize(),
            \'notes\' => $this->revisionNotes,
        ]);

        $this->paper->update([\'status\' => \'revised\']);
        
        $adminIds = \\App\\Models\\User::whereIn(\'role\', [\'admin\', \'editor\'])->pluck(\'id\');
        \\App\\Models\\Notification::createForUsers(
            $adminIds,
            \'info\',
            \'Revisi Paper Diterima\',
            \'Author telah mengupload revisi untuk paper "\' . \\Illuminate\\Support\\Str::limit($this->paper->title, 50) . \'"\',
            route(\'admin.paper.detail\', $this->paper),
            \'Lihat Paper\'
        );
        
        $this->revisionFile = null;
        $this->revisionNotes = \'\';
        $this->paper->refresh();

        session()->flash(\'success\', \'Revisi berhasil diunggah!\');
    }

    public function submitVideoUrl()
    {
        if (! Schema::hasColumn(\'papers\', \'video_presentation_url\')) {
            session()->flash(\'error\', \'Fitur ini belum tersedia. Hubungi administrator.\');
            return;
        }

        $this->validate([
            \'videoUrl\' => \'required|url|max:500\',
        ], [
            \'videoUrl.required\' => \'Link video wajib diisi.\',
            \'videoUrl.url\'      => \'Format link video tidak valid.\',
        ]);

        $this->paper->update([\'video_presentation_url\' => $this->videoUrl]);
        $this->paper->refresh();

        $adminIds = \\App\\Models\\User::whereIn(\'role\', [\'admin\', \'editor\'])->pluck(\'id\');
        \\App\\Models\\Notification::createForUsers(
            $adminIds,
            \'info\',
            \'Video Pemaparan Disubmit\',
            \'Author telah mengirimkan link video pemaparan untuk paper "\' . \\Illuminate\\Support\\Str::limit($this->paper->title, 50) . \'"\',
            route(\'admin.paper.detail\', $this->paper),
            \'Lihat Paper\'
        );

        session()->flash(\'success\', \'Link video pemaparan berhasil disimpan!\');
    }

    public function render()
    {
        $relations = [\'files\', \'reviews.reviewer\', \'payment\'];
        if (Schema::hasTable(\'deliverables\')) {
            $relations[] = \'deliverables\';
        }
        $this->paper->load($relations);

        if (! $this->paper->relationLoaded(\'deliverables\')) {
            $this->paper->setRelation(\'deliverables\', collect());
        }

        return view(\'livewire.author.paper-detail\')->layout(\'layouts.app\');
    }
}
';

$PAYMENT_UPLOAD_CONTENT = '<?php

namespace App\Livewire\Author;

use App\Models\Paper;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class PaymentUpload extends Component
{
    use WithFileUploads;

    public Paper $paper;
    public Payment $payment;
    public $proofFile;
    public string $paymentMethod = \'\';

    public function mount(Paper $paper)
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user?->role, [\'admin\', \'editor\']);
        $isImpersonating = session()->has(\'impersonating_from\');
        if (! $isAdminOrEditor && ! $isImpersonating && (int) $paper->user_id !== (int) Auth::id()) abort(403);
        $this->paper = $paper;
        $this->payment = $paper->payment ?? new Payment();
    }

    public function uploadProof()
    {
        $this->validate([
            \'proofFile\' => \'required|file|mimes:jpg,jpeg,png,pdf|max:5120\',
            \'paymentMethod\' => \'required|string\',
        ]);

        $path = $this->proofFile->store(\'payments/\' . $this->paper->id, \'public\');

        $this->payment->update([
            \'payment_proof\' => $path,
            \'payment_method\' => $this->paymentMethod,
            \'status\' => \'uploaded\',
            \'paid_at\' => now(),
        ]);

        $this->paper->update([\'status\' => \'payment_uploaded\']);
        $this->paper->refresh();
        $this->payment->refresh();
        $this->proofFile = null;

        session()->flash(\'success\', \'Bukti pembayaran berhasil diunggah!\');
    }

    public function render()
    {
        return view(\'livewire.author.payment-upload\')->layout(\'layouts.app\');
    }
}
';

$HELPDESK_DETAIL_CONTENT = '<?php

namespace App\Livewire\Author;

use App\Models\HelpdeskTicket;
use App\Models\HelpdeskReply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HelpdeskDetail extends Component
{
    public HelpdeskTicket $ticket;
    public string $replyMessage = \'\';

    public function mount(HelpdeskTicket $ticket)
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user?->role, [\'admin\', \'editor\']);
        $isImpersonating = session()->has(\'impersonating_from\');
        if (! $isAdminOrEditor && ! $isImpersonating && (int) $ticket->user_id !== (int) Auth::id()) {
            abort(403);
        }
        $this->ticket = $ticket;
    }

    public function sendReply()
    {
        $this->validate([
            \'replyMessage\' => \'required|string|min:2\',
        ]);

        HelpdeskReply::create([
            \'ticket_id\' => $this->ticket->id,
            \'user_id\' => Auth::id(),
            \'message\' => $this->replyMessage,
        ]);

        if ($this->ticket->status === \'resolved\') {
            $this->ticket->update([\'status\' => \'open\']);
        }

        $this->replyMessage = \'\';
        $this->ticket->refresh();
        session()->flash(\'success\', \'Balasan berhasil dikirim.\');
    }

    public function closeTicket()
    {
        $this->ticket->update([\'status\' => \'closed\']);
        $this->ticket->refresh();
        session()->flash(\'success\', \'Tiket ditutup.\');
    }

    public function render()
    {
        $replies = $this->ticket->replies()->with(\'user\')->oldest()->get();

        return view(\'livewire.author.helpdesk-detail\', compact(\'replies\'))
            ->layout(\'layouts.app\');
    }
}
';

$DELIVERABLE_UPLOAD_CONTENT = '<?php

namespace App\Livewire\Author;

use App\Models\Paper;
use App\Models\Deliverable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class DeliverableUpload extends Component
{
    use WithFileUploads;

    public Paper $paper;
    public $posterFile;
    public $pptFile;
    public $finalPaperFile;

    public function mount(Paper $paper)
    {
        $user = Auth::user();
        $isAdminOrEditor = in_array($user?->role, [\'admin\', \'editor\']);
        $isImpersonating = session()->has(\'impersonating_from\');
        if (! $isAdminOrEditor && ! $isImpersonating && (int) $paper->user_id !== (int) Auth::id()) abort(403);
        $this->paper = $paper;
    }

    public function uploadDeliverable(string $type)
    {
        $fileProperty = match($type) {
            \'poster\' => \'posterFile\',
            \'ppt\' => \'pptFile\',
            \'final_paper\' => \'finalPaperFile\',
        };

        $this->validate([
            $fileProperty => \'required|file|mimes:pdf,ppt,pptx,jpg,jpeg,png|max:20480\',
        ]);

        $file = $this->$fileProperty;
        $path = $file->store(\'deliverables/\' . $this->paper->id . \'/\' . $type, \'public\');

        Deliverable::where(\'paper_id\', $this->paper->id)
            ->where(\'type\', $type)
            ->where(\'direction\', \'author_upload\')
            ->delete();

        Deliverable::create([
            \'paper_id\' => $this->paper->id,
            \'user_id\' => Auth::id(),
            \'type\' => $type,
            \'direction\' => \'author_upload\',
            \'file_path\' => $path,
            \'original_name\' => $file->getClientOriginalName(),
        ]);

        $this->$fileProperty = null;
        $this->paper->refresh();

        $uploadedTypes = Deliverable::where(\'paper_id\', $this->paper->id)
            ->where(\'direction\', \'author_upload\')
            ->pluck(\'type\')
            ->toArray();

        if (count(array_intersect([\'poster\', \'ppt\', \'final_paper\'], $uploadedTypes)) === 3) {
            $this->paper->update([\'status\' => \'completed\']);
        } else {
            $this->paper->update([\'status\' => \'deliverables_pending\']);
        }

        session()->flash(\'success\', Deliverable::TYPE_LABELS[$type] . \' berhasil diunggah!\');
    }

    public function render()
    {
        $authorDeliverables = Deliverable::where(\'paper_id\', $this->paper->id)
            ->where(\'direction\', \'author_upload\')->get()->keyBy(\'type\');
        $adminDeliverables = Deliverable::where(\'paper_id\', $this->paper->id)
            ->where(\'direction\', \'admin_send\')->get();

        return view(\'livewire.author.deliverable-upload\', compact(\'authorDeliverables\', \'adminDeliverables\'))->layout(\'layouts.app\');
    }
}
';

// === PATCH ACTIONS ===
$patchMsg = $routePatchMsg = $reviewerPatchMsg = $authorPatchMsg = '';

// Handle PATCH ALL action
if (($_POST['action'] ?? '') === 'patch_all') {
    $msgs = [];
    
    // 1. Patch Middleware
    $path = $root . '/app/Http/Middleware/RoleMiddleware.php';
    if (file_put_contents($path, $MIDDLEWARE_CONTENT) !== false) {
        $msgs[] = 'OK: RoleMiddleware.php';
    } else {
        $msgs[] = 'ERR: RoleMiddleware.php';
    }
    
    // 2. Patch Routes
    $routesPath = $root . '/routes/web.php';
    if (file_exists($routesPath)) {
        $content = file_get_contents($routesPath);
        $old = "Route::middleware(['role:reviewer'])->prefix('reviewer')";
        $new = "Route::middleware(['role:reviewer,editor'])->prefix('reviewer')";
        if (str_contains($content, $old)) {
            file_put_contents($routesPath, str_replace($old, $new, $content));
            $msgs[] = 'OK: routes/web.php';
        } elseif (str_contains($content, $new)) {
            $msgs[] = 'SKIP: routes/web.php (already patched)';
        } else {
            $msgs[] = 'WARN: routes/web.php pattern not found';
        }
    }
    
    // 3. Patch Reviewer Components
    file_put_contents($root . '/app/Livewire/Reviewer/ReviewForm.php', $REVIEW_FORM_CONTENT);
    file_put_contents($root . '/app/Livewire/Reviewer/ReviewList.php', $REVIEW_LIST_CONTENT);
    $msgs[] = 'OK: ReviewForm.php, ReviewList.php';
    
    // 4. Patch Author Components
    file_put_contents($root . '/app/Livewire/Author/PaperDetail.php', $PAPER_DETAIL_CONTENT);
    file_put_contents($root . '/app/Livewire/Author/PaymentUpload.php', $PAYMENT_UPLOAD_CONTENT);
    file_put_contents($root . '/app/Livewire/Author/HelpdeskDetail.php', $HELPDESK_DETAIL_CONTENT);
    file_put_contents($root . '/app/Livewire/Author/DeliverableUpload.php', $DELIVERABLE_UPLOAD_CONTENT);
    $msgs[] = 'OK: PaperDetail.php, PaymentUpload.php, HelpdeskDetail.php, DeliverableUpload.php';
    
    // 5. Patch Layout (sidebar)
    $layoutPath = $root . '/resources/views/layouts/app.blade.php';
    if (file_exists($layoutPath)) {
        $content = file_get_contents($layoutPath);
        $oldSidebar = '@if(Auth::user()->isReviewer())';
        $newSidebar = '@if(Auth::user()->isReviewer() || Auth::user()->isEditor() || Auth::user()->isAdmin())';
        if (str_contains($content, $oldSidebar)) {
            file_put_contents($layoutPath, str_replace($oldSidebar, $newSidebar, $content));
            $msgs[] = 'OK: layouts/app.blade.php (sidebar)';
        } elseif (str_contains($content, $newSidebar)) {
            $msgs[] = 'SKIP: layouts/app.blade.php (already patched)';
        }
    }
    
    // Clear all caches after patching
    $vs = glob($root . '/storage/framework/views/*.php') ?: [];
    foreach ($vs as $f) @unlink($f);
    foreach (['routes-v7.php','routes.php','config.php'] as $cf) {
        $p = $root . '/bootstrap/cache/' . $cf;
        if (file_exists($p)) @unlink($p);
    }
    $msgs[] = 'OK: Caches cleared';
    
    $patchMsg = 'PATCH ALL: ' . implode(' | ', $msgs);
}

// Patch middleware individually
if (($_POST['action'] ?? '') === 'patch_middleware') {
    $path = $root . '/app/Http/Middleware/RoleMiddleware.php';
    if (file_put_contents($path, $MIDDLEWARE_CONTENT) !== false) {
        $patchMsg = 'OK: RoleMiddleware.php berhasil di-patch!';
        $vs = glob($root . '/storage/framework/views/*.php') ?: [];
        foreach ($vs as $f) unlink($f);
    } else {
        $patchMsg = 'ERR: Gagal menulis RoleMiddleware.php';
    }
}

// Patch routes individually
if (($_POST['action'] ?? '') === 'patch_routes') {
    $routesPath = $root . '/routes/web.php';
    if (file_exists($routesPath)) {
        $content = file_get_contents($routesPath);
        $old = "Route::middleware(['role:reviewer'])->prefix('reviewer')";
        $new = "Route::middleware(['role:reviewer,editor'])->prefix('reviewer')";
        if (str_contains($content, $old)) {
            if (file_put_contents($routesPath, str_replace($old, $new, $content)) !== false) {
                $routePatchMsg = 'OK: routes/web.php di-patch!';
                foreach (['routes-v7.php','routes.php'] as $cf) { $p=$root.'/bootstrap/cache/'.$cf; if(file_exists($p)) unlink($p); }
            } else {
                $routePatchMsg = 'ERR: Gagal menulis routes/web.php';
            }
        } elseif (str_contains($content, $new)) {
            $routePatchMsg = 'INFO: routes/web.php sudah up-to-date';
        } else {
            $routePatchMsg = 'WARN: Pattern tidak ditemukan';
        }
    }
}

// Patch reviewer components individually
if (($_POST['action'] ?? '') === 'patch_reviewer') {
    $ok1 = file_put_contents($root . '/app/Livewire/Reviewer/ReviewForm.php', $REVIEW_FORM_CONTENT);
    $ok2 = file_put_contents($root . '/app/Livewire/Reviewer/ReviewList.php', $REVIEW_LIST_CONTENT);
    if ($ok1 && $ok2) {
        $reviewerPatchMsg = 'OK: ReviewForm.php dan ReviewList.php berhasil di-patch!';
        $vs = glob($root . '/storage/framework/views/*.php') ?: [];
        foreach ($vs as $f) unlink($f);
    } else {
        $reviewerPatchMsg = 'ERR: Ada masalah saat menulis file';
    }
}

// Patch author components individually
if (($_POST['action'] ?? '') === 'patch_author') {
    $ok1 = file_put_contents($root . '/app/Livewire/Author/PaperDetail.php', $PAPER_DETAIL_CONTENT);
    $ok2 = file_put_contents($root . '/app/Livewire/Author/PaymentUpload.php', $PAYMENT_UPLOAD_CONTENT);
    $ok3 = file_put_contents($root . '/app/Livewire/Author/HelpdeskDetail.php', $HELPDESK_DETAIL_CONTENT);
    $ok4 = file_put_contents($root . '/app/Livewire/Author/DeliverableUpload.php', $DELIVERABLE_UPLOAD_CONTENT);
    if ($ok1 && $ok2 && $ok3 && $ok4) {
        $authorPatchMsg = 'OK: Semua Author components berhasil di-patch!';
        $vs = glob($root . '/storage/framework/views/*.php') ?: [];
        foreach ($vs as $f) unlink($f);
    } else {
        $authorPatchMsg = 'ERR: Ada masalah saat menulis file';
    }
}

// Handle role update POST
$roleMsg = '';
if ($laravelReady && !empty($_POST['fix_role_email']) && !empty($_POST['fix_role_value'])) {
    $email   = trim($_POST['fix_role_email']);
    $newRole = trim($_POST['fix_role_value']);
    if (!in_array($newRole, ['admin','editor','reviewer','author','participant'])) {
        $roleMsg = 'ERR: Role tidak valid';
    } else {
        try {
            $updated = DB::table('users')->where('email', $email)->update(['role' => $newRole]);
            $roleMsg = $updated ? "OK: [{$email}] -> role=[{$newRole}]" : "WARN: User [{$email}] tidak ditemukan";
        } catch (Throwable $e) {
            $roleMsg = 'ERR: ' . $e->getMessage();
        }
    }
}

// Check current patch status
$middlewareCurrent = @file_get_contents($root . '/app/Http/Middleware/RoleMiddleware.php');
$middlewarePatched = $middlewareCurrent && str_contains($middlewareCurrent, 'Admin bypasses');
$routesCurrent = @file_get_contents($root . '/routes/web.php');
$routesPatched = $routesCurrent && str_contains($routesCurrent, "role:reviewer,editor");
$reviewFormCurrent = @file_get_contents($root . '/app/Livewire/Reviewer/ReviewForm.php');
$reviewerPatched = $reviewFormCurrent && str_contains($reviewFormCurrent, 'isAdminOrEditor');
$authorDetailCurrent = @file_get_contents($root . '/app/Livewire/Author/PaperDetail.php');
$authorPatched = $authorDetailCurrent && str_contains($authorDetailCurrent, 'isAdminOrEditor');
$layoutCurrent = @file_get_contents($root . '/resources/views/layouts/app.blade.php');
$layoutPatched = $layoutCurrent && str_contains($layoutCurrent, 'isReviewer() || Auth::user()->isEditor()');

$allPatched = $middlewarePatched && $routesPatched && $reviewerPatched && $authorPatched && $layoutPatched;

// Get user list
$userList = [];
if ($laravelReady) {
    try {
        $userList = DB::table('users')->select('id','name','email','role')->orderBy('id')->limit(100)->get()->toArray();
    } catch (Throwable $e) { }
}
?><!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emergency Fix</title>
<style>
body{font-family:monospace;background:#0f172a;color:#e2e8f0;padding:30px;margin:0}
h2{color:#38bdf8;margin:0 0 16px}h3{margin:0 0 12px}
.box{background:#1e293b;border:1px solid #334155;border-radius:8px;padding:20px;margin-bottom:20px}
.ok{color:#4ade80}.warn{color:#facc15}.err{color:#f87171}.info{color:#60a5fa}
.line{margin:4px 0;font-size:13px}
input,select{background:#0f172a;border:1px solid #475569;color:#e2e8f0;padding:6px 10px;border-radius:6px;font-family:monospace;font-size:13px}
input[type=email]{width:250px}
button{color:#fff;border:none;padding:8px 20px;border-radius:6px;cursor:pointer;font-weight:bold;font-size:13px}
.btn-purple{background:#7c3aed}.btn-orange{background:#ea580c}.btn-blue{background:#2563eb}.btn-green{background:#16a34a}
table{width:100%;border-collapse:collapse;font-size:13px;margin-top:14px}
th{text-align:left;padding:5px 10px;color:#94a3b8;border-bottom:1px solid #334155}
td{padding:5px 10px;border-bottom:1px solid #1e293b}
.badge{display:inline-block;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:bold}
.badge-ok{background:#16a34a;color:#fff}
.badge-err{background:#dc2626;color:#fff}
</style></head><body>
<h2>Emergency Fix -- conference.stifar.ac.id</h2>

<div class="box">
<h3 style="color:#38bdf8">Cache &amp; Bootstrap</h3>
<?php foreach ($results as $r):
  $cls = str_contains($r,'FAILED')||str_contains($r,'ERR') ? 'err' : (str_contains($r,'WARN') ? 'warn' : 'ok');
?><div class="line <?=$cls?>"><?=htmlspecialchars($r)?></div>
<?php endforeach; ?>
</div>

<!-- PATCH ALL BUTTON -->
<div class="box" style="border-color:<?=$allPatched?'#16a34a':'#f59e0b'?>">
<h3 style="color:#f59e0b">PATCH SEMUA SEKALIGUS</h3>
<p class="line" style="margin-bottom:12px">Klik tombol di bawah untuk memperbaiki semua file sekaligus:</p>
<?php if($patchMsg): $mc=str_contains($patchMsg,'OK')?'ok':(str_contains($patchMsg,'WARN')?'warn':'err'); ?>
<div class="line <?=$mc?>" style="font-size:14px;font-weight:bold;margin-bottom:12px"><?=htmlspecialchars($patchMsg)?></div>
<?php endif; ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_all">
  <button type="submit" class="btn-green" style="font-size:16px;padding:12px 30px">PATCH ALL - Fix Semua Sekarang!</button>
</form>
</div>

<!-- Status Overview -->
<div class="box">
<h3 style="color:#60a5fa">Status Patch</h3>
<table>
<tr><td>RoleMiddleware.php</td><td><?=$middlewarePatched?'<span class="badge badge-ok">PATCHED</span>':'<span class="badge badge-err">BELUM</span>'?></td></tr>
<tr><td>routes/web.php</td><td><?=$routesPatched?'<span class="badge badge-ok">PATCHED</span>':'<span class="badge badge-err">BELUM</span>'?></td></tr>
<tr><td>Reviewer (ReviewForm, ReviewList)</td><td><?=$reviewerPatched?'<span class="badge badge-ok">PATCHED</span>':'<span class="badge badge-err">BELUM</span>'?></td></tr>
<tr><td>Author (PaperDetail, PaymentUpload, dll)</td><td><?=$authorPatched?'<span class="badge badge-ok">PATCHED</span>':'<span class="badge badge-err">BELUM</span>'?></td></tr>
<tr><td>Layout Sidebar</td><td><?=$layoutPatched?'<span class="badge badge-ok">PATCHED</span>':'<span class="badge badge-err">BELUM</span>'?></td></tr>
</table>
</div>

<!-- Individual patches -->
<details style="margin-bottom:20px">
<summary style="cursor:pointer;color:#94a3b8;font-size:14px;padding:10px;background:#1e293b;border-radius:8px">
Patch Individual (Klik untuk expand)
</summary>

<div class="box" style="border-color:<?=$middlewarePatched?'#16a34a':'#ea580c'?>;margin-top:10px">
<h3 style="color:#fb923c">[1] RoleMiddleware -- Admin bypass 403</h3>
<?php if(!$middlewarePatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_middleware">
  <button type="submit" class="btn-orange">Patch RoleMiddleware</button>
</form>
<?php else: ?>
<span class="ok">Sudah di-patch</span>
<?php endif; ?>
</div>

<div class="box" style="border-color:<?=$routesPatched?'#16a34a':'#ea580c'?>;margin-top:10px">
<h3 style="color:#fb923c">[2] Routes -- Editor akses reviewer</h3>
<?php if($routePatchMsg): ?><div class="line <?=str_starts_with($routePatchMsg,'OK')?'ok':'warn'?>"><?=htmlspecialchars($routePatchMsg)?></div><?php endif; ?>
<?php if(!$routesPatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_routes">
  <button type="submit" class="btn-blue">Patch Routes</button>
</form>
<?php else: ?>
<span class="ok">Sudah di-patch</span>
<?php endif; ?>
</div>

<div class="box" style="border-color:<?=$reviewerPatched?'#16a34a':'#ea580c'?>;margin-top:10px">
<h3 style="color:#fb923c">[3] Reviewer Components</h3>
<?php if($reviewerPatchMsg): ?><div class="line <?=str_starts_with($reviewerPatchMsg,'OK')?'ok':'err'?>"><?=htmlspecialchars($reviewerPatchMsg)?></div><?php endif; ?>
<?php if(!$reviewerPatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_reviewer">
  <button type="submit" class="btn-orange">Patch Reviewer</button>
</form>
<?php else: ?>
<span class="ok">Sudah di-patch</span>
<?php endif; ?>
</div>

<div class="box" style="border-color:<?=$authorPatched?'#16a34a':'#ea580c'?>;margin-top:10px">
<h3 style="color:#fb923c">[4] Author Components</h3>
<?php if($authorPatchMsg): ?><div class="line <?=str_starts_with($authorPatchMsg,'OK')?'ok':'err'?>"><?=htmlspecialchars($authorPatchMsg)?></div><?php endif; ?>
<?php if(!$authorPatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_author">
  <button type="submit" class="btn-blue">Patch Author</button>
</form>
<?php else: ?>
<span class="ok">Sudah di-patch</span>
<?php endif; ?>
</div>
</details>

<div class="box">
<h3 style="color:#f472b6">[5] Fix User Role</h3>
<?php if($roleMsg): $mc=str_starts_with($roleMsg,'OK')?'ok':(str_starts_with($roleMsg,'WARN')?'warn':'err'); ?>
<div class="line <?=$mc?>" style="font-size:15px;font-weight:bold;margin-bottom:14px"><?=htmlspecialchars($roleMsg)?></div>
<?php endif; ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
  <input type="email" name="fix_role_email" placeholder="Email user" required>
  <select name="fix_role_value">
    <option value="admin">admin</option>
    <option value="editor">editor</option>
    <option value="reviewer">reviewer</option>
    <option value="author">author</option>
    <option value="participant">participant</option>
  </select>
  <button type="submit" class="btn-purple">Update Role</button>
</form>
<?php if($userList): ?>
<table><thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th></tr></thead><tbody>
<?php foreach($userList as $u):
  $rc=match($u->role??''){'admin'=>'#f472b6','editor'=>'#60a5fa','reviewer'=>'#34d399','author'=>'#fbbf24',default=>'#94a3b8'};
?><tr>
  <td style="color:#64748b"><?=$u->id?></td>
  <td><?=htmlspecialchars($u->name)?></td>
  <td style="color:#93c5fd"><?=htmlspecialchars($u->email)?></td>
  <td><span style="color:<?=$rc?>;font-weight:bold"><?=htmlspecialchars($u->role??'-')?></span></td>
</tr><?php endforeach; ?>
</tbody></table>
<?php endif; ?>
</div>

<div class="box" style="border-color:#dc2626">
  <p style="color:#fca5a5;margin:0"><strong>HAPUS FILE INI</strong> setelah selesai! Path: <code>public/fix-emergency.php</code></p>
  <p style="color:#475569;font-size:12px;margin:8px 0 0">PHP <?=PHP_VERSION?> | <?=date('Y-m-d H:i:s')?></p>
</div>
</body></html>
