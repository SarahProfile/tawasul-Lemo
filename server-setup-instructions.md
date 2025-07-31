# Server Setup Instructions

## Error Fix: storage/framework/views directory issue

If you're getting the error:
```
file_put_contents(/path/to/storage/framework/views/xxx.php): Failed to open stream: No such file or directory
```

Follow these steps:

### Step 1: Upload the fix script
1. Make sure `fix-storage-permissions.php` is uploaded to your server root directory
2. Run it via command line or browser

### Step 2: Run the fix script

**Via Command Line (SSH):**
```bash
cd /path/to/your/laravel/project
php fix-storage-permissions.php
```

**Via Browser:**
Go to: `http://yourdomain.com/fix-storage-permissions.php`

### Step 3: Run Laravel commands
After running the fix script, execute these commands:

```bash
# Clear and cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views (this will create the missing view cache files)
php artisan view:cache

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed
```

### Step 4: Set proper file permissions (if needed)
If you're still having issues, set these permissions via SSH or cPanel File Manager:

```bash
# Set directory permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/

# Set file permissions
find storage/ -type f -exec chmod 644 {} \;
find bootstrap/cache/ -type f -exec chmod 644 {} \;
```

### Step 5: Alternative manual fix
If the script doesn't work, manually create these directories:

```
storage/
├── app/
│   └── public/
├── framework/
│   ├── cache/
│   │   └── data/
│   ├── sessions/
│   ├── testing/
│   └── views/
└── logs/
```

### Step 6: Environment file
Make sure your `.env` file has the correct database settings and APP_URL:

```env
APP_URL=http://yourdomain.com
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Common Issues:

1. **Permission denied**: Contact your hosting provider to ensure PHP can write to storage directories
2. **Symlink not working**: Some shared hosts disable symlinks - use the file manager to create the link manually
3. **Database connection**: Ensure your database credentials are correct in `.env`

### After setup:
- Delete `fix-storage-permissions.php` from your server for security
- Your Laravel application should now work properly

## Troubleshooting

If you continue having issues:
1. Check server error logs
2. Ensure PHP version is 8.0 or higher
3. Verify all required PHP extensions are installed
4. Contact your hosting provider if permission issues persist