<?php
// EMERGENCY PATCH — upload ke public/ server, akses: /fix-emergency.php?token=stifar-fix-2026 — HAPUS SETELAH SELESAI
if(($_GET['token']??'')!=='stifar-fix-2026'){die('403 - tambah ?token=stifar-fix-2026');}
$root=dirname(__DIR__);$log=[];

// 1. PATCH routes/web.php
$webFile=$root.'/routes/web.php';
if(file_exists($webFile)){
    $src=file_get_contents($webFile);
    // Fix broken string route (if block or direct string)
    $new=preg_replace(
        "/if\s*\(\s*class_exists\s*\([^)]+CertificateManager[^)]*\)\s*\)\s*\{[^}]*\}/s",
        "Route::get('/certificates', \\App\\Livewire\\Admin\\CertificateManager::class)->name('admin.certificates');",
        $src
    );
    // Also fix any leftover string form
    $new=str_replace(
        ["'App\\Livewire\\Admin\\CertificateManager'","\"App\\Livewire\\Admin\\CertificateManager\""],
        ['\\App\\Livewire\\Admin\\CertificateManager::class','\\App\\Livewire\\Admin\\CertificateManager::class'],
        $new??$src
    );
    if($new!==$src){file_put_contents($webFile,$new);$log[]="✅ routes/web.php DIPATCH";}
    elseif(strpos($src,'CertificateManager::class')!==false){$log[]="✅ routes/web.php sudah OK";}
    else{$log[]="⚠️ routes/web.php belum bisa dipatch otomatis — perlu upload manual";}
}else{$log[]="❌ routes/web.php tidak ditemukan di: $webFile";}

// 2. Clear bootstrap/cache
$n=0;foreach(glob($root.'/bootstrap/cache/*.php')as $f){
    if(in_array(basename($f),['routes-v7.php','routes.php','config.php','events.php','services.php','packages.php'])){unlink($f);$n++;}
}$log[]="✅ Hapus $n bootstrap cache";

// 3. Clear compiled views
$v=glob($root.'/storage/framework/views/*.php')??[];foreach($v as $f)unlink($f);$log[]="✅ Hapus ".count($v)." compiled views";

// 4. Clear cache data
$n=0;if(is_dir($d=$root.'/storage/framework/cache/data')){
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($d,FilesystemIterator::SKIP_DOTS))as $f)if($f->isFile()){unlink($f->getPathname());$n++;}
}$log[]="✅ Hapus $n cache files";

