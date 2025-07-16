<?php
/**
 * Tawasul Limousine - Server Deployment Script
 * This script handles the deployment process on the server
 */

echo "🚀 Starting Tawasul Limousine Deployment...\n";

// Step 1: Check PHP version
echo "📋 Checking PHP version...\n";
$phpVersion = PHP_VERSION;
echo "Current PHP version: $phpVersion\n";

if (version_compare($phpVersion, '8.2.0', '<')) {
    echo "❌ ERROR: PHP 8.2 or higher is required. Current version: $phpVersion\n";
    exit(1);
}

// Step 2: Check required extensions
echo "📋 Checking required PHP extensions...\n";
$requiredExtensions = [
    'pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'
];

foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        echo "❌ ERROR: PHP extension '$ext' is required but not installed.\n";
        exit(1);
    }
}
echo "✅ All required PHP extensions are installed.\n";

// Step 3: Set up environment file
echo "📋 Setting up environment file...\n";
if (file_exists('.env.production')) {
    if (file_exists('.env')) {
        copy('.env', '.env.backup');
        echo "📄 Backed up existing .env file\n";
    }
    copy('.env.production', '.env');
    echo "✅ Production environment file copied to .env\n";
} else {
    echo "❌ ERROR: .env.production file not found!\n";
    exit(1);
}

// Step 4: Install dependencies
echo "📋 Installing Composer dependencies...\n";
exec('composer install --no-dev --optimize-autoloader', $output, $return);
if ($return !== 0) {
    echo "❌ ERROR: Composer install failed\n";
    exit(1);
}
echo "✅ Composer dependencies installed\n";

// Step 5: Generate application key if needed
echo "📋 Checking application key...\n";
if (empty($_ENV['APP_KEY'])) {
    exec('php artisan key:generate --force', $output, $return);
    if ($return !== 0) {
        echo "❌ ERROR: Failed to generate application key\n";
        exit(1);
    }
    echo "✅ Application key generated\n";
} else {
    echo "✅ Application key already exists\n";
}

// Step 6: Set up database
echo "📋 Setting up database...\n";
exec('php artisan migrate --force', $output, $return);
if ($return !== 0) {
    echo "❌ ERROR: Database migration failed\n";
    exit(1);
}
echo "✅ Database migrations completed\n";

// Step 7: Seed admin user
echo "📋 Creating admin user...\n";
exec('php artisan db:seed --class=AdminUserSeeder --force', $output, $return);
if ($return !== 0) {
    echo "⚠️  Warning: Admin user seeding failed (may already exist)\n";
} else {
    echo "✅ Admin user created\n";
}

// Step 8: Optimize application
echo "📋 Optimizing application...\n";
exec('php artisan config:cache', $output, $return);
exec('php artisan route:cache', $output, $return);
exec('php artisan view:cache', $output, $return);
echo "✅ Application optimized\n";

// Step 9: Set permissions
echo "📋 Setting permissions...\n";
exec('chmod -R 755 storage', $output, $return);
exec('chmod -R 755 bootstrap/cache', $output, $return);
echo "✅ Permissions set\n";

echo "🎉 Deployment completed successfully!\n";
echo "\n📝 Next steps:\n";
echo "1. Access your website at: https://cr8v.com/tawasullemo\n";
echo "2. Login to admin panel at: /admin/dashboard\n";
echo "3. Admin credentials: admin@tawasullimo.com / admin123\n";
echo "4. Configure your Google Maps API key in the .env file\n";
echo "5. Set up your email SMTP settings in the .env file\n";
echo "\n✅ Deployment complete!\n";
?>