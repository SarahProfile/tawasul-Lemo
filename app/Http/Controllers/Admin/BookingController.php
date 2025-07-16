<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.bookings.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'pickup_location' => 'required|string|max:255',
            'pickup_lat' => 'nullable|numeric',
            'pickup_lng' => 'nullable|numeric',
            'dropoff_location' => 'required|string|max:255',
            'dropoff_lat' => 'nullable|numeric',
            'dropoff_lng' => 'nullable|numeric',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id'
        ]);

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load('user');
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $users = User::all();
        return view('admin.bookings.edit', compact('booking', 'users'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'pickup_location' => 'required|string|max:255',
            'pickup_lat' => 'nullable|numeric',
            'pickup_lng' => 'nullable|numeric',
            'dropoff_location' => 'required|string|max:255',
            'dropoff_lat' => 'nullable|numeric',
            'dropoff_lng' => 'nullable|numeric',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
