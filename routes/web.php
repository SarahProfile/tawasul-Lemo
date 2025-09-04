<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/career', function () {
    $careerPositions = \App\Models\CareerPosition::active()->ordered()->get();
    return view('career', compact('careerPositions'));
})->name('career');

Route::get('/contact', function () {
    $contactLocation = \App\Models\ContactLocation::active()->ordered()->first();
    return view('contact', compact('contactLocation'));
})->name('contact');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Booking Routes
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Test endpoint for debugging
Route::get('/test-booking', function() {
    return response()->json([
        'status' => 'OK',
        'message' => 'Booking endpoint is accessible',
        'timestamp' => now(),
        'csrf_token' => csrf_token()
    ]);
});

// Test booking email
Route::get('/test-booking-email', function() {
    try {
        $booking = new \App\Models\Booking([
            'id' => 999,
            'city' => 'Dubai',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => now()->addHour()->format('H:i:s'),
            'pickup_location' => 'Dubai Airport',
            'dropoff_location' => 'Dubai Mall',
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'customer_phone' => '+971501234567',
            'created_at' => now()
        ]);
        
        \Illuminate\Support\Facades\Mail::to('booking@tawasullimo.ae')->send(new \App\Mail\BookingNotification($booking));
        
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Test booking email sent to booking@tawasullimo.ae',
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});

// Test contact email
Route::get('/test-contact-email', function() {
    try {
        $contact = new \App\Models\Contact([
            'id' => 999,
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '+971501234567',
            'message' => 'This is a test contact message to verify email functionality.',
            'created_at' => now()
        ]);
        
        \Illuminate\Support\Facades\Mail::to('booking@tawasullimo.ae')->send(new \App\Mail\ContactNotification($contact));
        
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Test contact email sent to booking@tawasullimo.ae',
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});

// Test email endpoint
Route::get('/test-email', function() {
    try {
        \Illuminate\Support\Facades\Mail::raw('This is a test email to verify SMTP configuration with Outlook.', function ($message) {
            $message->to('booking@tawasullimo.ae')
                    ->subject('SMTP Test Email');
        });
        
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Test email sent successfully',
            'smtp_host' => config('mail.mailers.smtp.host'),
            'from_address' => config('mail.from.address'),
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage(),
            'smtp_host' => config('mail.mailers.smtp.host'),
            'from_address' => config('mail.from.address'),
            'timestamp' => now()
        ], 500);
    }
});

// Contact Routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Booking Management
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class);
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Content Management
    Route::get('/content', [App\Http\Controllers\Admin\PageContentController::class, 'index'])->name('content.index');
    Route::get('/content/{page}/edit', [App\Http\Controllers\Admin\PageContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{page}', [App\Http\Controllers\Admin\PageContentController::class, 'update'])->name('content.update');
    
    // Career Management
    Route::resource('careers', App\Http\Controllers\Admin\CareerPositionController::class);
    
    // Service Items Management
    Route::resource('service-items', App\Http\Controllers\Admin\ServiceItemController::class);
    
    // Contact Management
    Route::get('/contacts', [App\Http\Controllers\Admin\ContactManagementController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [App\Http\Controllers\Admin\ContactManagementController::class, 'show'])->name('contacts.show');
    Route::get('/contacts/{contact}/edit', [App\Http\Controllers\Admin\ContactManagementController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [App\Http\Controllers\Admin\ContactManagementController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [App\Http\Controllers\Admin\ContactManagementController::class, 'destroy'])->name('contacts.destroy');
    
    // Contact Locations Management
    Route::resource('locations', App\Http\Controllers\Admin\ContactLocationController::class);
});
