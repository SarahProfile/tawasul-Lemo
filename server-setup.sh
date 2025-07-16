#!/bin/bash

# Tawasul Limousine - Server Setup Script
# Run this script on your server after uploading the files

echo "🚀 Tawasul Limousine Server Setup"
echo "================================"

# Check if running as root
if [[ $EUID -eq 0 ]]; then
   echo "❌ This script should not be run as root for security reasons"
   exit 1
fi

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Check for required commands
echo "📋 Checking system requirements..."

if ! command_exists php; then
    echo "❌ PHP is not installed. Please install PHP 8.2 or higher."
    exit 1
fi

if ! command_exists composer; then
    echo "❌ Composer is not installed. Please install Composer."
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "✅ PHP version: $PHP_VERSION"

# Set proper permissions
echo "📋 Setting file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create necessary directories if they don't exist
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

echo "✅ Permissions set correctly"

# Install dependencies
echo "📋 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Run deployment script
echo "📋 Running deployment script..."
php deploy.php

echo "🎉 Server setup completed!"
echo ""
echo "📝 Important Notes:"
echo "1. Make sure your web server points to the 'public' directory"
echo "2. Update your .env file with correct database credentials"
echo "3. Configure your Google Maps API key"
echo "4. Set up SSL certificate for HTTPS"
echo "5. Test the admin panel: /admin/dashboard"
echo ""
echo "✅ Setup complete!"