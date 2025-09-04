<?php
/**
 * cPanel-Compatible Laravel Installation Script
 * This script runs all deployment commands without shell_exec
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

echo "<h1>🚀 Tawasul Limousine - cPanel Installation</h1>";
echo "<p><strong>Installation Started:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// PHP alternatives to artisan commands for cPanel
function runArtisanAlternative($command) {
    $parts = explode(' ', trim($command));
    if ($parts[0] !== 'php' || $parts[1] !== 'artisan') {
        return "Command not supported: $command";
    }
    
    $artisanCommand = $parts[2] ?? '';
    
    switch ($artisanCommand) {
        case 'key:generate':
            return generateAppKeyManually();
        case 'config:clear':
            return clearConfigCacheManually();
        case 'cache:clear':
            return clearAppCacheManually();
        case 'view:clear':
            return clearViewCacheManually();
        case 'route:clear':
            return clearRouteCacheManually();
        case 'migrate':
            return runMigrationsManually();
        case 'config:cache':
            return "Config caching skipped (not needed for cPanel)";
        case 'route:cache':
            return "Route caching skipped (not needed for cPanel)";
        case 'view:cache':
            return "View caching skipped (not needed for cPanel)";
        case 'db:seed':
            return createAdminUserManually();
        default:
            return "Artisan command '$artisanCommand' not implemented";
    }
}

function generateAppKeyManually() {
    $key = 'base64:' . base64_encode(random_bytes(32));
    $envPath = __DIR__ . '/.env';
    
    if (file_exists($envPath)) {
        $envContent = file_get_contents($envPath);
        if (strpos($envContent, 'APP_KEY=') !== false) {
            $envContent = preg_replace('/APP_KEY=.*/', "APP_KEY=$key", $envContent);
        } else {
            $envContent .= "\nAPP_KEY=$key";
        }
        file_put_contents($envPath, $envContent);
        return "✅ Application key generated: $key";
    }
    return "❌ .env file not found";
}

function clearConfigCacheManually() {
    $cachePath = __DIR__ . '/bootstrap/cache/config.php';
    if (file_exists($cachePath)) {
        unlink($cachePath);
        return "✅ Configuration cache cleared";
    }
    return "✅ Configuration cache already clear";
}

function clearAppCacheManually() {
    $cacheDir = __DIR__ . '/storage/framework/cache';
    if (is_dir($cacheDir)) {
        $cleared = 0;
        $files = glob($cacheDir . '/*/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $cleared++;
            }
        }
        return "✅ Application cache cleared ($cleared files)";
    }
    return "✅ Cache directory clean";
}

function clearViewCacheManually() {
    $viewCacheDir = __DIR__ . '/storage/framework/views';
    if (is_dir($viewCacheDir)) {
        $files = glob($viewCacheDir . '/*.php');
        foreach ($files as $file) {
            unlink($file);
        }
        return "✅ View cache cleared (" . count($files) . " files)";
    }
    return "✅ View cache already clear";
}

function clearRouteCacheManually() {
    $routeCacheFiles = [
        __DIR__ . '/bootstrap/cache/routes-v7.php',
        __DIR__ . '/bootstrap/cache/routes.php'
    ];
    
    $cleared = 0;
    foreach ($routeCacheFiles as $file) {
        if (file_exists($file)) {
            unlink($file);
            $cleared++;
        }
    }
    
    return "✅ Route cache cleared";
}

function runMigrationsManually() {
    try {
        $envPath = __DIR__ . '/.env';
        if (!file_exists($envPath)) {
            return "❌ .env file not found";
        }
        
        // Parse .env file
        $envContent = file_get_contents($envPath);
        $envLines = explode("\n", $envContent);
        $config = [];
        
        foreach ($envLines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $config[trim($key)] = trim($value, '"');
            }
        }
        
        $host = $config['DB_HOST'] ?? 'localhost';
        $dbname = $config['DB_DATABASE'] ?? '';
        $username = $config['DB_USERNAME'] ?? '';
        $password = $config['DB_PASSWORD'] ?? '';
        
        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check existing tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $created = 0;
        
        // Create users table
        if (!in_array('users', $tables)) {
            $pdo->exec("CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");
            $created++;
        }
        
        // Create bookings table
        if (!in_array('bookings', $tables)) {
            $pdo->exec("CREATE TABLE bookings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(50),
                pickup_location TEXT,
                dropoff_location TEXT,
                pickup_date DATE,
                pickup_time TIME,
                passengers INT,
                service_type VARCHAR(100),
                status VARCHAR(50) DEFAULT 'pending',
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");
            $created++;
        }
        
        return "✅ Database migrations completed ($created new tables)";
        
    } catch (Exception $e) {
        return "❌ Migration failed: " . $e->getMessage();
    }
}

function createAdminUserManually() {
    try {
        $envPath = __DIR__ . '/.env';
        if (!file_exists($envPath)) {
            return "❌ .env file not found";
        }
        
        // Parse .env
        $envContent = file_get_contents($envPath);
        $envLines = explode("\n", $envContent);
        $config = [];
        
        foreach ($envLines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $config[trim($key)] = trim($value, '"');
            }
        }
        
        $host = $config['DB_HOST'] ?? 'localhost';
        $dbname = $config['DB_DATABASE'] ?? '';
        $username = $config['DB_USERNAME'] ?? '';
        $password = $config['DB_PASSWORD'] ?? '';
        
        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if admin exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute(['admin@tawasullimo.com']);
        $exists = $stmt->fetchColumn();
        
        if (!$exists) {
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute(['Admin', 'admin@tawasullimo.com', $hashedPassword]);
            return "✅ Admin user created (admin@tawasullimo.com / admin123)";
        }
        
        return "✅ Admin user already exists";
        
    } catch (Exception $e) {
        return "❌ Failed to create admin: " . $e->getMessage();
    }
}

