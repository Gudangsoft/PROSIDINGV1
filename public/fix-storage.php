<?php
// Fix Storage Link dan Logo/Favicon
// Akses: /fix-storage.php?token=storage123
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'storage123') {
    die('Token: ?token=storage123');
}

$root = dirname(__DIR__);

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#38bdf8'>FIX STORAGE & LOGO/FAVICON</h2>\n\n";

// 1. Check storage link
echo "1. Checking storage link...\n";
$storageLink = __DIR__ . '/storage';
$targetPath = $root . '/storage/app/public';

if (is_link($storageLink)) {
    $linkTarget = readlink($storageLink);
    echo "   Symlink exists, points to: $linkTarget\n";
    
    if (realpath($linkTarget) === realpath($targetPath)) {
        echo "   <span style='color:#4ade80'>✓ Storage link is correct</span>\n";
    } else {
        echo "   <span style='color:#fbbf24'>⚠ Symlink target mismatch</span>\n";
        echo "   Expected: $targetPath\n";
        echo "   Actual: $linkTarget\n";
    }
} elseif (is_dir($storageLink)) {
    echo "   <span style='color:#fbbf24'>⚠ 'storage' is a directory, not a symlink</span>\n";
    echo "   This can work but may have issues.\n";
} else {
    echo "   <span style='color:#f87171'>✗ Storage link does not exist!</span>\n";
    echo "   Attempting to create...\n";
    
    // Try to create symlink (may fail on shared hosting)
    if (@symlink($targetPath, $storageLink)) {
        echo "   <span style='color:#4ade80'>✓ Symlink created successfully</span>\n";
    } else {
        echo "   <span style='color:#fbbf24'>⚠ Cannot create symlink (shared hosting limitation)</span>\n";
        echo "   Creating directory copy instead...\n";
        
        // Create directory and copy contents
        if (!is_dir($storageLink)) {
            mkdir($storageLink, 0755, true);
        }
        
        // Copy contents
        $settingsDir = $root . '/storage/app/public/settings';
        $targetSettingsDir = __DIR__ . '/storage/settings';
        
        if (is_dir($settingsDir)) {
            if (!is_dir($targetSettingsDir)) {
                mkdir($targetSettingsDir, 0755, true);
            }
            
            foreach (glob($settingsDir . '/*') as $file) {
                $destFile = $targetSettingsDir . '/' . basename($file);
                if (copy($file, $destFile)) {
                    echo "   Copied: " . basename($file) . "\n";
                }
            }
        }
    }
}

// 2. Check settings directory
echo "\n2. Checking settings directory...\n";
$settingsDir = $root . '/storage/app/public/settings';
if (is_dir($settingsDir)) {
    echo "   <span style='color:#4ade80'>✓ Settings directory exists</span>\n";
    $files = glob($settingsDir . '/*');
    echo "   Files in directory: " . count($files) . "\n";
    foreach ($files as $file) {
        echo "   - " . basename($file) . " (" . filesize($file) . " bytes)\n";
    }
} else {
    echo "   <span style='color:#fbbf24'>⚠ Settings directory does not exist</span>\n";
    mkdir($settingsDir, 0755, true);
    echo "   <span style='color:#4ade80'>✓ Created settings directory</span>\n";
}

// 3. Check database settings
echo "\n3. Checking database settings...\n";
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    $logo = \App\Models\Setting::getValue('site_logo');
    $favicon = \App\Models\Setting::getValue('site_favicon');
    
    echo "   site_logo: " . ($logo ?: '<null>') . "\n";
    echo "   site_favicon: " . ($favicon ?: '<null>') . "\n";
    
    if ($logo) {
        $logoPath = $root . '/storage/app/public/' . $logo;
        if (file_exists($logoPath)) {
            echo "   <span style='color:#4ade80'>✓ Logo file exists</span> (" . filesize($logoPath) . " bytes)\n";
        } else {
            echo "   <span style='color:#f87171'>✗ Logo file NOT found at: $logoPath</span>\n";
        }
        
        // Check public accessible
        $publicLogoPath = __DIR__ . '/storage/' . $logo;
        if (file_exists($publicLogoPath)) {
            echo "   <span style='color:#4ade80'>✓ Logo accessible via public/storage</span>\n";
        } else {
            echo "   <span style='color:#f87171'>✗ Logo NOT accessible via public/storage</span>\n";
        }
    }
    
    if ($favicon) {
        $faviconPath = $root . '/storage/app/public/' . $favicon;
        if (file_exists($faviconPath)) {
            echo "   <span style='color:#4ade80'>✓ Favicon file exists</span> (" . filesize($faviconPath) . " bytes)\n";
        } else {
            echo "   <span style='color:#f87171'>✗ Favicon file NOT found at: $faviconPath</span>\n";
        }
    }
    
} catch (Throwable $e) {
    echo "   <span style='color:#f87171'>Error: " . $e->getMessage() . "</span>\n";
}

