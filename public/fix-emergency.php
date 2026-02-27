<?php
// EMERGENCY FIX — conference.stifar.ac.id
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

// 3. Handle role update POST
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

// 4. Load user list
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
h2{color:#38bdf8;margin:0 0 16px}h3{color:#f472b6;margin:0 0 12px}
.box{background:#1e293b;border:1px solid #334155;border-radius:8px;padding:20px;margin-bottom:20px}
.ok{color:#4ade80}.warn{color:#facc15}.err{color:#f87171}
.line{margin:4px 0;font-size:13px}
a{color:#60a5fa}
input,select{background:#0f172a;border:1px solid #475569;color:#e2e8f0;padding:6px 10px;border-radius:6px;font-family:monospace;font-size:13px}
input[type=email]{width:250px}
button{background:#7c3aed;color:#fff;border:none;padding:7px 18px;border-radius:6px;cursor:pointer;font-weight:bold}
table{width:100%;border-collapse:collapse;font-size:13px;margin-top:14px}
th{text-align:left;padding:5px 10px;color:#94a3b8;border-bottom:1px solid #334155}
td{padding:5px 10px;border-bottom:1px solid #1e293b}
</style></head><body>
<h2>??? Emergency Fix — conference.stifar.ac.id</h2>

<div class="box">
<h3 style="color:#38bdf8">?? Cache & Bootstrap</h3>
<?php foreach ($results as $r):
  $cls = str_contains($r,'FAILED')||str_contains($r,'ERR') ? 'err' : (str_contains($r,'WARN') ? 'warn' : 'ok');
?>
<div class="line <?= $cls ?>">
  <?= $cls==='ok'?'?':($cls==='warn'?'??':'?') ?> <?= htmlspecialchars($r) ?>
</div>
<?php endforeach; ?>
</div>

<div class="box">
<h3>?? Fix User Role</h3>
<?php if ($roleMsg):
  $mc = str_starts_with($roleMsg,'OK') ? 'ok' : (str_starts_with($roleMsg,'WARN') ? 'warn' : 'err');
?>
<div class="line <?= $mc ?>" style="font-size:15px;font-weight:bold;margin-bottom:14px">
  <?= $mc==='ok'?'?':($mc==='warn'?'??':'?') ?> <?= htmlspecialchars($roleMsg) ?>
</div>
<?php endif; ?>

<form method="POST" action="?token=<?= urlencode($_GET['token']??'') ?>" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
  <input type="email" name="fix_role_email" placeholder="Email user" required>
  <select name="fix_role_value">
    <option value="admin">admin</option>
    <option value="editor">editor</option>
    <option value="reviewer">reviewer</option>
    <option value="author">author</option>
    <option value="participant">participant</option>
  </select>
  <button type="submit">Update Role</button>
</form>

<?php if ($userList): ?>
<table><thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th></tr></thead><tbody>
<?php foreach ($userList as $u):
  $rc = match($u->role??'') { 'admin'=>'#f472b6','editor'=>'#60a5fa','reviewer'=>'#34d399','author'=>'#fbbf24',default=>'#94a3b8' };
?>
<tr>
  <td style="color:#64748b"><?= $u->id ?></td>
  <td><?= htmlspecialchars($u->name) ?></td>
  <td style="color:#93c5fd"><?= htmlspecialchars($u->email) ?></td>
  <td><span style="color:<?= $rc ?>;font-weight:bold"><?= htmlspecialchars($u->role??'-') ?></span></td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?php endif; ?>
</div>

<div class="box" style="border-color:#dc2626">
  <p style="color:#fca5a5;margin:0">?? <strong>HAPUS FILE INI</strong> setelah selesai! Path: <code>public/fix-emergency.php</code></p>
  <p style="color:#475569;font-size:12px;margin:8px 0 0">PHP <?= PHP_VERSION ?> | <?= date('Y-m-d H:i:s') ?></p>
</div>
</body></html>
