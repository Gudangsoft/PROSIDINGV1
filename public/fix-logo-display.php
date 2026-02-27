<?php
// Fix Logo Display - Update all references
// Akses: /fix-logo-display.php?token=logo123
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'logo123') {
    die('Token: ?token=logo123');
}

$root = dirname(__DIR__);

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#38bdf8'>FIX LOGO DISPLAY</h2>\n\n";

// Bootstrap Laravel
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
} catch (Throwable $e) {
    die("Cannot bootstrap Laravel: " . $e->getMessage());
}

// 1. Check current logo setting
echo "1. Current settings:\n";
$logo = \App\Models\Setting::getValue('site_logo');
$favicon = \App\Models\Setting::getValue('site_favicon');
echo "   site_logo: " . ($logo ?: '<null>') . "\n";
echo "   site_favicon: " . ($favicon ?: '<null>') . "\n\n";

// 2. Create uploads directory
echo "2. Creating uploads directory...\n";
$uploadDir = $root . '/public/uploads/settings';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    echo "   <span style='color:#4ade80'>✓ Created: public/uploads/settings/</span>\n";
} else {
    echo "   Already exists\n";
}

// 3. Check if files exist
echo "\n3. Checking file locations:\n";

if ($logo) {
    // Check old location (storage/app/public/...)
    $oldLogoPath = $root . '/storage/app/public/' . $logo;
    // Check public/storage/... 
    $publicStoragePath = $root . '/public/storage/' . $logo;
    // Check if it's already new format
    $newLogoPath = $root . '/public/' . $logo;
    
    echo "   Logo file checks:\n";
    echo "   - storage/app/public/$logo: " . (file_exists($oldLogoPath) ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
    echo "   - public/storage/$logo: " . (file_exists($publicStoragePath) ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
    echo "   - public/$logo: " . (file_exists($newLogoPath) ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
}

if ($favicon) {
    $oldFaviconPath = $root . '/storage/app/public/' . $favicon;
    $publicStorageFavicon = $root . '/public/storage/' . $favicon;
    $newFaviconPath = $root . '/public/' . $favicon;
    
    echo "   Favicon file checks:\n";
    echo "   - storage/app/public/$favicon: " . (file_exists($oldFaviconPath) ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
    echo "   - public/storage/$favicon: " . (file_exists($publicStorageFavicon) ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
    echo "   - public/$favicon: " . (file_exists($newFaviconPath) ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
}

$action = $_GET['action'] ?? '';

// ACTION: Copy from storage to public/uploads
if ($action === 'migrate') {
    echo "\n4. Migrating files to public/uploads/settings/...\n";
    
    if ($logo) {
        $sources = [
            $root . '/storage/app/public/' . $logo,
            $root . '/public/storage/' . $logo,
        ];
        
        foreach ($sources as $src) {
            if (file_exists($src)) {
                $ext = pathinfo($logo, PATHINFO_EXTENSION);
                $newName = 'logo_' . time() . '.' . $ext;
                $dest = $uploadDir . '/' . $newName;
                
                if (copy($src, $dest)) {
                    $newPath = 'uploads/settings/' . $newName;
                    \App\Models\Setting::setValue('site_logo', $newPath);
                    echo "   <span style='color:#4ade80'>✓ Logo migrated to: $newPath</span>\n";
                    break;
                }
            }
        }
    }
    
    if ($favicon) {
        $sources = [
            $root . '/storage/app/public/' . $favicon,
            $root . '/public/storage/' . $favicon,
        ];
        
        foreach ($sources as $src) {
            if (file_exists($src)) {
                $ext = pathinfo($favicon, PATHINFO_EXTENSION);
                $newName = 'favicon_' . time() . '.' . $ext;
                $dest = $uploadDir . '/' . $newName;
                
                if (copy($src, $dest)) {
                    $newPath = 'uploads/settings/' . $newName;
                    \App\Models\Setting::setValue('site_favicon', $newPath);
                    echo "   <span style='color:#4ade80'>✓ Favicon migrated to: $newPath</span>\n";
                    break;
                }
            }
        }
    }
}

// ACTION: Clear logo settings completely
if ($action === 'clear') {
    echo "\n4. Clearing logo and favicon settings...\n";
    \App\Models\Setting::setValue('site_logo', null);
    \App\Models\Setting::setValue('site_favicon', null);
    echo "   <span style='color:#4ade80'>✓ Cleared! Now upload fresh logo/favicon from admin panel.</span>\n";
}

// ACTION: Test upload manually
if ($action === 'test_upload') {
    echo "\n4. Testing direct upload...\n";
    
    // Create a simple test image
    $testFile = $uploadDir . '/test_logo.png';
    
    // Create 1x1 transparent PNG
    $img = imagecreatetruecolor(200, 60);
    $bg = imagecolorallocate($img, 255, 255, 255);
    imagefill($img, 0, 0, $bg);
    $textColor = imagecolorallocate($img, 0, 100, 200);
    imagestring($img, 5, 50, 20, 'SINACON', $textColor);
    
    if (imagepng($img, $testFile)) {
        echo "   <span style='color:#4ade80'>✓ Test image created: $testFile</span>\n";
        \App\Models\Setting::setValue('site_logo', 'uploads/settings/test_logo.png');
        echo "   <span style='color:#4ade80'>✓ Database updated</span>\n";
    } else {
        echo "   <span style='color:#f87171'>✗ Failed to create test image</span>\n";
    }
    imagedestroy($img);
}

// 5. Clear cache
echo "\n5. Clearing cache...\n";
try {
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "   <span style='color:#4ade80'>✓ Cache cleared</span>\n";
} catch (Throwable $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

// Check final result
echo "\n<h3>Current Logo URL:</h3>";
$currentLogo = \App\Models\Setting::getValue('site_logo');
if ($currentLogo) {
    if (str_starts_with($currentLogo, 'uploads/')) {
        $url = '/' . $currentLogo;
    } else {
        $url = '/storage/' . $currentLogo;
    }
    echo "Path: $currentLogo\n";
    echo "URL: <a href='$url' style='color:#38bdf8'>$url</a>\n";
    echo "\nPreview: <img src='$url' style='max-height:60px;border:1px solid #666'>\n";
} else {
    echo "<span style='color:#fbbf24'>No logo set</span>\n";
}

echo "\n<h3>Actions:</h3>";
echo "<a href='?token=logo123&action=migrate' style='display:block;padding:10px;background:#047857;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Migrate existing logo files</a>\n";
echo "<a href='?token=logo123&action=clear' style='display:block;padding:10px;background:#dc2626;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Clear logo settings (upload fresh)</a>\n";
echo "<a href='?token=logo123&action=test_upload' style='display:block;padding:10px;background:#7c3aed;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Create test logo</a>\n";
echo "<a href='?token=logo123' style='display:block;padding:10px;background:#64748b;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Refresh status</a>\n";

echo "\n<span style='color:#f87171;font-weight:bold'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";
