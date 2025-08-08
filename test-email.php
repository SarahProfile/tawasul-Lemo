<?php
/**
 * Manual Email Test Script
 * 
 * Usage: php test-email.php
 * 
 * This script tests if emails can be sent to support@tawasullimo.ae
 * 
 * IMPORTANT: Delete this file after testing for security
 */

// Prevent web access
if (isset($_SERVER['HTTP_HOST'])) {
    die('This script can only be run from command line for security reasons.');
}

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
use App\Mail\BookingNotification;

echo "=== Tawasul Limousine Email Test ===\n";
echo "Testing email functionality...\n\n";

try {
    // Test 1: Check email configuration
    echo "1. Checking email configuration...\n";
    $mailConfig = config('mail');
    echo "   Default mailer: " . $mailConfig['default'] . "\n";
    echo "   SMTP Host: " . $mailConfig['mailers']['smtp']['host'] . "\n";
    echo "   SMTP Port: " . $mailConfig['mailers']['smtp']['port'] . "\n";
    echo "   From Address: " . $mailConfig['from']['address'] . "\n";
    echo "   From Name: " . $mailConfig['from']['name'] . "\n\n";

    // Test 2: Create a test booking
    echo "2. Creating test booking...\n";
    $testBooking = new Booking([
        'id' => 999,
        'city' => 'Dubai',
        'date' => date('Y-m-d', strtotime('+1 day')),
        'time' => '14:30',
        'pickup_location' => 'Dubai Mall (Test)',
        'dropoff_location' => 'Burj Khalifa (Test)',
        'customer_name' => 'Test Customer',
        'customer_email' => 'test@example.com',
        'customer_phone' => '+971501234567'
    ]);
    echo "   Test booking created\n\n";

    // Test 3: Send test email
    echo "3. Sending test email to support@tawasullimo.ae...\n";
    
    Mail::to('support@tawasullimo.ae')->send(new BookingNotification($testBooking));
    
    echo "   ✅ Email sent successfully!\n";
    echo "   Check support@tawasullimo.ae inbox for the test email\n\n";

    // Test 4: Additional email validation
    echo "4. Running additional checks...\n";
    
    // Check if email template exists
    $templatePath = resource_path('views/emails/booking-notification.blade.php');
    if (file_exists($templatePath)) {
        echo "   ✅ Email template exists\n";
    } else {
        echo "   ❌ Email template missing: $templatePath\n";
    }

    // Check SMTP credentials
    $smtpUsername = config('mail.mailers.smtp.username');
    $smtpPassword = config('mail.mailers.smtp.password');
    
    if (empty($smtpUsername) || empty($smtpPassword)) {
        echo "   ⚠️  SMTP credentials not configured in .env file\n";
        echo "      Make sure MAIL_USERNAME and MAIL_PASSWORD are set\n";
    } else {
        echo "   ✅ SMTP credentials configured\n";
    }

    echo "\n=== Test Complete ===\n";
    echo "If you received the test email, your email system is working correctly!\n";
    echo "If not, check your SMTP settings in the .env file.\n\n";
    
    echo "⚠️  IMPORTANT: Delete this test-email.php file after testing for security.\n";

} catch (Exception $e) {
    echo "❌ Error occurred during email test:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    
    echo "Common solutions:\n";
    echo "- Check your .env file MAIL_* settings\n";
    echo "- Verify SMTP credentials are correct\n";
    echo "- Ensure your hosting provider allows SMTP connections\n";
    echo "- Check if Gmail app passwords are required\n";
}