# Tawasul Limousine Website

A professional Laravel-based limousine booking website with integrated Google Maps functionality and responsive design.

## Features

- **Modern Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Booking System**: Complete booking form with date/time selection and location mapping
- **Google Maps Integration**: Interactive map for pickup and dropoff location selection
- **User Authentication**: Registration and login system
- **Email Notifications**: Automatic booking confirmations sent to support team
- **Mobile Optimized**: Touch-friendly interface with proper mobile UX

## Tech Stack

- **Backend**: Laravel (PHP Framework)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Maps**: Google Maps JavaScript API with Places library
- **Email**: SMTP integration
- **Assets**: Local image storage in public/assets

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Node.js (for asset compilation)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/sarahprofile07/TawasulLimo.git
   cd TawasulLimo
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure environment variables**
   Edit `.env` file with your database and API credentials:
   ```env
   DB_DATABASE=tawasul_limo
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   GOOGLE_MAPS_API_KEY=your_google_maps_api_key
   
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=your_app_password
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

## Configuration

### Google Maps API
1. Get an API key from [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Maps JavaScript API and Places API
3. Set up API key restrictions for your domain
4. Add the key to your `.env` file

### Email Configuration
Configure SMTP settings in `.env` for booking notifications:
- Default recipient: support@tawasullimo.ae
- Booking confirmations sent automatically

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/           # Authentication controllers
│   │   └── BookingController.php
│   ├── Models/
│   │   ├── User.php
│   │   └── Booking.php
│   └── Mail/
│       └── BookingNotification.php
├── resources/views/
│   ├── home.blade.php      # Main homepage
│   └── emails/
├── public/assets/          # Local images and icons
├── database/migrations/    # Database structure
└── routes/web.php         # Application routes
```

## Features in Detail

### Booking System
- **City Selection**: Dropdown with UAE cities
- **Date/Time Picker**: Enhanced inputs with validation
- **Location Selection**: Google Maps integration for precise pickup/dropoff
- **Form Validation**: Client and server-side validation
- **Email Notifications**: Automatic confirmation emails

### Responsive Design
- **Mobile-First**: Optimized for mobile devices
- **Touch-Friendly**: Large touch targets and intuitive navigation
- **Cross-Browser**: Compatible with modern browsers
- **Performance**: Optimized images and efficient loading

### Security
- **CSRF Protection**: Laravel's built-in CSRF protection
- **Input Validation**: Comprehensive form validation
- **Environment Variables**: Sensitive data stored securely
- **Authentication**: Secure user registration and login

## Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database credentials
4. Set up SSL certificate
5. Configure web server (Apache/Nginx)

### API Key Security
- Restrict Google Maps API key to your domain
- Use environment variables for all sensitive data
- Never commit `.env` file to version control

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Support

For support or questions, contact: support@tawasullimo.ae

## License

This project is proprietary software for Tawasul Limousine.