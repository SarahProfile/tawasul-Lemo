<?php
/**
 * Booking Email Test Script for Tawasul Limousine
 * 
 * This script tests the booking email functionality on the live server
 * URL: https://dasholding.ae/tawasullimo/
 * 
 * Usage: Upload this file to the server and access it via browser
 * or run via command line: php test-booking-email.php
 */

// Check if running from command line or web browser
$isCLI = php_sapi_name() === 'cli';

if (!$isCLI) {
    header('Content-Type: text/html; charset=utf-8');
    echo "<!DOCTYPE html><html><head><title>Booking Email Test</title>";
    echo "<style>body{font-family:Arial,sans-serif;margin:40px;} .success{color:green;} .error{color:red;} .info{color:blue;} pre{background:#f5f5f5;padding:15px;border-radius:5px;}</style>";
    echo "</head><body><h1>Booking Email Test Results</h1>";
}

function output($message, $type = 'info') {
    global $isCLI;
    
    $colors = [
        'success' => $isCLI ? "\033[32m" : '<div class="success">',
        'error' => $isCLI ? "\033[31m" : '<div class="error">',
        'info' => $isCLI ? "\033[34m" : '<div class="info">',
    ];
    
    $reset = $isCLI ? "\033[0m" : '</div>';
    
    if ($isCLI) {
        echo $colors[$type] . $message . $reset . "\n";
    } else {
        echo $colors[$type] . htmlspecialchars($message) . $reset . "<br>\n";
    }
}

