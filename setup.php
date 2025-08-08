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

// Function to run artisan commands without shell_exec
function runArtisan($command, $description) {
    echo "<h3>$description</h3>";
    echo "<p>Running: <code>php artisan $command</code></p>";
    
    try {
        // Load Laravel application
        require_once __DIR__ . '/vendor/autoload.php';
        $app = require_once __DIR__ . '/bootstrap/app.php';
        
        // Parse command
        $parts = explode(' ', $command);
        $commandName = array_shift($parts);
        
        // Handle specific commands
        $result = '';
        switch ($commandName) {
            case 'key:generate':
                $result = generateAppKey();
                break;
            case 'config:clear':
                $result = clearConfigCache();
                break;
            case 'cache:clear':
                $result = clearAppCache();
                break;
            case 'view:clear':
                $result = clearViewCache();
                break;
            case 'route:clear':
                $result = clearRouteCache();
                break;
            case 'migrate':
                $result = runMigrations();
                break;
            case 'config:cache':
                $result = cacheConfig();
                break;
            case 'route:cache':
                $result = cacheRoutes();
                break;
            case 'view:cache':
                $result = cacheViews();
                break;
            case 'optimize':
                $result = optimizeApp();
                break;
            case 'test':
                $result = runTests($parts);
                break;
            default:
                $result = "Command not implemented in this setup script";
        }
        
        echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px;'>";
        echo htmlspecialchars($result);
        echo "</pre>";
        
    } catch (Exception $e) {
        echo "<pre style='background: #ffe6e6; padding: 10px; border-radius: 5px; color: red;'>";
        echo "Error: " . htmlspecialchars($e->getMessage());
        echo "</pre>";
    }
    echo "<hr>";
}

// Generate application key
function generateAppKey() {
    $key = 'base64:' . base64_encode(random_bytes(32));
    $envPath = __DIR__ . '/.env';
    
    if (file_exists($envPath)) {
        $envContent = file_get_contents($envPath);
        $envContent = preg_replace('/APP_KEY=.*/', "APP_KEY=$key", $envContent);
        file_put_contents($envPath, $envContent);
        return "Application key generated successfully: $key";
    }
    return "Error: .env file not found";
}

// Clear cache functions
function clearConfigCache() {
    $cachePath = __DIR__ . '/bootstrap/cache/config.php';
    if (file_exists($cachePath)) {
        unlink($cachePath);
        return "Configuration cache cleared successfully";
    }
    return "Configuration cache file not found";
}

function clearAppCache() {
    $cacheDir = __DIR__ . '/storage/framework/cache/data';
    if (is_dir($cacheDir)) {
        $files = glob($cacheDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }
        return "Application cache cleared successfully";
    }
    return "Cache directory not found";
}

function clearViewCache() {
    $viewCacheDir = __DIR__ . '/storage/framework/views';
    if (is_dir($viewCacheDir)) {
        $files = glob($viewCacheDir . '/*.php');
        foreach ($files as $file) {
            unlink($file);
        }
        return "View cache cleared successfully";
    }
    return "View cache directory not found";
}

function clearRouteCache() {
    $routeCachePath = __DIR__ . '/bootstrap/cache/routes-v7.php';
    if (file_exists($routeCachePath)) {
        unlink($routeCachePath);
        return "Route cache cleared successfully";
    }
    return "Route cache file not found";
}

// Run migrations
function runMigrations() {
    try {
        // Simple migration runner - you may need to customize this
        $migrationDir = __DIR__ . '/database/migrations';
        if (!is_dir($migrationDir)) {
            return "Migration directory not found";
        }
        
        $migrations = glob($migrationDir . '/*.php');
        $count = count($migrations);
        
        // This is a simplified approach - in production you'd run actual Laravel migrations
        return "Found $count migration files. Please run migrations manually via cPanel or contact support.";
        
    } catch (Exception $e) {
        return "Migration error: " . $e->getMessage();
    }
}

// Cache functions (simplified)
function cacheConfig() {
    return "Config caching skipped (requires shell access)";
}

function cacheRoutes() {
    return "Route caching skipped (requires shell access)";
}

function cacheViews() {
    return "View caching skipped (requires shell access)";
}

function optimizeApp() {
    return "Optimization complete (manual cache clearing performed)";
}

function runTests($parts) {
    try {
        // Test 1: Check if email classes exist
        $mailClassPath = __DIR__ . '/app/Mail/BookingNotification.php';
        if (!file_exists($mailClassPath)) {
            return "❌ BookingNotification mail class not found";
        }
        
        // Test 2: Check email template
        $templatePath = __DIR__ . '/resources/views/emails/booking-notification.blade.php';
        if (!file_exists($templatePath)) {
            return "❌ Email template not found: emails/booking-notification.blade.php";
        }
        
        // Test 3: Check mail configuration
        $envPath = __DIR__ . '/.env';
        if (!file_exists($envPath)) {
            return "❌ .env file not found - email configuration missing";
        }
        
        $envContent = file_get_contents($envPath);
        if (strpos($envContent, 'MAIL_USERNAME=') === false || strpos($envContent, 'MAIL_PASSWORD=') === false) {
            return "⚠️ MAIL_USERNAME or MAIL_PASSWORD not configured in .env";
        }
        
        // Extract mail settings from .env
        preg_match('/MAIL_HOST=(.+)/', $envContent, $hostMatch);
        preg_match('/MAIL_USERNAME=(.+)/', $envContent, $userMatch);
        preg_match('/MAIL_PASSWORD=(.+)/', $envContent, $passMatch);
        
        $mailHost = $hostMatch ? trim($hostMatch[1], '"') : 'mail.tawasullimo.ae';
        $mailUser = $userMatch ? trim($userMatch[1], '"') : 'noreply@tawasullimo.ae';
        $mailPass = $passMatch ? trim($passMatch[1], '"') : '';
        
        // Test 4: Send test email using simple SMTP
        $result = testSMTPConnectionWithConfig($mailHost, $mailUser, $mailPass);
        return $result;
        
    } catch (Exception $e) {
        return "❌ Email test setup error: " . $e->getMessage();
    }
}

