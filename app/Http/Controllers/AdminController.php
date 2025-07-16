<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $recentBookings = Booking::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBookings', 'totalUsers', 'recentBookings', 'recentUsers'));
    }
}
