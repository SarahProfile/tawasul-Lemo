<?php
/**
 * Clear Laravel Cache - Upload this to your server and run it after .env changes
 */

try {
    // Bootstrap Laravel
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "<h2>Clearing Laravel Caches...</h2>";

    // Clear configuration cache
    Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "✓ Configuration cache cleared<br>";

    // Clear application cache
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "✓ Application cache cleared<br>";

    // Cache the configuration again
    Illuminate\Support\Facades\Artisan::call('config:cache');
    echo "✓ Configuration cached<br>";

    echo "<br><strong>✅ All caches cleared successfully!</strong><br>";
    echo "<p>Your .env changes should now be active. Try the email test again.</p>";
    echo "<p><a href='test-server-email.php'>Run Email Test</a></p>";

} catch (Exception $e) {
    echo "<h2 style='color:red'>Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}

// Delete this file after running (security)
echo "<p><strong>Note:</strong> Delete this file after use for security.</p>";
?>