# 🚀 Tawasul Limousine - Server Deployment Guide

## 📋 Pre-Deployment Checklist

### Server Requirements
- **PHP**: 8.2 or higher
- **MySQL**: 5.7 or higher
- **Composer**: Latest version
- **Web Server**: Apache/Nginx
- **SSL Certificate**: Recommended

### Required PHP Extensions
- PDO, PDO_MySQL, mbstring, OpenSSL, Tokenizer, XML, ctype, JSON, BCMath

## 🔧 Deployment Steps

### Step 1: Upload Files
1. **Download/Clone** the project to your local machine
2. **Upload** all files to your server's web directory
3. **Ensure** the web server points to the `public` directory

### Step 2: Run Setup Script
```bash
# Make the setup script executable
chmod +x server-setup.sh

# Run the setup script
./server-setup.sh
```

### Step 3: Configure Environment
1. **Edit** `.env` file with your server details:
   ```env
   APP_URL=https://cr8v.com/tawasullemo
   
   # Database Configuration
   DB_HOST=localhost
   DB_DATABASE=allaithsafia_tawasul_limo
   DB_USERNAME=allaithsafia
   DB_PASSWORD="wvH+,cr#Nz^{"
   
   # Email Configuration
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   ```

### Step 4: Database Setup
The setup script will automatically:
- Run database migrations
- Create admin user
- Seed necessary data

### Step 5: Web Server Configuration

#### Apache (.htaccess)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name cr8v.com;
    root /path/to/your/project/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔐 Security Configuration

### File Permissions
```bash
# Set correct permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Important Security Notes
1. **Never** expose `.env` file to public access
2. **Point** web server to `public` directory only
3. **Use** HTTPS with SSL certificate
4. **Restrict** Google Maps API key to your domain
5. **Use** strong database passwords

## 🎯 Post-Deployment Testing

### Test These Features:
1. **Homepage**: `https://cr8v.com/tawasullemo`
2. **Admin Login**: `/login`
3. **Admin Dashboard**: `/admin/dashboard`
4. **Booking System**: Test booking form
5. **User Management**: Create/edit users
6. **Email Notifications**: Test booking emails

### Admin Access
- **URL**: `/admin/dashboard`
- **Email**: `admin@tawasullimo.com`
- **Password**: `admin123`

## 🔧 Configuration Options

### Google Maps API
1. Get API key from Google Cloud Console
2. Enable: Maps JavaScript API, Places API, Geocoding API
3. Add domain restrictions
4. Update `GOOGLE_MAPS_API_KEY` in `.env`

### Email Setup
1. Use Gmail SMTP or your hosting provider
2. For Gmail: Generate app password
3. Update email settings in `.env`

## 🚨 Troubleshooting

### Common Issues:

#### Permission Errors
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### Database Connection
- Check database credentials in `.env`
- Ensure MySQL service is running
- Verify database exists

#### 500 Internal Server Error
- Check error logs: `storage/logs/laravel.log`
- Verify PHP version and extensions
- Check file permissions

#### Google Maps Not Working
- Verify API key is valid
- Check domain restrictions
- Ensure required APIs are enabled

## 📞 Support

For deployment issues:
1. Check Laravel logs in `storage/logs/`
2. Review web server error logs
3. Verify all requirements are met
4. Test with simple PHP info file

## 🎉 Success Indicators

✅ Homepage loads without errors
✅ Admin panel accessible
✅ Database connections working
✅ Email notifications functional
✅ Google Maps displaying correctly
✅ Booking system operational
✅ SSL certificate active

---

**Last Updated**: July 2025
**Laravel Version**: 12.0
**PHP Version**: 8.2+