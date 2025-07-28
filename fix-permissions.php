<?php
/**
 * File Permissions Fixer for Laravel on cPanel
 * This script sets the correct permissions for Laravel directories
 * 
 * IMPORTANT: Delete this file after setup is complete
 */

// Prevent direct access from web
if (!isset($_GET['run'])) {
    die('Access denied. Add ?run=fix to the URL to execute.');
}

echo "<h1>Tawasul Limousine - Permission Fixer</h1>";
echo "<hr>";

// Function to fix directory permissions
function fixPermissions($path, $permissions, $description) {
    echo "<h3>$description</h3>";
    echo "<p>Path: <code>$path</code></p>";
    
    $fullPath = __DIR__ . '/' . $path;
    
    if (!is_dir($fullPath)) {
        echo "<p style='color: red;'>❌ Directory does not exist: $path</p>";
        echo "<hr>";
        return false;
    }
    
    // Get current permissions
    $currentPerms = substr(sprintf('%o', fileperms($fullPath)), -4);
    echo "<p>Current permissions: <code>$currentPerms</code></p>";
    
    // Check if writable
    $wasWritable = is_writable($fullPath);
    echo "<p>Currently writable: " . ($wasWritable ? '✅ YES' : '❌ NO') . "</p>";
    
    // Try to change permissions
    if (chmod($fullPath, octdec($permissions))) {
        $newPerms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $nowWritable = is_writable($fullPath);
        
        echo "<p style='color: green;'>✅ Permissions updated successfully!</p>";
        echo "<p>New permissions: <code>$newPerms</code></p>";
        echo "<p>Now writable: " . ($nowWritable ? '✅ YES' : '❌ NO') . "</p>";
        
        // Recursively fix subdirectories if needed
        if (in_array($path, ['storage', 'storage/app', 'storage/framework', 'storage/logs'])) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($fullPath),
                RecursiveIteratorIterator::SELF_FIRST
            );
            
            $fixed = 0;
            foreach ($iterator as $item) {
                if ($item->isDir() && !in_array($item->getFilename(), ['.', '..'])) {
                    if (chmod($item->getPathname(), octdec($permissions))) {
                        $fixed++;
                    }
                }
            }
            
            if ($fixed > 0) {
                echo "<p>✅ Fixed permissions for $fixed subdirectories</p>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>❌ Failed to change permissions</p>";
        echo "<p>You may need to change permissions manually via cPanel File Manager:</p>";
        echo "<ol>";
        echo "<li>Right-click on the directory</li>";
        echo "<li>Select 'Change Permissions'</li>";
        echo "<li>Set to $permissions or check 'Read', 'Write', and 'Execute' for Owner, Group, and Public</li>";
        echo "</ol>";
    }
    
    echo "<hr>";
    return true;
}

// Function to create missing directories
function createMissingDirectories() {
    echo "<h3>Creating Missing Directories</h3>";
    
    $requiredDirs = [
        'storage/app/public',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache'
    ];
    
    $created = 0;
    foreach ($requiredDirs as $dir) {
        $fullPath = __DIR__ . '/' . $dir;
        if (!is_dir($fullPath)) {
            if (mkdir($fullPath, 0755, true)) {
                echo "<p>✅ Created directory: <code>$dir</code></p>";
                $created++;
            } else {
                echo "<p style='color: red;'>❌ Failed to create: <code>$dir</code></p>";
            }
        } else {
            echo "<p>✅ Directory exists: <code>$dir</code></p>";
        }
    }
    
    if ($created > 0) {
        echo "<p style='color: green;'>Created $created missing directories</p>";
    } else {
        echo "<p>All required directories already exist</p>";
    }
    
    echo "<hr>";
}