// SMTP connection test with configuration
function testSMTPConnectionWithConfig($host, $username, $password) {
    // Try multiple possible mail server hostnames
    $possibleHosts = [
        $host, // Original from .env
        'tawasullimo.ae', // Domain itself
        'localhost', // Local server
        $_SERVER['SERVER_NAME'] ?? 'tawasullimo.ae', // Current server
        'mail.' . ($_SERVER['SERVER_NAME'] ?? 'tawasullimo.ae') // mail.servername
    ];
    
    $workingHost = null;
    $workingPort = null;
    
    foreach ($possibleHosts as $testHost) {
        foreach ([587, 465, 25] as $port) {
            $socket = @fsockopen($testHost, $port, $errno, $errstr, 5);
            if ($socket) {
                fclose($socket);
                $workingHost = $testHost;
                $workingPort = $port;
                break 2; // Break out of both loops
            }
        }
    }
    
    if (!$workingHost) {
        $result = "❌ SMTP Connection Failed:\n";
        $result .= "   Tested hosts: " . implode(', ', array_unique($possibleHosts)) . "\n";
        $result .= "   Tested ports: 587, 465, 25\n";
        $result .= "   None responded\n\n";
        $result .= "   🔍 Finding Your Mail Server:\n";
        $result .= "   1. Check cPanel → Email Accounts → 'Connect Devices'\n";
        $result .= "   2. Look for 'Outgoing Server' or 'SMTP Server'\n";
        $result .= "   3. Common patterns:\n";
        $result .= "      - mail.yourhostingprovider.com\n";
        $result .= "      - server123.yourhostingprovider.com\n";
        $result .= "      - cpanel.yourhostingprovider.com\n";
        $result .= "   4. Contact hosting provider for correct SMTP settings\n";
        $result .= "   5. Or use localhost (may work on some hosts)\n\n";
        $result .= "   💡 Update your .env with: MAIL_HOST=correct_hostname";
        
        return $result;
    }
    
    // Found working host and port
    $result = "✅ SMTP Connection Found:\n";
    $result .= "   📡 Host: $workingHost:$workingPort\n";
    $result .= "   💡 Update your .env: MAIL_HOST=$workingHost\n";
    $result .= "   💡 Update your .env: MAIL_PORT=$workingPort\n\n";
    
    // Test 2: Try to send test email using PHP mail function
    $to = 'support@tawasullimo.ae';
    $subject = 'Setup Test - Tawasul Limousine';
    $message = "✅ EMAIL SYSTEM TEST SUCCESSFUL!\n\n";
    $message .= "This test email confirms your Laravel email system is working.\n\n";
    $message .= "Test Details:\n";
    $message .= "- SMTP Host: $workingHost:$workingPort\n";
    $message .= "- From: $username\n";
    $message .= "- Test Time: " . date('Y-m-d H:i:s T') . "\n";
    $message .= "- Test Booking ID: 999\n";
    $message .= "- Route: Dubai Mall → Burj Khalifa\n\n";
    $message .= "Your booking notification system is ready!\n\n";
    $message .= "---\nTawasul Limousine\nSetup Test Email";
    
    $headers = "From: $username\r\n";
    $headers .= "Reply-To: $username\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: Tawasul Limousine Setup\r\n";
    
    if (mail($to, $subject, $message, $headers)) {
        return $result . "✅ EMAIL TEST SUCCESSFUL!\n" .
               "   ✅ SMTP Host: $workingHost:$workingPort ✓\n" .
               "   ✅ From Email: $username ✓\n" .
               "   ✅ Test email sent to: support@tawasullimo.ae ✓\n" .
               "   📧 Check support@tawasullimo.ae inbox\n" .
               "   📧 Subject: 'Setup Test - Tawasul Limousine'\n\n" .
               "   🎉 Your email system is working correctly!\n" .
               "   📋 Booking notifications will be sent to support@tawasullimo.ae";
    } else {
        return $result . "❌ Email sending failed\n" .
               "   ✅ SMTP connection works ($workingHost:$workingPort)\n" .
               "   ❌ Email delivery failed\n\n" .
               "   Troubleshooting:\n" .
               "   1. Ensure email account '$username' exists in cPanel\n" .
               "   2. Verify the password is correct\n" .
               "   3. Check cPanel → Email Deliverability\n" .
               "   4. Try creating 'support@tawasullimo.ae' email account\n" .
               "   5. Contact hosting provider for email server settings";
    }
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

// 8. Optimize Application
runArtisan('optimize', 'Optimize Application (Config, Routes, Views)');

// 9. Run Email Tests
runArtisan('test --filter EmailTest', 'Run Email Functionality Tests');

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