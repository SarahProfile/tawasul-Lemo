# Deployment Instructions for Tawasul Limousine

## Server Details
- **Server IP**: 13.201.125.146:2083
- **cPanel Username**: allaithsafia
- **cPanel Password**: wvH+,cr#Nz^{
- **Database Name**: allaithsafia_tawasul_limo
- **Database User**: allaithsafia
- **Database Password**: wvH+,cr#Nz^{
- **Deployment Path**: public_html/tawasullemo

## Step 1: Access cPanel
1. Go to: https://13.201.125.146:2083
2. Login with:
   - Username: allaithsafia
   - Password: wvH+,cr#Nz^{

## Step 2: Upload Files
1. Open **File Manager** in cPanel
2. Navigate to `public_html/`
3. Create folder `tawasullemo` if it doesn't exist
4. Upload the following files to `public_html/tawasullemo/`:
   - All project files except `.env` (use .env.production instead)
   - Make sure to upload the `public/` folder contents to the root of `tawasullemo/`

## Step 3: Set up Laravel Structure
The Laravel project should be structured as:
```
public_html/tawasullemo/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env (rename .env.production to .env)
├── artisan
├── composer.json
└── public/ contents should be in the root of tawasullemo/
```

## Step 4: Configure Environment
1. Rename `.env.production` to `.env`
2. Update the APP_URL in `.env` to match your domain
3. Set proper file permissions:
   - storage/ and bootstrap/cache/ should be writable (755 or 777)

## Step 5: Database Setup
1. In cPanel, go to **MySQL Databases**
2. Verify database `allaithsafia_tawasul_limo` exists
3. Run migrations via cPanel Terminal or File Manager:
   ```bash
   php artisan migrate
   ```

## Step 6: Final Configuration
1. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

2. Generate application key if needed:
   ```bash
   php artisan key:generate
   ```

## Step 7: Set Document Root
In cPanel, set the document root for your domain to point to `public_html/tawasullemo/public/`

## Important Files to Check:
- ✅ `.env` file with correct database credentials
- ✅ `storage/` directory permissions (writable)
- ✅ `bootstrap/cache/` directory permissions (writable)
- ✅ All assets in `public/assets/` folder uploaded correctly

## Troubleshooting:
- If you get "500 Internal Server Error", check file permissions
- If database connection fails, verify credentials in `.env`
- If images don't load, check that `public/assets/` folder uploaded correctly
- Clear browser cache after deployment

## URL Access:
After deployment, your site should be accessible at:
- https://allaith-safia.com/tawasullemo (if subdirectory)
- or your configured domain pointing to the Laravel public folder