function testBookingEmailSystem() {
    output("=== Booking Email System Test ===", 'info');
    output("Testing on server: https://dasholding.ae/tawasullimo/", 'info');
    output("Date: " . date('Y-m-d H:i:s'), 'info');
    output("", 'info');
    
    // Test 1: Check if required files exist
    output("1. Checking required files...", 'info');
    
    $requiredFiles = [
        'app/Http/Controllers/BookingController.php',
        'app/Mail/BookingNotification.php',
        'resources/views/emails/booking-notification.blade.php',
        '.env'
    ];
    
    foreach ($requiredFiles as $file) {
        if (file_exists($file)) {
            output("✓ Found: $file", 'success');
        } else {
            output("✗ Missing: $file", 'error');
        }
    }
    
    output("", 'info');
    
    // Test 2: Check email configuration
    output("2. Checking email configuration...", 'info');
    
    if (file_exists('.env')) {
        $envContent = file_get_contents('.env');
        
        $emailConfigs = [
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => 'smtp.gmail.com',
            'MAIL_PORT' => '587',
            'MAIL_USERNAME' => '',
            'MAIL_PASSWORD' => '',
            'MAIL_ENCRYPTION' => 'tls',
            'MAIL_FROM_ADDRESS' => 'noreply@tawasullimo.ae',
            'MAIL_FROM_NAME' => 'Tawasul Limousine'
        ];
        
        foreach ($emailConfigs as $key => $expectedValue) {
            if (preg_match("/^$key=(.*)$/m", $envContent, $matches)) {
                $value = trim($matches[1], '"\'');
                if ($key === 'MAIL_USERNAME' || $key === 'MAIL_PASSWORD') {
                    $displayValue = $value ? '[CONFIGURED]' : '[NOT SET]';
                } else {
                    $displayValue = $value ?: '[NOT SET]';
                }
                output("✓ $key = $displayValue", $value ? 'success' : 'error');
            } else {
                output("✗ $key not found in .env", 'error');
            }
        }
    } else {
        output("✗ .env file not found", 'error');
    }
    
    output("", 'info');
    
    // Test 3: Test email sending functionality
    output("3. Testing email sending functionality...", 'info');
    
    // Create test booking data
    $testBookingData = [
        'id' => 'TEST-' . time(),
        'customer_name' => 'Test User',
        'customer_email' => 'test@example.com',
        'customer_phone' => '+971501234567',
        'city' => 'Dubai',
        'date' => date('Y-m-d', strtotime('+1 day')),
        'time' => '14:00',
        'pickup_location' => 'Dubai Mall',
        'dropoff_location' => 'Burj Khalifa',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    output("Test booking data:", 'info');
    if (!$GLOBALS['isCLI']) echo "<pre>";
    print_r($testBookingData);
    if (!$GLOBALS['isCLI']) echo "</pre>";
    
    // Test email template rendering
    output("4. Testing email template...", 'info');
    
    if (file_exists('resources/views/emails/booking-notification.blade.php')) {
        $templateContent = file_get_contents('resources/views/emails/booking-notification.blade.php');
        
        // Check if template contains required variables
        $requiredVars = ['booking->id', 'booking->customer_name', 'booking->customer_email'];
        foreach ($requiredVars as $var) {
            if (strpos($templateContent, $var) !== false) {
                output("✓ Template contains: {{ $var }}", 'success');
            } else {
                output("✗ Template missing: {{ $var }}", 'error');
            }
        }
    }
    
    output("", 'info');
    
    // Test 5: Simulate booking submission
    output("5. Simulating booking submission...", 'info');
    
    $bookingUrl = 'https://dasholding.ae/tawasullimo/booking';
    
    // Create a test POST data
    $postData = [
        'city' => 'Dubai',
        'date' => date('Y-m-d', strtotime('+1 day')),
        'time' => '14:00',
        'pickup_location' => 'Dubai Mall',
        'pickup_lat' => '25.1972',
        'pickup_lng' => '55.2796',
        'dropoff_location' => 'Burj Khalifa',
        'dropoff_lat' => '25.1963',
        'dropoff_lng' => '55.2741',
        'mobile' => '+971501234567',
        'email' => 'test@example.com'
    ];
    
    output("POST data to be sent:", 'info');
    if (!$GLOBALS['isCLI']) echo "<pre>";
    print_r($postData);
    if (!$GLOBALS['isCLI']) echo "</pre>";
    
    // Instructions for manual testing
    output("", 'info');
    output("=== MANUAL TESTING INSTRUCTIONS ===", 'info');
    output("To test the booking email system manually:", 'info');
    output("", 'info');
    output("1. Go to: https://dasholding.ae/tawasullimo/", 'info');
    output("2. Fill out the booking form with test data", 'info');
    output("3. Submit the form", 'info');
    output("4. Check the support@tawasullimo.ae email inbox", 'info');
    output("5. Verify that the booking notification email was received", 'info');
    output("", 'info');
    
    // Test with curl if available
    if (function_exists('curl_init')) {
        output("6. Testing with CURL...", 'info');
        
        // Get CSRF token first
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dasholding.ae/tawasullimo/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Booking Email Test Script');
        
        $homepage = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        output("Homepage HTTP Code: $httpCode", $httpCode == 200 ? 'success' : 'error');
        
        if ($httpCode == 200) {
            // Try to extract CSRF token
            if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $homepage, $matches)) {
                $csrfToken = $matches[1];
                output("✓ CSRF token found: " . substr($csrfToken, 0, 10) . "...", 'success');
                
                // Test booking endpoint
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $bookingUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-CSRF-TOKEN: ' . $csrfToken,
                    'Content-Type: application/x-www-form-urlencoded',
                    'X-Requested-With: XMLHttpRequest'
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                output("Booking submission HTTP Code: $httpCode", 'info');
                output("Response: " . substr($response, 0, 200) . "...", 'info');
                
            } else {
                output("✗ CSRF token not found", 'error');
            }
        }
    } else {
        output("CURL not available for automated testing", 'error');
    }
    
    output("", 'info');
    output("=== EMAIL DEBUGGING TIPS ===", 'info');
    output("If emails are not being sent, check:", 'info');
    output("1. Laravel logs: storage/logs/laravel.log", 'info');
    output("2. Server email logs", 'info');
    output("3. Gmail/SMTP settings in .env file", 'info');
    output("4. Check spam folder", 'info');
    output("5. Verify support@tawasullimo.ae email exists", 'info');
    output("", 'info');
    
    output("=== TEST COMPLETED ===", 'success');
    output("If you received a booking notification email at support@tawasullimo.ae, the system is working correctly!", 'success');
}

// Run the test
testBookingEmailSystem();

if (!$isCLI) {
    echo "</body></html>";
}
?>