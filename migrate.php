<?php
/**
 * Database Migration Script for cPanel
 * This script specifically handles database migrations
 * 
 * IMPORTANT: Delete this file after migrations are complete
 */

// Prevent direct access from web
if (!isset($_GET['run'])) {
    die('Access denied. Add ?run=migrate to the URL to execute.');
}

echo "<h1>Tawasul Limousine - Database Migration Script</h1>";
echo "<hr>";

// Function to run artisan commands
function runCommand($command, $description) {
    echo "<h3>$description</h3>";
    echo "<p>Running: <code>$command</code></p>";
    
    // Change to the correct directory and run command
    $output = shell_exec("cd " . __DIR__ . " && $command 2>&1");
    
    echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>";
    echo htmlspecialchars($output);
    echo "</pre>";
    echo "<hr>";
    
    return $output;
}

// Function to check database connection
function checkDatabaseConnection() {
    echo "<h3>Database Connection Test</h3>";
    
    try {
        // Load .env file
        $envPath = __DIR__ . '/.env';
        if (!file_exists($envPath)) {
            echo "<p style='color: red;'>❌ .env file not found. Please rename .env.production to .env first.</p>";
            return false;
        }
        
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
        
        echo "<p>Attempting to connect to:</p>";
        echo "<ul>";
        echo "<li>Host: <code>$host</code></li>";
        echo "<li>Database: <code>$dbname</code></li>";
        echo "<li>Username: <code>$username</code></li>";
        echo "</ul>";
        
        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<p style='color: green;'>✅ Database connection successful!</p>";
        
        // Check existing tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "<p>Existing tables (" . count($tables) . "): <code>" . implode(', ', $tables) . "</code></p>";
        } else {
            echo "<p>No existing tables found. Ready for migrations.</p>";
        }
        
        echo "<hr>";
        return true;
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Common issues:</strong></p>";
        echo "<ul>";
        echo "<li>Database name doesn't exist</li>";
        echo "<li>Wrong username or password</li>";
        echo "<li>Database server not accessible</li>";
        echo "</ul>";
        echo "<hr>";
        return false;
    }
}

// Function to show migration files
function showMigrationFiles() {
    echo "<h3>Available Migration Files</h3>";
    
    $migrationPath = __DIR__ . '/database/migrations';
    if (is_dir($migrationPath)) {
        $files = scandir($migrationPath);
        $migrationFiles = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });
        
        if (count($migrationFiles) > 0) {
            echo "<p>Found " . count($migrationFiles) . " migration files:</p>";
            echo "<ul>";
            foreach ($migrationFiles as $file) {
                echo "<li><code>$file</code></li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>❌ No migration files found!</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Migration directory not found!</p>";
    }
    echo "<hr>";
}

echo "<p><strong>Migration Started:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// 1. Check if we have the required files
if (!file_exists(__DIR__ . '/artisan')) {
    echo "<p style='color: red;'>❌ Laravel artisan file not found. Make sure you're in the correct directory.</p>";
    exit;
}

// 2. Check database connection
if (!checkDatabaseConnection()) {
    echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px;'>";
    echo "<h3>Cannot proceed with migrations</h3>";
    echo "<p>Please fix the database connection issues above before running migrations.</p>";
    echo "</div>";
    exit;
}

// 3. Show available migrations
showMigrationFiles();

// 4. Check migration status
runCommand('php artisan migrate:status', 'Check Migration Status');

// 5. Run migrations
echo "<div style='background: #e6f3ff; padding: 15px; border-radius: 5px;'>";
echo "<h3>Running Database Migrations</h3>";
echo "<p>This will create the necessary database tables for your application.</p>";
echo "</div>";

runCommand('php artisan migrate --force', 'Run Database Migrations');

// 6. Check final status
runCommand('php artisan migrate:status', 'Final Migration Status');

// 7. Show created tables
echo "<h3>Verifying Database Tables</h3>";
try {
    $envPath = __DIR__ . '/.env';
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
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<p style='color: green;'>✅ Successfully created " . count($tables) . " tables:</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li><code>$table</code></li>";
        }
        echo "</ul>";
        
        // Check if important tables exist
        $requiredTables = ['users', 'bookings'];
        $missingTables = array_diff($requiredTables, $tables);
        
        if (empty($missingTables)) {
            echo "<p style='color: green;'>✅ All required tables are present!</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Missing tables: " . implode(', ', $missingTables) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ No tables found after migration!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error checking tables: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2 style='color: green;'>✅ Migration Process Complete!</h2>";
echo "<p><strong>Migration Finished:</strong> " . date('Y-m-d H:i:s') . "</p>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; border-left: 4px solid #ff0000;'>";
echo "<h3 style='color: #cc0000; margin-top: 0;'>🔒 SECURITY NOTICE</h3>";
echo "<p><strong>DELETE THIS FILE (migrate.php) AFTER MIGRATIONS ARE COMPLETE!</strong></p>";
echo "<p>This file should not remain on your production server.</p>";
echo "</div>";

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>✅ <strong>Delete this migrate.php file</strong></li>";
echo "<li>Run the main <a href='setup.php?run=setup'>setup.php</a> script</li>";
echo "<li>Test your website functionality</li>";
echo "</ol>";

?>