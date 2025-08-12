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
