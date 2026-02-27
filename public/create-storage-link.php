<?php
// Manual Storage Link Creator
// Akses: /create-storage-link.php?token=link123
// HAPUS SETELAH SELESAI!

if (($_GET['token'] ?? '') !== 'link123') {
    die('Token: ?token=link123');
}

$root = dirname(__DIR__);
$publicStorage = __DIR__ . '/storage';
$appStorage = $root . '/storage/app/public';

echo "<pre style='background:#1a1a2e;color:#eee;padding:20px;font-family:monospace'>";
echo "<h2 style='color:#38bdf8'>MANUAL STORAGE LINK CREATOR</h2>\n\n";

// Check current state
echo "1. Current state:\n";
echo "   Target: $appStorage\n";
echo "   Link location: $publicStorage\n\n";

if (is_link($publicStorage)) {
    echo "   Status: <span style='color:#4ade80'>Symlink exists</span>\n";
    echo "   Points to: " . readlink($publicStorage) . "\n";
} elseif (is_dir($publicStorage)) {
    echo "   Status: <span style='color:#fbbf24'>Directory exists (not symlink)</span>\n";
} elseif (file_exists($publicStorage)) {
    echo "   Status: <span style='color:#fbbf24'>File exists</span>\n";
} else {
    echo "   Status: <span style='color:#f87171'>Does not exist</span>\n";
}

$action = $_GET['action'] ?? '';

// ACTION: Create symlink using PHP symlink()
if ($action === 'symlink') {
    echo "\n2. Creating symlink...\n";
    
    // Remove existing if any
    if (is_link($publicStorage)) {
        unlink($publicStorage);
        echo "   Removed existing symlink\n";
    }
    
    // Try symlink
    if (@symlink($appStorage, $publicStorage)) {
        echo "   <span style='color:#4ade80'>✓ Symlink created successfully!</span>\n";
    } else {
        $error = error_get_last();
        echo "   <span style='color:#f87171'>✗ Failed to create symlink</span>\n";
        echo "   Error: " . ($error['message'] ?? 'Unknown') . "\n";
        echo "   Try the 'copy' action instead.\n";
    }
}

// ACTION: Copy files (alternative for restricted hosting)
if ($action === 'copy') {
    echo "\n2. Copying files from storage/app/public to public/storage...\n";
    
    // Create public/storage if not exists
    if (!is_dir($publicStorage)) {
        mkdir($publicStorage, 0755, true);
        echo "   Created: public/storage/\n";
    }
    
    // Create .gitignore
    file_put_contents($publicStorage . '/.gitignore', "*\n!.gitignore\n");
    
    // Recursively copy all content
    $copied = copyDirectory($appStorage, $publicStorage);
    echo "   <span style='color:#4ade80'>✓ Copied $copied files</span>\n";
    
    echo "\n   <span style='color:#fbbf24'>PENTING: Setiap upload file baru, jalankan copy lagi!</span>\n";
}

// ACTION: Sync (copy only new/changed files)
if ($action === 'sync') {
    echo "\n2. Syncing files...\n";
    
    if (!is_dir($publicStorage)) {
        mkdir($publicStorage, 0755, true);
    }
    
    $synced = syncDirectory($appStorage, $publicStorage);
    echo "   <span style='color:#4ade80'>✓ Synced $synced files</span>\n";
}

// ACTION: Check which files are missing
if ($action === 'check') {
    echo "\n2. Checking for missing files...\n";
    
    $missing = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($appStorage, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($appStorage . '/', '', $file->getPathname());
            $publicPath = $publicStorage . '/' . $relativePath;
            
            if (!file_exists($publicPath)) {
                $missing[] = $relativePath;
            }
        }
    }
    
    if (empty($missing)) {
        echo "   <span style='color:#4ade80'>✓ All files are present in public/storage</span>\n";
    } else {
        echo "   <span style='color:#fbbf24'>Missing " . count($missing) . " files:</span>\n";
        foreach ($missing as $m) {
            echo "   - $m\n";
        }
        echo "\n   Run 'sync' to copy missing files.\n";
    }
}

// List available actions
echo "\n<h3>Actions:</h3>";
echo "<a href='?token=link123&action=symlink' style='display:block;padding:10px;background:#1e40af;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Create Symlink (best option)</a>\n";
echo "<a href='?token=link123&action=copy' style='display:block;padding:10px;background:#047857;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Copy Files (if symlink fails)</a>\n";
echo "<a href='?token=link123&action=sync' style='display:block;padding:10px;background:#7c3aed;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Sync New Files Only</a>\n";
echo "<a href='?token=link123&action=check' style='display:block;padding:10px;background:#64748b;color:white;margin:5px 0;text-decoration:none;border-radius:5px'>→ Check Missing Files</a>\n";

echo "\n<span style='color:#f87171;font-weight:bold'>HAPUS FILE INI SETELAH SELESAI!</span>\n";
echo "</pre>";

// Helper function: Copy directory recursively
function copyDirectory($src, $dst) {
    $count = 0;
    
    if (!is_dir($src)) return 0;
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..') continue;
        
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        
        if (is_dir($srcPath)) {
            $count += copyDirectory($srcPath, $dstPath);
        } else {
            if (copy($srcPath, $dstPath)) {
                $count++;
            }
        }
    }
    closedir($dir);
    
    return $count;
}

// Helper function: Sync directory (copy only new/changed)
function syncDirectory($src, $dst) {
    $count = 0;
    
    if (!is_dir($src)) return 0;
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..') continue;
        
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        
        if (is_dir($srcPath)) {
            $count += syncDirectory($srcPath, $dstPath);
        } else {
            // Only copy if doesn't exist or different size/time
            $needsCopy = false;
            if (!file_exists($dstPath)) {
                $needsCopy = true;
            } elseif (filesize($srcPath) !== filesize($dstPath)) {
                $needsCopy = true;
            } elseif (filemtime($srcPath) > filemtime($dstPath)) {
                $needsCopy = true;
            }
            
            if ($needsCopy && copy($srcPath, $dstPath)) {
                $count++;
            }
        }
    }
    closedir($dir);
    
    return $count;
}