// 4. Check Livewire temp directory
echo "\n4. Checking Livewire temp directory...\n";
$livewireTmpDir = $root . '/storage/app/livewire-tmp';
if (is_dir($livewireTmpDir)) {
    echo "   <span style='color:#4ade80'>✓ Livewire temp directory exists</span>\n";
    echo "   Permissions: " . substr(sprintf('%o', fileperms($livewireTmpDir)), -4) . "\n";
} else {
    mkdir($livewireTmpDir, 0755, true);
    echo "   <span style='color:#4ade80'>✓ Created Livewire temp directory</span>\n";
}

// 5. Check directory permissions
echo "\n5. Checking directory permissions...\n";
$dirsToCheck = [
    $root . '/storage/app/public',
    $root . '/storage/app/public/settings',
    $root . '/storage/app/livewire-tmp',
    $root . '/storage/framework/cache',
    $root . '/storage/logs',
];

foreach ($dirsToCheck as $dir) {
    if (is_dir($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        $writable = is_writable($dir) ? "<span style='color:#4ade80'>writable</span>" : "<span style='color:#f87171'>not writable</span>";
        echo "   " . str_replace($root, '', $dir) . ": $perms ($writable)\n";
    } else {
        mkdir($dir, 0755, true);
        echo "   " . str_replace($root, '', $dir) . ": <span style='color:#4ade80'>created</span>\n";
    }
}

// 6. Fix action - create/refresh storage link
echo "\n6. Available actions:\n";
$action = $_GET['action'] ?? '';

if ($action === 'refresh_link') {
    echo "   Refreshing storage link...\n";
    
    // Remove existing
    if (is_link($storageLink)) {
        unlink($storageLink);
    } elseif (is_dir($storageLink)) {
        // If it's a real directory, we need to be careful
        echo "   <span style='color:#fbbf24'>Existing 'storage' is a directory, not removing</span>\n";
    }
    
    // Create new symlink
    if (@symlink($targetPath, $storageLink)) {
        echo "   <span style='color:#4ade80'>✓ Symlink refreshed</span>\n";
    } else {
        echo "   <span style='color:#fbbf24'>Cannot create symlink, copying files instead...</span>\n";
        
        if (!is_dir($storageLink)) {
            mkdir($storageLink, 0755, true);
        }
        
        // Copy all folders from storage/app/public to public/storage
        $sourceDir = $root . '/storage/app/public';
        copyDir($sourceDir, $storageLink);
        echo "   <span style='color:#4ade80'>✓ Files copied</span>\n";
    }
}

if ($action === 'copy_files') {
    echo "   Copying storage files to public/storage...\n";
    
    if (!is_dir($storageLink)) {
        mkdir($storageLink, 0755, true);
    }
    
    $sourceDir = $root . '/storage/app/public';
    copyDir($sourceDir, $storageLink);
    echo "   <span style='color:#4ade80'>✓ Files copied successfully</span>\n";
}

if ($action === 'clear_settings') {
    echo "   Clearing site_logo and site_favicon...\n";
    \App\Models\Setting::setValue('site_logo', null);
    \App\Models\Setting::setValue('site_favicon', null);
    echo "   <span style='color:#4ade80'>✓ Cleared. Upload new logo/favicon.</span>\n";
}

echo "\n<a href='?token=storage123&action=refresh_link' style='color:#38bdf8'>→ Refresh storage link</a>\n";
echo "<a href='?token=storage123&action=copy_files' style='color:#38bdf8'>→ Copy files manually</a>\n";
echo "<a href='?token=storage123&action=clear_settings' style='color:#fbbf24'>→ Clear logo/favicon settings</a>\n";

echo "\n<span style='color:#f87171'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";

function copyDir($src, $dst) {
    if (!is_dir($src)) return;
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..') continue;
        
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        
        if (is_dir($srcPath)) {
            copyDir($srcPath, $dstPath);
        } else {
            copy($srcPath, $dstPath);
            echo "   Copied: " . str_replace(dirname(dirname($src)), '', $srcPath) . "\n";
        }
    }
    closedir($dir);
}
