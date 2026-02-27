<?php
// SUPER FIX - Copy ke semua lokasi yang mungkin
// Akses: /superfix-logo.php?token=super123
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'super123') {
    die('Token: ?token=super123');
}

$root = dirname(__DIR__);

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#38bdf8'>SUPER FIX LOGO</h2>\n\n";

// Bootstrap Laravel
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
} catch (Throwable $e) {
    die("Error: " . $e->getMessage());
}

$action = $_GET['action'] ?? '';

// ACTION: Upload logo langsung
if ($action === 'upload' && isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
    echo "Uploading logo...\n";
    
    $file = $_FILES['logo'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'logo_' . time() . '.' . $ext;
    
    // Create directories
    $dirs = [
        $root . '/public/uploads/settings',
        $root . '/public/storage/settings',
        $root . '/storage/app/public/settings',
    ];
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            echo "Created: " . str_replace($root, '', $dir) . "\n";
        }
    }
    
    // Save to ALL locations
    $saved = 0;
    foreach ($dirs as $dir) {
        $dest = $dir . '/' . $filename;
        if (copy($file['tmp_name'], $dest)) {
            echo "<span style='color:#4ade80'>✓ Saved to: " . str_replace($root, '', $dest) . "</span>\n";
            $saved++;
        }
    }
    
    if ($saved > 0) {
        // Update database - use old format for compatibility
        $dbPath = 'settings/' . $filename;
        \App\Models\Setting::setValue('site_logo', $dbPath);
        echo "\n<span style='color:#4ade80'>✓ Database updated: site_logo = $dbPath</span>\n";
    }
}

// ACTION: Upload favicon
if ($action === 'upload' && isset($_FILES['favicon']) && $_FILES['favicon']['error'] === 0) {
    echo "Uploading favicon...\n";
    
    $file = $_FILES['favicon'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'favicon_' . time() . '.' . $ext;
    
    $dirs = [
        $root . '/public/uploads/settings',
        $root . '/public/storage/settings',
        $root . '/storage/app/public/settings',
    ];
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    $saved = 0;
    foreach ($dirs as $dir) {
        $dest = $dir . '/' . $filename;
        if (copy($file['tmp_name'], $dest)) {
            echo "<span style='color:#4ade80'>✓ Saved to: " . str_replace($root, '', $dest) . "</span>\n";
            $saved++;
        }
    }
    
    if ($saved > 0) {
        $dbPath = 'settings/' . $filename;
        \App\Models\Setting::setValue('site_favicon', $dbPath);
        echo "\n<span style='color:#4ade80'>✓ Database updated: site_favicon = $dbPath</span>\n";
    }
}

// Check current status
echo "\n<h3>Current Status:</h3>\n";

$logo = \App\Models\Setting::getValue('site_logo');
$favicon = \App\Models\Setting::getValue('site_favicon');

echo "site_logo: " . ($logo ?: '<null>') . "\n";
echo "site_favicon: " . ($favicon ?: '<null>') . "\n\n";

// Check file existence
if ($logo) {
    echo "Logo file locations:\n";
    $locations = [
        '/public/storage/' . $logo,
        '/public/uploads/' . $logo,
        '/storage/app/public/' . $logo,
    ];
    foreach ($locations as $loc) {
        $full = $root . $loc;
        $exists = file_exists($full);
        echo "  " . $loc . ": " . ($exists ? "<span style='color:#4ade80'>EXISTS</span>" : "<span style='color:#f87171'>NOT FOUND</span>") . "\n";
    }
    
    echo "\nLogo URLs to test:\n";
    echo "  <a href='/storage/$logo' style='color:#38bdf8' target='_blank'>/storage/$logo</a>\n";
}

// Clear cache
echo "\n<h3>Clearing cache...</h3>\n";
try {
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "<span style='color:#4ade80'>✓ Cache cleared</span>\n";
} catch (Throwable $e) {
    // Ignore
}

// Upload form
echo "\n<h3>Upload Logo & Favicon:</h3>";
?>
<form method="POST" enctype="multipart/form-data" action="?token=super123&action=upload" style="background:#2d2d44;padding:20px;border-radius:10px;margin:10px 0">
    <div style="margin-bottom:15px">
        <label style="display:block;margin-bottom:5px">Logo (PNG, JPG, SVG):</label>
        <input type="file" name="logo" accept="image/*" style="background:#1a1a2e;padding:8px;border-radius:5px;width:100%">
    </div>
    <div style="margin-bottom:15px">
        <label style="display:block;margin-bottom:5px">Favicon (PNG, ICO, SVG):</label>
        <input type="file" name="favicon" accept="image/*,.ico" style="background:#1a1a2e;padding:8px;border-radius:5px;width:100%">
    </div>
    <button type="submit" style="background:#2563eb;color:white;padding:10px 30px;border:none;border-radius:5px;cursor:pointer;font-weight:bold">
        Upload & Save
    </button>
</form>
<?php

// Preview
if ($logo) {
    echo "\n<h3>Logo Preview:</h3>\n";
    echo "<img src='/storage/$logo' style='max-height:80px;border:1px solid #666;background:#fff;padding:10px'>\n";
}

echo "\n<span style='color:#f87171;font-weight:bold'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";
