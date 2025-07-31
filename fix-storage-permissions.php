<?php
/**
 * Fix Storage Permissions and Directory Structure
 * Run this script after uploading files to the server
 */

echo "Setting up Laravel storage structure and permissions...\n";

// Get the current directory (should be the Laravel root)
$baseDir = __DIR__;
$storageDir = $baseDir . '/storage';

// Create storage directories if they don't exist
$directories = [
    $storageDir,
    $storageDir . '/app',
    $storageDir . '/app/public',
    $storageDir . '/framework',
    $storageDir . '/framework/cache',
    $storageDir . '/framework/cache/data',
    $storageDir . '/framework/sessions',
    $storageDir . '/framework/testing',
    $storageDir . '/framework/views',
    $storageDir . '/logs',
    $baseDir . '/bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✓ Created directory: $dir\n";
        } else {
            echo "✗ Failed to create directory: $dir\n";
        }
    } else {
        echo "✓ Directory exists: $dir\n";
    }
}

// Set permissions for directories
$permissionDirs = [
    $storageDir => 0755,
    $baseDir . '/bootstrap/cache' => 0755,
    $baseDir . '/public' => 0755,
];

foreach ($permissionDirs as $dir => $permission) {
    if (is_dir($dir)) {
        if (chmod($dir, $permission)) {
            echo "✓ Set permissions for: $dir\n";
        } else {
            echo "✗ Failed to set permissions for: $dir\n";
        }
        
        // Recursively set permissions for subdirectories
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                chmod($item->getRealPath(), 0755);
            } else {
                chmod($item->getRealPath(), 0644);
            }
        }
    }
}

// Create symbolic link for storage (if not exists)
$publicStorageLink = $baseDir . '/public/storage';
$storageAppPublic = $storageDir . '/app/public';

if (!file_exists($publicStorageLink) && is_dir($storageAppPublic)) {
    if (symlink($storageAppPublic, $publicStorageLink)) {
        echo "✓ Created storage symbolic link\n";
    } else {
        echo "✗ Failed to create storage symbolic link\n";
    }
} else {
    echo "✓ Storage link already exists or storage/app/public missing\n";
}

// Create .htaccess file for public directory if it doesn't exist
$htaccessPath = $baseDir . '/public/.htaccess';
if (!file_exists($htaccessPath)) {
    $htaccessContent = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>';
    
    if (file_put_contents($htaccessPath, $htaccessContent)) {
        echo "✓ Created .htaccess file\n";
    } else {
        echo "✗ Failed to create .htaccess file\n";
    }
} else {
    echo "✓ .htaccess file already exists\n";
}

echo "\nSetup completed! Now run the following commands:\n";
echo "1. php artisan config:cache\n";
echo "2. php artisan route:cache\n";
echo "3. php artisan view:cache\n";
echo "4. php artisan migrate\n";
echo "5. php artisan db:seed\n";
echo "\nIf you're still getting permission errors, contact your hosting provider to ensure PHP has write access to the storage and bootstrap/cache directories.\n";
?>