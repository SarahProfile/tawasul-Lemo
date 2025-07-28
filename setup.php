<?php
/**
 * Laravel Setup Script for cPanel
 * This script runs essential artisan commands for deployment
 * 
 * IMPORTANT: Delete this file after setup is complete for security
 */

// Prevent direct access from web
if (!isset($_GET['run'])) {
    die('Access denied. Add ?run=setup to the URL to execute.');
}

echo "<h1>Tawasul Limousine - Laravel Setup Script</h1>";
echo "<hr>";

// Function to run artisan commands
function runArtisan($command, $description) {
    echo "<h3>$description</h3>";
    echo "<p>Running: <code>php artisan $command</code></p>";
    
    // Change to the correct directory
    $output = shell_exec("cd " . __DIR__ . " && php artisan $command 2>&1");
    
    echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($output);
    echo "</pre>";
    echo "<hr>";
}

// Function to check file permissions
function checkPermissions($path, $description) {
    echo "<h3>Checking: $description</h3>";
    $fullPath = __DIR__ . '/' . $path;
    
    if (is_dir($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $writable = is_writable($fullPath) ? 'YES' : 'NO';
        echo "<p>Path: <code>$path</code></p>";
        echo "<p>Permissions: <code>$perms</code></p>";
        echo "<p>Writable: <strong style='color: " . ($writable == 'YES' ? 'green' : 'red') . "'>$writable</strong></p>";
        
        if ($writable == 'NO') {
            echo "<p style='color: red;'>⚠️ This directory needs to be writable. Set permissions to 755 or 777.</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Directory does not exist: $path</p>";
    }
    echo "<hr>";
}

// Function to check environment
function checkEnvironment() {
    echo "<h3>Environment Check</h3>";
    
    // Check if .env exists
    $envPath = __DIR__ . '/.env';
    if (file_exists($envPath)) {
        echo "<p>✅ .env file exists</p>";
        
        // Read database config
        $envContent = file_get_contents($envPath);
        preg_match('/DB_DATABASE=(.+)/', $envContent, $dbName);
        preg_match('/DB_USERNAME=(.+)/', $envContent, $dbUser);
        
        if ($dbName && $dbUser) {
            echo "<p>✅ Database configuration found</p>";
            echo "<p>Database: <code>" . trim($dbName[1]) . "</code></p>";
            echo "<p>Username: <code>" . trim($dbUser[1]) . "</code></p>";
        }
    } else {
        echo "<p style='color: red;'>❌ .env file not found. Rename .env.production to .env</p>";
    }
    
    // Check PHP version
    echo "<p>PHP Version: <code>" . phpversion() . "</code></p>";
    
    // Check required extensions
    $extensions = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json'];
    echo "<p>Required PHP Extensions:</p><ul>";
    foreach ($extensions as $ext) {
        $loaded = extension_loaded($ext) ? '✅' : '❌';
        echo "<li>$loaded $ext</li>";
    }
    echo "</ul>";
    echo "<hr>";
}

// Function to test database connection
function testDatabase() {
    echo "<h3>Database Connection Test</h3>";
    
    try {
        // Load .env file
        $envPath = __DIR__ . '/.env';
        if (!file_exists($envPath)) {
            echo "<p style='color: red;'>❌ .env file not found</p>";
            return;
        }
        
        $envContent = file_get_contents($envPath);
        $envLines = explode("\n", $envContent);
        $config = [];
        
        foreach ($envLines as $line) {
            if (strpos($line, '=') !== false && !strpos($line, '#') === 0) {
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
        
        echo "<p>✅ Database connection successful!</p>";
        echo "<p>Connected to: <code>$dbname</code> on <code>$host</code></p>";
        
        // Check if tables exist
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "<p>✅ Found " . count($tables) . " tables in database</p>";
            echo "<p>Tables: <code>" . implode(', ', $tables) . "</code></p>";
        } else {
            echo "<p>⚠️ No tables found. You may need to run migrations.</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "<hr>";
}

echo "<p><strong>Setup Started:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// 1. Environment Check
checkEnvironment();

// 2. Check Permissions
checkPermissions('storage', 'Storage Directory');
checkPermissions('storage/app', 'Storage App Directory');
checkPermissions('storage/framework', 'Storage Framework Directory');
checkPermissions('storage/logs', 'Storage Logs Directory');
checkPermissions('bootstrap/cache', 'Bootstrap Cache Directory');

// 3. Test Database Connection
testDatabase();

// 4. Generate Application Key (if needed)
runArtisan('key:generate --force', 'Generate Application Key');

// 5. Clear All Cache
runArtisan('config:clear', 'Clear Configuration Cache');
runArtisan('cache:clear', 'Clear Application Cache');
runArtisan('view:clear', 'Clear View Cache');
runArtisan('route:clear', 'Clear Route Cache');

// 6. Run Database Migrations
runArtisan('migrate --force', 'Run Database Migrations');

// 7. Cache Configuration for Production
runArtisan('config:cache', 'Cache Configuration');
runArtisan('route:cache', 'Cache Routes');
runArtisan('view:cache', 'Cache Views');

echo "<h2 style='color: green;'>✅ Setup Complete!</h2>";
echo "<p><strong>Setup Finished:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; border-left: 4px solid #ff0000;'>";
echo "<h3 style='color: #cc0000; margin-top: 0;'>🔒 IMPORTANT SECURITY NOTICE</h3>";
echo "<p><strong>DELETE THIS FILE IMMEDIATELY AFTER SETUP!</strong></p>";
echo "<p>This setup.php file contains sensitive operations and should not remain on your server.</p>";
echo "<p>Remove it from your server now for security.</p>";
echo "</div>";

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>✅ <strong>Delete this setup.php file</strong></li>";
echo "<li>Test your website: <a href='index.php'>Visit Homepage</a></li>";
echo "<li>Test the booking form</li>";
echo "<li>Verify Google Maps is working</li>";
echo "<li>Configure email settings if needed</li>";
echo "</ol>";

?>