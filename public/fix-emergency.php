<?php
// EMERGENCY FIX - conference.stifar.ac.id
// Akses: /fix-emergency.php?token=stifar-fix-2026
// HAPUS FILE INI SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'stifar-fix-2026') {
    http_response_code(403);
    die('<h2 style="color:red;font-family:monospace">403</h2><p style="font-family:monospace">Tambahkan: <code>?token=stifar-fix-2026</code></p>');
}

$root    = dirname(__DIR__);
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

// 3. Patch RoleMiddleware (action=patch_middleware)
$patchMsg = '';
if (($_POST['action'] ?? '') === 'patch_middleware') {
    $middlewarePath = $root . '/app/Http/Middleware/RoleMiddleware.php';
    $newContent = '<?php

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
    if (file_put_contents($middlewarePath, $newContent) !== false) {
        $patchMsg = 'OK: RoleMiddleware.php berhasil di-patch! Admin bypass aktif.';
        $vs = glob($root . '/storage/framework/views/*.php') ?: [];
        foreach ($vs as $f) unlink($f);
        foreach (['routes-v7.php','routes.php'] as $cf) { $p=$root.'/bootstrap/cache/'.$cf; if(file_exists($p)) unlink($p); }
    } else {
        $patchMsg = 'ERR: Gagal menulis file. Cek permission folder app/Http/Middleware/';
    }
}

// 4. Patch routes/web.php reviewer route (action=patch_routes)
$routePatchMsg = '';
if (($_POST['action'] ?? '') === 'patch_routes') {
    $routesPath = $root . '/routes/web.php';
    if (file_exists($routesPath)) {
        $content = file_get_contents($routesPath);
        $old = "Route::middleware(['role:reviewer'])->prefix('reviewer')";
        $new = "Route::middleware(['role:reviewer,editor'])->prefix('reviewer')";
        if (str_contains($content, $old)) {
            if (file_put_contents($routesPath, str_replace($old, $new, $content)) !== false) {
                $routePatchMsg = 'OK: routes/web.php di-patch! Reviewer,editor.';
                $vs = glob($root . '/storage/framework/views/*.php') ?: [];
                foreach ($vs as $f) unlink($f);
                foreach (['routes-v7.php','routes.php'] as $cf) { $p=$root.'/bootstrap/cache/'.$cf; if(file_exists($p)) unlink($p); }
            } else {
                $routePatchMsg = 'ERR: Gagal menulis routes/web.php. Cek permission.';
            }
        } elseif (str_contains($content, $new)) {
            $routePatchMsg = 'INFO: routes/web.php sudah up-to-date.';
        } else {
            $routePatchMsg = 'WARN: Pattern route reviewer tidak ditemukan.';
        }
    } else {
        $routePatchMsg = 'ERR: routes/web.php tidak ditemukan.';
    }
}

// 5. Patch Livewire Reviewer components (action=patch_reviewer)
$reviewerPatchMsg = '';
if (($_POST['action'] ?? '') === 'patch_reviewer') {
    $success = true;
    $msgs = [];
    
    // Patch ReviewForm.php
    $reviewFormPath = $root . '/app/Livewire/Reviewer/ReviewForm.php';
    $reviewFormNew = '<?php

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
    if (file_put_contents($reviewFormPath, $reviewFormNew) === false) {
        $success = false;
        $msgs[] = 'ERR: Gagal menulis ReviewForm.php';
    } else {
        $msgs[] = 'OK: ReviewForm.php';
    }
    
    // Patch ReviewList.php
    $reviewListPath = $root . '/app/Livewire/Reviewer/ReviewList.php';
    $reviewListNew = '<?php

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
    if (file_put_contents($reviewListPath, $reviewListNew) === false) {
        $success = false;
        $msgs[] = 'ERR: Gagal menulis ReviewList.php';
    } else {
        $msgs[] = 'OK: ReviewList.php';
    }
    
    // Clear caches
    $vs = glob($root . '/storage/framework/views/*.php') ?: [];
    foreach ($vs as $f) unlink($f);
    
    $reviewerPatchMsg = $success ? 'OK: Livewire components berhasil di-patch! ' . implode(', ', $msgs) : 'ERR: ' . implode(', ', $msgs);
}

// 6. Handle role update POST
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

