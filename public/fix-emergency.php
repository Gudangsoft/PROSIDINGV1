<?php
/**
 * EMERGENCY FIX SCRIPT
 * Upload ke public/ lalu akses: https://conference.stifar.ac.id/fix-emergency.php?token=stifar-fix-2026
 * HAPUS file ini setelah selesai!
 */

define('ACCESS_TOKEN', 'stifar-fix-2026');

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