function setPermissionsManually() {
    $paths = [
        'storage' => 0755,
        'storage/app' => 0755,
        'storage/framework' => 0755,
        'storage/framework/cache' => 0755,
        'storage/framework/sessions' => 0755,
        'storage/framework/views' => 0755,
        'storage/logs' => 0755,
        'bootstrap/cache' => 0755
    ];
    
    $results = [];
    foreach ($paths as $path => $permission) {
        $fullPath = __DIR__ . '/' . $path;
        if (is_dir($fullPath)) {
            if (chmod($fullPath, $permission)) {
                $results[] = "✅ $path";
            } else {
                $results[] = "❌ $path failed";
            }
        } else {
            $results[] = "⚠️ $path not found";
        }
    }
    
    return implode("\n", $results);
}

function runStep($title, $command, $successMessage = null) {
    echo "<div class='step'>";
    echo "<h3>$title</h3>";
    echo "<p>Running: <code>$command</code></p>";
    
    $startTime = microtime(true);
    $output = runArtisanAlternative($command);
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

function checkRequirements() {
    echo "<div class='step'>";
    echo "<h3>📋 System Check</h3>";
    
    $errors = [];
    
    // Check PHP version
    $phpVersion = PHP_VERSION;
    echo "<p><strong>PHP Version:</strong> $phpVersion</p>";
    if (version_compare($phpVersion, '7.4.0', '<')) {
        $errors[] = "PHP 7.4+ required. Current: $phpVersion";
    }
    
    // Check extensions
    $required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json'];
    echo "<p><strong>Extensions:</strong></p><ul>";
    foreach ($required as $ext) {
        $loaded = extension_loaded($ext);
        echo "<li>" . ($loaded ? '✅' : '❌') . " $ext</li>";
        if (!$loaded) {
            $errors[] = "Extension '$ext' required";
        }
    }
    echo "</ul>";
    
    // Check files
    echo "<p><strong>Files:</strong></p><ul>";
    $files = ['.env' => 'Environment config'];
    foreach ($files as $file => $desc) {
        $exists = file_exists(__DIR__ . '/' . $file);
        echo "<li>" . ($exists ? '✅' : '❌') . " $file</li>";
        if (!$exists && $file === '.env') {
            if (file_exists(__DIR__ . '/.env.production')) {
                echo "<li>🔄 Found .env.production - will copy to .env</li>";
            }
        }
    }
    echo "</ul>";
    
    echo "</div>";
    
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'>";
        echo "<h4>❌ Critical Errors:</h4><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></div>";
        return false;
    }
    
    return true;
}

// Start installation
if (!checkRequirements()) {
    echo "<div class='alert alert-danger'>";
    echo "<h3>Cannot Continue</h3>";
    echo "<p>Fix errors above and try again.</p>";
    echo "</div></div></body></html>";
    exit;
}

echo "<div class='alert alert-success'>";
echo "<h3>✅ Requirements Met</h3>";
echo "<p>Starting installation...</p>";
echo "</div>";

// Step 1: Directory Setup
echo "<h2>Step 1: Directory Setup</h2>";
$dirs = ['storage/app/public', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    if (!is_dir(__DIR__ . '/' . $dir)) {
        mkdir(__DIR__ . '/' . $dir, 0755, true);
        echo "<p class='success'>✅ Created: $dir</p>";
    }
}

echo "<h3>Setting Permissions</h3>";
echo "<pre>" . htmlspecialchars(setPermissionsManually()) . "</pre>";

// Step 2: Environment
echo "<h2>Step 2: Environment Setup</h2>";
if (file_exists(__DIR__ . '/.env.production') && !file_exists(__DIR__ . '/.env')) {
    copy(__DIR__ . '/.env.production', __DIR__ . '/.env');
    echo "<p class='success'>✅ Copied .env.production to .env</p>";
}

// Step 3-8: Run all Laravel setup
echo "<h2>Step 3: Generate App Key</h2>";
runStep('Generate Key', 'php artisan key:generate --force');

echo "<h2>Step 4: Clear Caches</h2>";
runStep('Clear Config', 'php artisan config:clear');
runStep('Clear Cache', 'php artisan cache:clear');
runStep('Clear Views', 'php artisan view:clear');
runStep('Clear Routes', 'php artisan route:clear');

echo "<h2>Step 5: Database Setup</h2>";
runStep('Run Migrations', 'php artisan migrate --force');
runStep('Create Admin', 'php artisan db:seed --class=AdminUserSeeder');

// Final message
echo "<div class='alert alert-success'>";
echo "<h2>🎉 Installation Complete!</h2>";
echo "<p><strong>Finished:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li><strong>DELETE THIS FILE NOW!</strong></li>";
echo "<li>Test: <a href='index.php'>Visit Homepage</a></li>";
echo "<li>Admin: admin@tawasullimo.com / admin123</li>";
echo "</ol>";
echo "</div>";

echo "<div class='alert alert-danger'>";
echo "<h3>🔒 SECURITY WARNING</h3>";
echo "<p><strong>DELETE install-cpanel.php NOW!</strong></p>";
echo "</div>";

echo "</div></body></html>";
?>