// 6. Load user list & current file status
$userList = [];
if ($laravelReady) {
    try {
        $userList = DB::table('users')->select('id','name','email','role')->orderBy('id')->limit(100)->get()->toArray();
    } catch (Throwable $e) { }
}
$middlewareCurrent = @file_get_contents($root . '/app/Http/Middleware/RoleMiddleware.php');
$middlewarePatched  = $middlewareCurrent && str_contains($middlewareCurrent, 'Admin bypasses');
$routesCurrent     = @file_get_contents($root . '/routes/web.php');
$routesPatched     = $routesCurrent && str_contains($routesCurrent, "role:reviewer,editor");
$reviewFormCurrent = @file_get_contents($root . '/app/Livewire/Reviewer/ReviewForm.php');
$reviewerPatched   = $reviewFormCurrent && str_contains($reviewFormCurrent, 'isAdminOrEditor');
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
.btn-purple{background:#7c3aed}.btn-orange{background:#ea580c}.btn-blue{background:#2563eb}
table{width:100%;border-collapse:collapse;font-size:13px;margin-top:14px}
th{text-align:left;padding:5px 10px;color:#94a3b8;border-bottom:1px solid #334155}
td{padding:5px 10px;border-bottom:1px solid #1e293b}
.badge{display:inline-block;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:bold}
</style></head><body>
<h2>Emergency Fix -- conference.stifar.ac.id</h2>

<div class="box">
<h3 style="color:#38bdf8">Cache &amp; Bootstrap</h3>
<?php foreach ($results as $r):
  $cls = str_contains($r,'FAILED')||str_contains($r,'ERR') ? 'err' : (str_contains($r,'WARN') ? 'warn' : 'ok');
?><div class="line <?=$cls?>"><?=htmlspecialchars($r)?></div>
<?php endforeach; ?>
</div>

<div class="box" style="border-color:<?=$middlewarePatched?'#16a34a':'#ea580c'?>">
<h3 style="color:#fb923c">[1] Patch RoleMiddleware -- Fix 403 Admin di semua halaman</h3>
<p class="line" style="margin-bottom:12px">Status:
  <?php if($middlewarePatched): ?>
    <span class="badge" style="background:#16a34a;color:#fff">SUDAH DI-PATCH</span>
  <?php else: ?>
    <span class="badge" style="background:#dc2626;color:#fff">BELUM DI-PATCH -- admin masih kena 403</span>
  <?php endif; ?>
</p>
<?php if($patchMsg): $mc=str_starts_with($patchMsg,'OK')?'ok':(str_starts_with($patchMsg,'INFO')?'info':(str_starts_with($patchMsg,'WARN')?'warn':'err')); ?>
<div class="line <?=$mc?>" style="font-size:14px;font-weight:bold;margin-bottom:12px"><?=htmlspecialchars($patchMsg)?></div>
<?php endif; ?>
<?php if(!$middlewarePatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_middleware">
  <button type="submit" class="btn-orange">Patch RoleMiddleware Sekarang</button>
</form>
<?php endif; ?>
</div>

<div class="box" style="border-color:<?=$routesPatched?'#16a34a':'#ea580c'?>">
<h3 style="color:#fb923c">[2] Patch Routes -- Editor bisa akses halaman Reviewer</h3>
<p class="line" style="margin-bottom:12px">Status:
  <?php if($routesPatched): ?>
    <span class="badge" style="background:#16a34a;color:#fff">SUDAH DI-PATCH</span>
  <?php else: ?>
    <span class="badge" style="background:#dc2626;color:#fff">BELUM DI-PATCH</span>
  <?php endif; ?>
</p>
<?php if($routePatchMsg): $mc=str_starts_with($routePatchMsg,'OK')?'ok':(str_starts_with($routePatchMsg,'INFO')?'info':(str_starts_with($routePatchMsg,'WARN')?'warn':'err')); ?>
<div class="line <?=$mc?>" style="font-size:14px;font-weight:bold;margin-bottom:12px"><?=htmlspecialchars($routePatchMsg)?></div>
<?php endif; ?>
<?php if(!$routesPatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_routes">
  <button type="submit" class="btn-blue">Patch Routes Sekarang</button>
</form>
<?php endif; ?>
</div>

<div class="box" style="border-color:<?=$reviewerPatched?'#16a34a':'#ea580c'?>">
<h3 style="color:#fb923c">[3] Patch Reviewer Components -- Fix 403 di halaman review detail</h3>
<p class="line" style="margin-bottom:12px">Status:
  <?php if($reviewerPatched): ?>
    <span class="badge" style="background:#16a34a;color:#fff">SUDAH DI-PATCH</span>
  <?php else: ?>
    <span class="badge" style="background:#dc2626;color:#fff">BELUM DI-PATCH -- admin/editor masih kena 403 di form review</span>
  <?php endif; ?>
</p>
<?php if($reviewerPatchMsg): $mc=str_starts_with($reviewerPatchMsg,'OK')?'ok':(str_starts_with($reviewerPatchMsg,'INFO')?'info':(str_starts_with($reviewerPatchMsg,'WARN')?'warn':'err')); ?>
<div class="line <?=$mc?>" style="font-size:14px;font-weight:bold;margin-bottom:12px"><?=htmlspecialchars($reviewerPatchMsg)?></div>
<?php endif; ?>
<?php if(!$reviewerPatched): ?>
<form method="POST" action="?token=<?=urlencode($_GET['token']??'')?>">
  <input type="hidden" name="action" value="patch_reviewer">
  <button type="submit" class="btn-orange">Patch Reviewer Components Sekarang</button>
</form>
<?php endif; ?>
</div>

<div class="box">
<h3 style="color:#f472b6">[4] Fix User Role</h3>
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