// Final check
$ok=!strpos(file_get_contents($webFile),"'App\\Livewire\\Admin\\CertificateManager'");
$log[]=$ok?"✅ FINAL: routes/web.php bersih — situs seharusnya sudah normal":"❌ FINAL: Masih ada broken route, perlu upload routes/web.php manual";
?><!DOCTYPE html><html><head><meta charset="UTF-8"><title>Fix</title>
<style>body{font-family:monospace;background:#0f172a;color:#e2e8f0;padding:2rem}h2{color:#38bdf8}.box{background:#1e293b;border:1px solid #334155;border-radius:8px;padding:1.5rem;margin:1rem 0}ul{list-style:none;padding:0}li{padding:3px 0}.ok{color:#4ade80}.warn{color:#fbbf24}.err{color:#f87171}a{color:#60a5fa}</style>
</head><body>
<h2>🛠️ Emergency Patch — conference.stifar.ac.id</h2>
<div class="box"><ul>
<?php foreach($log as $l):$c=str_starts_with($l,'✅')?'ok':(str_starts_with($l,'⚠️')?'warn':'err');?>
<li class="<?=$c?>"><?=htmlspecialchars($l)?></li>
<?php endforeach?></ul></div>
<div class="box">
<?php if($ok):?><p class="ok" style="font-size:1.1rem;font-weight:bold">✅ Selesai! Coba buka: <a href="https://conference.stifar.ac.id" target="_blank">conference.stifar.ac.id</a></p>
<?php else:?><p class="warn" style="font-weight:bold">⚠️ Perlu upload <code>routes/web.php</code> manual via cPanel File Manager</p>
<p style="color:#94a3b8;font-size:13px">Buka cPanel → File Manager → <code>public_html/routes/web.php</code> → Edit → cari "CertificateManager" → hapus baris <code>if(class_exists...)</code> dan isinya, ganti dengan:<br><code style="background:#0f172a;padding:4px 8px;border-radius:4px;display:inline-block;margin-top:6px">Route::get('/certificates', \App\Livewire\Admin\CertificateManager::class)->name('admin.certificates');</code></p>
<?php endif?>
<p style="color:#64748b;font-size:12px;margin-top:1rem">⚠️ HAPUS file ini setelah selesai! | PHP <?=PHP_VERSION?> | <?=date('Y-m-d H:i:s')?></p>
</div>
</body></html>

if (($_GET['token'] ?? '') !== ACCESS_TOKEN) {
    http_response_code(403);
    die('<h2 style="color:red">403 Forbidden</h2><p>Akses: <code>?token=stifar-fix-2026</code></p>');
}

$root    = dirname(__DIR__);
$results = [];

// ─── 1. Hapus route cache ─────────────────────────────────────────────────
$routeCache = $root . '/bootstrap/cache/routes-v7.php';
$routeCache2 = $root . '/bootstrap/cache/routes.php';
foreach ([$routeCache, $routeCache2] as $f) {
    if (file_exists($f)) {
        unlink($f);
        $results[] = "✅ Hapus route cache: " . basename($f);
    }
}

// ─── 2. Hapus config cache ────────────────────────────────────────────────
$configCache = $root . '/bootstrap/cache/config.php';
if (file_exists($configCache)) {
    unlink($configCache);
    $results[] = "✅ Hapus config cache";
}

// ─── 3. Hapus semua compiled views ───────────────────────────────────────
$viewsDir = $root . '/storage/framework/views';
if (is_dir($viewsDir)) {
    $files = glob($viewsDir . '/*.php');
    $count = 0;
    foreach ($files as $f) {
        unlink($f);
        $count++;
    }
    $results[] = "✅ Hapus {$count} compiled views";
}

// ─── 4. Hapus framework cache ─────────────────────────────────────────────
$cacheDir = $root . '/storage/framework/cache/data';
if (is_dir($cacheDir)) {
    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cacheDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    $count = 0;
    foreach ($iter as $f) {
        if ($f->isFile()) { unlink($f->getPathname()); $count++; }
    }
    $results[] = "✅ Hapus {$count} cache files";
}

// ─── 5. Hapus events & services cache ────────────────────────────────────
foreach (['events.php', 'services.php', 'packages.php'] as $cf) {
    $path = $root . '/bootstrap/cache/' . $cf;
    if (file_exists($path)) {
        unlink($path);
        $results[] = "✅ Hapus {$cf}";
    }
}

// ─── 6. Cek apakah web.php sudah fixed ───────────────────────────────────
$webPhpPath = $root . '/routes/web.php';
$webContent = file_exists($webPhpPath) ? file_get_contents($webPhpPath) : '';
if (str_contains($webContent, "'App\\\\Livewire\\\\Admin\\\\CertificateManager'") ||
    str_contains($webContent, "'App\Livewire\Admin\CertificateManager'")) {
    $results[] = "⚠️  PERLU FIX: routes/web.php masih pakai string untuk CertificateManager!";
    $results[] = "   → Upload routes/web.php versi baru dari komputer lokal.";
} else {
    $results[] = "✅ routes/web.php OK (tidak ada broken string route)";
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Fix — conference.stifar.ac.id</title>
    <style>
        body { font-family: monospace; background: #0f172a; color: #e2e8f0; padding: 30px; }
        h2 { color: #38bdf8; }
        .result { margin: 6px 0; font-size: 14px; }
        .ok   { color: #4ade80; }
        .warn { color: #facc15; }
        .box  { background: #1e293b; border: 1px solid #334155; border-radius: 8px; padding: 20px; margin-top: 20px; }
        a { color: #60a5fa; }
    </style>
</head>
<body>
<h2>🛠️ Emergency Fix — conference.stifar.ac.id</h2>
<div class="box">
    <?php foreach ($results as $r): ?>
    <div class="result <?= str_starts_with($r, '✅') ? 'ok' : 'warn' ?>">
        <?= htmlspecialchars($r) ?>
    </div>
    <?php endforeach; ?>
</div>

<div class="box" style="margin-top:20px">
    <p style="color:#94a3b8; margin:0">Langkah selanjutnya:</p>
    <ol style="color:#cbd5e1; font-size:13px; line-height:2">
        <li>Jika ada peringatan ⚠️ di atas → upload <code>routes/web.php</code> versi baru dulu, lalu akses URL ini lagi.</li>
        <li>Setelah semua ✅ → coba buka <a href="/">halaman utama</a> dan <a href="/login">login</a>.</li>
        <li><strong>HAPUS file ini</strong> (<code>public/fix-emergency.php</code>) dari server setelah selesai!</li>
    </ol>
</div>

<p style="color:#475569; font-size:12px; margin-top:30px">
    Dijalankan: <?= date('Y-m-d H:i:s') ?> |
    PHP: <?= PHP_VERSION ?> |
    Laravel root: <?= htmlspecialchars($root) ?>
</p>
</body>
</html>
