# Laravel Deployment Instructions for cPanel (No SSH Access)

## Quick Setup Guide

Your Laravel project includes pre-built deployment scripts that work without command line access. Follow these steps in order:

### Step 1: Upload Files to Server
1. Upload all project files to your cPanel public_html directory
2. Make sure the `.env.production` file is renamed to `.env`
3. Update database credentials in `.env` file

### Step 2: Fix Permissions First
Visit: `https://yourdomain.com/fix-permissions.php?run=fix`

This will:
- Create missing Laravel directories
- Set correct permissions (755) for storage and cache directories
- Create security .htaccess files
- Verify all directories are writable

### Step 3: Run Database Migrations
Visit: `https://yourdomain.com/migrate.php?run=migrate`

This will:
- Test database connection
- Show available migration files
- Run all database migrations
- Verify tables were created successfully

### Step 4: Complete Laravel Setup
Visit: `https://yourdomain.com/setup.php?run=setup`

This will:
- Check PHP version and extensions
- Generate application key
- Clear all caches
- Cache configuration for production
- Run final optimizations

### Step 5: Clean Up (IMPORTANT!)
After successful setup, **DELETE these files for security**:
- `fix-permissions.php`
- `migrate.php` 
- `setup.php`
- `deploy.php`

## Alternative: Single Command Script

If you prefer a single script that runs everything, use the existing `deploy.php` with a web wrapper:

Create a file called `install.php` with the content below, upload it, then visit `https://yourdomain.com/install.php?run=deploy`

## Troubleshooting

### Common Issues:

1. **Permission Denied Errors**
   - Run `fix-permissions.php` first
   - Manually set storage/ and bootstrap/cache/ to 755 or 777 via cPanel File Manager

2. **Database Connection Failed**
   - Check .env file database credentials
   - Ensure database exists in cPanel
   - Verify username has access to the database

3. **Composer Dependencies Missing**
   - Upload vendor/ folder from your local development
   - Or ask hosting provider to enable Composer

4. **PHP Version Issues**
   - Requires PHP 8.2+
   - Enable required extensions in cPanel PHP Settings

### Required PHP Extensions:
- pdo, pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath

## File Structure After Setup:
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          (Laravel public files)
├── resources/
├── routes/
├── storage/         (must be writable)
├── vendor/
├── .env            (database config)
├── artisan
└── composer.json
```

## Security Notes:
- Delete all setup scripts after deployment
- Keep .env file secure (contains database passwords)
- storage/ and bootstrap/cache/ directories should not be web accessible
- The scripts create .htaccess files to protect sensitive directories

## Support:
If you encounter issues, check the error logs in cPanel or contact your hosting provider for assistance with PHP configuration.