// Function to create .htaccess files
function createHtaccessFiles() {
    echo "<h3>Creating .htaccess Files</h3>";
    
    // Storage .htaccess
    $storageHtaccess = __DIR__ . '/storage/.htaccess';
    if (!file_exists($storageHtaccess)) {
        $content = "Options -Indexes\nDeny from all";
        if (file_put_contents($storageHtaccess, $content)) {
            echo "<p>✅ Created storage/.htaccess</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create storage/.htaccess</p>";
        }
    } else {
        echo "<p>✅ storage/.htaccess already exists</p>";
    }
    
    // Bootstrap cache .htaccess
    $bootstrapHtaccess = __DIR__ . '/bootstrap/cache/.htaccess';
    if (!file_exists($bootstrapHtaccess)) {
        $content = "Options -Indexes\nDeny from all";
        if (file_put_contents($bootstrapHtaccess, $content)) {
            echo "<p>✅ Created bootstrap/cache/.htaccess</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create bootstrap/cache/.htaccess</p>";
        }
    } else {
        echo "<p>✅ bootstrap/cache/.htaccess already exists</p>";
    }
    
    echo "<hr>";
}

echo "<p><strong>Permission Fix Started:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// 1. Create missing directories
createMissingDirectories();

// 2. Fix permissions for critical directories
fixPermissions('storage', '0755', 'Storage Directory');
fixPermissions('storage/app', '0755', 'Storage App Directory');
fixPermissions('storage/framework', '0755', 'Storage Framework Directory');
fixPermissions('storage/framework/cache', '0755', 'Storage Framework Cache');
fixPermissions('storage/framework/sessions', '0755', 'Storage Framework Sessions');
fixPermissions('storage/framework/views', '0755', 'Storage Framework Views');
fixPermissions('storage/logs', '0755', 'Storage Logs Directory');
fixPermissions('bootstrap/cache', '0755', 'Bootstrap Cache Directory');

// 3. Create security .htaccess files
createHtaccessFiles();

// 4. Final verification
echo "<h3>Final Verification</h3>";
$criticalPaths = [
    'storage',
    'storage/app',
    'storage/framework',
    'storage/logs',
    'bootstrap/cache'
];

$allGood = true;
foreach ($criticalPaths as $path) {
    $fullPath = __DIR__ . '/' . $path;
    $writable = is_writable($fullPath);
    $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
    
    echo "<p>$path: ";
    if ($writable) {
        echo "<span style='color: green;'>✅ Writable ($perms)</span>";
    } else {
        echo "<span style='color: red;'>❌ Not Writable ($perms)</span>";
        $allGood = false;
    }
    echo "</p>";
}

echo "<hr>";

if ($allGood) {
    echo "<h2 style='color: green;'>✅ All Permissions Fixed Successfully!</h2>";
    echo "<p>Laravel should now work properly on your server.</p>";
} else {
    echo "<h2 style='color: orange;'>⚠️ Some Issues Remain</h2>";
    echo "<p>You may need to manually fix permissions via cPanel File Manager:</p>";
    echo "<ol>";
    echo "<li>Go to cPanel File Manager</li>";
    echo "<li>Navigate to your project directory</li>";
    echo "<li>Right-click on storage/ and bootstrap/cache/ directories</li>";
    echo "<li>Select 'Change Permissions'</li>";
    echo "<li>Set to 755 or 777 (check all boxes)</li>";
    echo "<li>Apply to all subdirectories</li>";
    echo "</ol>";
}

echo "<p><strong>Permission Fix Completed:</strong> " . date('Y-m-d H:i:s') . "</p>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; border-left: 4px solid #ff0000;'>";
echo "<h3 style='color: #cc0000; margin-top: 0;'>🔒 SECURITY NOTICE</h3>";
echo "<p><strong>DELETE THIS FILE (fix-permissions.php) AFTER SETUP!</strong></p>";
echo "<p>This file should not remain on your production server.</p>";
echo "</div>";

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>✅ <strong>Delete this fix-permissions.php file</strong></li>";
echo "<li>Run the <a href='migrate.php?run=migrate'>migrate.php</a> script</li>";
echo "<li>Run the main <a href='setup.php?run=setup'>setup.php</a> script</li>";
echo "</ol>";

?>