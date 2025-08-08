<?php
/**
 * Complete Laravel Installation Script for cPanel
 * This script runs all deployment commands in sequence
 * 
 * IMPORTANT: Delete this file after installation is complete
 */

// Prevent direct access from web
if (!isset($_GET['run']) || $_GET['run'] !== 'deploy') {
    die('Access denied. Add ?run=deploy to the URL to execute.');
}

echo "<!DOCTYPE html>
<html>
<head>
    <title>Tawasul Limousine - Laravel Installation</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; border-left: 4px solid #007bff; }
        .step { background: #e9ecef; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 4px; }
        .alert-danger { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
    </style>
</head>
<body>
<div class='container'>";

echo "<h1>🚀 Tawasul Limousine - Complete Installation</h1>";
echo "<p><strong>Installation Started:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Function to run commands and display output
function runStep($title, $command, $successMessage = null) {
    echo "<div class='step'>";
    echo "<h3>$title</h3>";
    echo "<p>Running: <code>$command</code></p>";
    
    $startTime = microtime(true);
    $output = shell_exec("cd " . __DIR__ . " && $command 2>&1");
    $endTime = microtime(true);
    $duration = round($endTime - $startTime, 2);
    
    echo "<pre>" . htmlspecialchars($output) . "</pre>";
    echo "<p><small>Completed in {$duration} seconds</small></p>";
    
    if ($successMessage) {
        echo "<p class='success'>✅ $successMessage</p>";
    }
    
    echo "</div>";
    return $output;
}

// Function to check requirements
function checkRequirements() {
    echo "<div class='step'>";
    echo "<h3>📋 System Requirements Check</h3>";
    
    $errors = [];
    $warnings = [];
    
    // Check PHP version
    $phpVersion = PHP_VERSION;
    echo "<p><strong>PHP Version:</strong> $phpVersion</p>";
    if (version_compare($phpVersion, '8.2.0', '<')) {
        $errors[] = "PHP 8.2 or higher required. Current: $phpVersion";
    }
    
    // Check required extensions
    $required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'];
    echo "<p><strong>PHP Extensions:</strong></p><ul>";
    foreach ($required as $ext) {
        $loaded = extension_loaded($ext);
        echo "<li>" . ($loaded ? '✅' : '❌') . " $ext</li>";
        if (!$loaded) {
            $errors[] = "PHP extension '$ext' is required";
        }
    }
    echo "</ul>";
    
    // Check important files
    echo "<p><strong>File Check:</strong></p><ul>";
    $files = ['.env' => 'Environment configuration', 'artisan' => 'Laravel artisan command'];
    foreach ($files as $file => $desc) {
        $exists = file_exists(__DIR__ . '/' . $file);
        echo "<li>" . ($exists ? '✅' : '❌') . " $file - $desc</li>";
        if (!$exists) {
            if ($file === '.env') {
                $warnings[] = ".env file missing - you may need to rename .env.production";
            } else {
                $errors[] = "$file file missing";
            }
        }
    }
    echo "</ul>";
    
    // Check directories
    echo "<p><strong>Directory Check:</strong></p><ul>";
    $dirs = ['storage', 'bootstrap/cache', 'vendor'];
    foreach ($dirs as $dir) {
        $exists = is_dir(__DIR__ . '/' . $dir);
        $writable = $exists ? is_writable(__DIR__ . '/' . $dir) : false;
        echo "<li>" . ($exists ? '✅' : '❌') . " $dir exists";
        if ($exists) {
            echo " - " . ($writable ? '✅ Writable' : '❌ Not writable');
            if (!$writable && $dir !== 'vendor') {
                $warnings[] = "$dir directory is not writable";
            }
        } else if ($dir === 'vendor') {
            $errors[] = "vendor directory missing - Composer dependencies not installed";
        }
        echo "</li>";
    }
    echo "</ul>";
    
    echo "</div>";
    
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'>";
        echo "<h4>❌ Critical Errors Found:</h4><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<p><strong>Cannot proceed with installation. Please fix these issues first.</strong></p>";
        echo "</div>";
        return false;
    }
    
    if (!empty($warnings)) {
        echo "<div class='alert alert-warning'>";
        echo "<h4>⚠️ Warnings:</h4><ul>";
        foreach ($warnings as $warning) {
            echo "<li>$warning</li>";
        }
        echo "</ul>";
        echo "<p>Installation will continue, but you may need to address these issues.</p>";
        echo "</div>";
    }
    
    return true;
}

// Start installation process
if (!checkRequirements()) {
    echo "<div class='alert alert-danger'>";
    echo "<h3>Installation Cannot Continue</h3>";
    echo "<p>Please fix the critical errors above and try again.</p>";
    echo "</div>";
    echo "</div></body></html>";
    exit;
}

echo "<div class='alert alert-success'>";
echo "<h3>✅ System Requirements Met</h3>";
echo "<p>Proceeding with Laravel installation...</p>";
echo "</div>";

// Step 1: Create missing directories and fix permissions
echo "<h2>Step 1: Directory Setup and Permissions</h2>";
$dirs = ['storage/app/public', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (!is_dir($fullPath)) {
        if (mkdir($fullPath, 0755, true)) {
            echo "<p class='success'>✅ Created directory: $dir</p>";
        } else {
            echo "<p class='error'>❌ Failed to create: $dir</p>";
        }
    }
}

// Fix permissions
$output = shell_exec("cd " . __DIR__ . " && chmod -R 755 storage bootstrap/cache 2>&1");
echo "<pre>Setting permissions: " . htmlspecialchars($output) . "</pre>";

// Step 2: Environment setup
echo "<h2>Step 2: Environment Configuration</h2>";
if (file_exists(__DIR__ . '/.env.production') && !file_exists(__DIR__ . '/.env')) {
    copy(__DIR__ . '/.env.production', __DIR__ . '/.env');
    echo "<p class='success'>✅ Copied .env.production to .env</p>";
}

// Step 3: Generate application key
echo "<h2>Step 3: Generate Application Key</h2>";
runStep('Generate Application Key', 'php artisan key:generate --force', 'Application key generated');

// Step 4: Clear caches
echo "<h2>Step 4: Clear All Caches</h2>";
runStep('Clear Configuration Cache', 'php artisan config:clear', 'Configuration cache cleared');
runStep('Clear Application Cache', 'php artisan cache:clear', 'Application cache cleared');
runStep('Clear View Cache', 'php artisan view:clear', 'View cache cleared');
runStep('Clear Route Cache', 'php artisan route:clear', 'Route cache cleared');

// Step 5: Database setup
echo "<h2>Step 5: Database Migration</h2>";
runStep('Run Database Migrations', 'php artisan migrate --force', 'Database migrations completed');

// Step 6: Seed admin user (optional)
echo "<h2>Step 6: Create Admin User</h2>";
$seedOutput = runStep('Seed Admin User', 'php artisan db:seed --class=AdminUserSeeder --force', 'Admin user seeded (if not exists)');

// Step 7: Optimize for production
echo "<h2>Step 7: Production Optimization</h2>";
runStep('Cache Configuration', 'php artisan config:cache', 'Configuration cached');
runStep('Cache Routes', 'php artisan route:cache', 'Routes cached');
runStep('Cache Views', 'php artisan view:cache', 'Views cached');

// Step 8: Final verification
echo "<h2>Step 8: Final Verification</h2>";
echo "<div class='step'>";
echo "<h3>🔍 Installation Verification</h3>";

// Check if key tables exist
try {
    $envPath = __DIR__ . '/.env';
    if (file_exists($envPath)) {
        $envContent = file_get_contents($envPath);
        $envLines = explode("\n", $envContent);
        $config = [];
        
        foreach ($envLines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $config[trim($key)] = trim($value, '"');
            }
        }
        
        if (isset($config['DB_DATABASE']) && isset($config['DB_USERNAME'])) {
            $host = $config['DB_HOST'] ?? 'localhost';
            $dbname = $config['DB_DATABASE'];
            $username = $config['DB_USERNAME'];
            $password = $config['DB_PASSWORD'] ?? '';
            
            $dsn = "mysql:host=$host;dbname=$dbname";
            $pdo = new PDO($dsn, $username, $password);
            
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            echo "<p class='success'>✅ Database connection successful</p>";
            echo "<p>Found " . count($tables) . " tables: " . implode(', ', $tables) . "</p>";
            
            // Check for required tables
            $requiredTables = ['users', 'bookings'];
            $missing = array_diff($requiredTables, $tables);
            if (empty($missing)) {
                echo "<p class='success'>✅ All required tables present</p>";
            } else {
                echo "<p class='warning'>⚠️ Missing tables: " . implode(', ', $missing) . "</p>";
            }
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Database verification failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Check directory permissions
$criticalDirs = ['storage', 'storage/logs', 'bootstrap/cache'];
$allWritable = true;
foreach ($criticalDirs as $dir) {
    $writable = is_writable(__DIR__ . '/' . $dir);
    echo "<p>" . ($writable ? '✅' : '❌') . " $dir is " . ($writable ? 'writable' : 'not writable') . "</p>";
    if (!$writable) $allWritable = false;
}

echo "</div>";

// Installation complete
echo "<div class='alert alert-success'>";
echo "<h2>🎉 Installation Complete!</h2>";
echo "<p><strong>Installation Finished:</strong> " . date('Y-m-d H:i:s') . "</p>";

if ($allWritable) {
    echo "<p class='success'>✅ All systems operational!</p>";
} else {
    echo "<p class='warning'>⚠️ Some permission issues detected. Laravel should still work, but you may want to fix directory permissions.</p>";
}

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li><strong>DELETE THIS install.php FILE IMMEDIATELY FOR SECURITY!</strong></li>";
echo "<li>Test your website: <a href='index.php' target='_blank'>Visit Homepage</a></li>";
echo "<li>Access admin panel: <a href='admin/dashboard' target='_blank'>Admin Dashboard</a></li>";
echo "<li>Default admin login: admin@tawasullimo.com / admin123</li>";
echo "<li>Configure Google Maps API key in .env</li>";
echo "<li>Set up email SMTP settings in .env</li>";
echo "</ol>";
echo "</div>";

echo "<div class='alert alert-danger'>";
echo "<h3>🔒 CRITICAL SECURITY WARNING</h3>";
echo "<p><strong>DELETE THIS install.php FILE NOW!</strong></p>";
echo "<p>This file contains sensitive installation routines and must not remain on your production server.</p>";
echo "<p>Also delete any other setup files: setup.php, migrate.php, fix-permissions.php, deploy.php</p>";
echo "</div>";

echo "</div></body></html>";
?>