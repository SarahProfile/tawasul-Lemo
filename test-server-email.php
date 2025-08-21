<?php
/**
 * Server Email Test for Tawasul Limousine
 * 
 * This script specifically tests email functionality on the live server
 * URL: https://dasholding.ae/tawasullimo/
 * 
 * Upload this file to your server and access it to test email functionality
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tawasul Limousine - Email Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; }
        .test-section { background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .warning { color: #ffc107; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        pre { background: #e9ecef; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h1>Tawasul Limousine - Email System Test</h1>
    <p><strong>Server:</strong> <?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></p>
    <p><strong>Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>

    <?php
    // Test email configuration
    echo '<div class="test-section">';
    echo '<h2>1. Email Configuration Check</h2>';
    
    $emailConfigs = [
        'MAIL_MAILER' => $_ENV['MAIL_MAILER'] ?? null,
        'MAIL_HOST' => $_ENV['MAIL_HOST'] ?? null,
        'MAIL_PORT' => $_ENV['MAIL_PORT'] ?? null,
        'MAIL_USERNAME' => $_ENV['MAIL_USERNAME'] ?? null,
        'MAIL_PASSWORD' => $_ENV['MAIL_PASSWORD'] ?? null,
        'MAIL_ENCRYPTION' => $_ENV['MAIL_ENCRYPTION'] ?? null,
        'MAIL_FROM_ADDRESS' => $_ENV['MAIL_FROM_ADDRESS'] ?? null,
        'MAIL_FROM_NAME' => $_ENV['MAIL_FROM_NAME'] ?? null,
    ];
    
    echo '<table border="1" cellpadding="10" cellspacing="0" style="width:100%">';
    echo '<tr><th>Configuration</th><th>Value</th><th>Status</th></tr>';
    
    foreach ($emailConfigs as $key => $value) {
        $displayValue = $value;
        if (in_array($key, ['MAIL_USERNAME', 'MAIL_PASSWORD']) && $value) {
            $displayValue = '[CONFIGURED]';
        }
        
        $status = $value ? '<span class="success">✓ Set</span>' : '<span class="error">✗ Not Set</span>';
        echo "<tr><td>$key</td><td>$displayValue</td><td>$status</td></tr>";
    }
    echo '</table>';
    echo '</div>';
    
    // Test SMTP connection
    echo '<div class="test-section">';
    echo '<h2>2. SMTP Connection Test</h2>';
    
    if (function_exists('fsockopen') && $_ENV['MAIL_HOST'] ?? null) {
        $host = $_ENV['MAIL_HOST'];
        $port = $_ENV['MAIL_PORT'] ?? 587;
        
        $connection = @fsockopen($host, $port, $errno, $errstr, 10);
        if ($connection) {
            echo '<span class="success">✓ Successfully connected to ' . $host . ':' . $port . '</span>';
            fclose($connection);
        } else {
            echo '<span class="error">✗ Failed to connect to ' . $host . ':' . $port . ' - ' . $errstr . '</span>';
        }
    } else {
        echo '<span class="warning">⚠ Cannot test SMTP connection (fsockopen not available or MAIL_HOST not set)</span>';
    }
    echo '</div>';
    
    // Test email sending
    if (isset($_POST['test_email'])) {
        echo '<div class="test-section">';
        echo '<h2>3. Email Sending Test Result</h2>';
        
        try {
            // Bootstrap Laravel
            $app = require_once __DIR__ . '/bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
            
            // Create test booking data using the Booking model
            $testBooking = new App\Models\Booking([
                'customer_name' => 'Test Customer',
                'customer_email' => $_POST['test_email_address'] ?? 'test@example.com',
                'customer_phone' => '+971501234567',
                'city' => 'Dubai',
                'date' => now()->addDay()->format('Y-m-d'),
                'time' => now()->addHours(2)->format('H:i'),
                'pickup_location' => 'Dubai Mall (Test)',
                'pickup_lat' => 25.1972,
                'pickup_lng' => 55.2796,
                'dropoff_location' => 'Burj Khalifa (Test)',
                'dropoff_lat' => 25.1963,
                'dropoff_lng' => 55.2741,
            ]);
            
            // Set the ID manually for testing (don't save to database)
            $testBooking->id = 'TEST-' . time();
            $testBooking->created_at = now();
            
            // Send test email
            $mail = new App\Mail\BookingNotification($testBooking);
            Illuminate\Support\Facades\Mail::to('support@tawasullimo.ae')->send($mail);
            
            echo '<span class="success">✓ Test email sent successfully to support@tawasullimo.ae</span>';
            echo '<p>Check the support email inbox for the test booking notification.</p>';
            
        } catch (Exception $e) {
            echo '<span class="error">✗ Failed to send test email: ' . $e->getMessage() . '</span>';
        }
        echo '</div>';
    }
    
    // Email test form
    echo '<div class="test-section">';
    echo '<h2>3. Send Test Email</h2>';
    echo '<form method="POST" action="">';
    echo '<p>Send a test booking notification email to support@tawasullimo.ae:</p>';
    echo '<input type="hidden" name="test_email" value="1">';
    echo '<label>Your email (optional): <input type="email" name="test_email_address" placeholder="your-email@example.com"></label><br><br>';
    echo '<button type="submit" class="btn">Send Test Email</button>';
    echo '</form>';
    echo '</div>';
    
    // Manual booking test
    echo '<div class="test-section">';
    echo '<h2>4. Manual Booking Test</h2>';
    echo '<p>To test the complete booking flow:</p>';
    echo '<ol>';
    echo '<li>Go to <a href="/" target="_blank">the main website</a></li>';
    echo '<li>Fill out the booking form with test data:</li>';
    echo '<ul>';
    echo '<li><strong>City:</strong> Dubai</li>';
    echo '<li><strong>Date:</strong> ' . date('Y-m-d', strtotime('+1 day')) . '</li>';
    echo '<li><strong>Time:</strong> 14:00</li>';
    echo '<li><strong>Pickup:</strong> Dubai Mall</li>';
    echo '<li><strong>Drop-off:</strong> Burj Khalifa</li>';
    echo '<li><strong>Mobile:</strong> +971501234567</li>';
    echo '<li><strong>Email:</strong> test@example.com</li>';
    echo '</ul>';
    echo '<li>Submit the form</li>';
    echo '<li>Check the <strong>support@tawasullimo.ae</strong> email inbox</li>';
    echo '<li>Verify the booking notification email was received</li>';
    echo '</ol>';
    echo '</div>';
    
    // Debug information
    echo '<div class="test-section">';
    echo '<h2>5. Debug Information</h2>';
    echo '<h3>Server Information:</h3>';
    echo '<pre>';
    echo 'PHP Version: ' . PHP_VERSION . "\n";
    echo 'Server Software: ' . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
    echo 'Document Root: ' . $_SERVER['DOCUMENT_ROOT'] . "\n";
    echo 'Current Directory: ' . __DIR__ . "\n";
    echo 'Mail Function Available: ' . (function_exists('mail') ? 'Yes' : 'No') . "\n";
    echo 'OpenSSL Available: ' . (extension_loaded('openssl') ? 'Yes' : 'No') . "\n";
    echo '</pre>';
    
    echo '<h3>Laravel Log Files (if accessible):</h3>';
    $logPath = __DIR__ . '/storage/logs/laravel.log';
    if (file_exists($logPath)) {
        $logContent = file_get_contents($logPath);
        $lines = explode("\n", $logContent);
        $recentLines = array_slice($lines, -20); // Last 20 lines
        echo '<pre>' . htmlspecialchars(implode("\n", $recentLines)) . '</pre>';
    } else {
        echo '<p class="warning">⚠ Log file not accessible at: ' . $logPath . '</p>';
    }
    echo '</div>';
    ?>
    
    <div class="test-section">
        <h2>6. Expected Email Content</h2>
        <p>When a booking is submitted, an email should be sent to <strong>support@tawasullimo.ae</strong> with:</p>
        <ul>
            <li>Subject: "New Booking Request - Tawasul Limousine"</li>
            <li>Booking ID</li>
            <li>Customer details (name, email, phone)</li>
            <li>Trip details (city, date, time, pickup/dropoff locations)</li>
            <li>Submission timestamp</li>
        </ul>
        <p><strong>Important:</strong> Check the spam/junk folder if the email doesn't appear in the inbox.</p>
    </div>
    
</div>
</body>
</html>