<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Booking Routes
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Booking Management
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class);
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});
