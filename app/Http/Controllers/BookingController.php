<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'pickup_location' => 'required|string|max:255',
            'pickup_lat' => 'nullable|numeric',
            'pickup_lng' => 'nullable|numeric',
            'dropoff_location' => 'required|string|max:255',
            'dropoff_lat' => 'nullable|numeric',
            'dropoff_lng' => 'nullable|numeric',
        ]);

        // Create booking
        $booking = Booking::create([
            'city' => $request->city,
            'date' => $request->date,
            'time' => $request->time,
            'pickup_location' => $request->pickup_location,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lng' => $request->pickup_lng,
            'dropoff_location' => $request->dropoff_location,
            'dropoff_lat' => $request->dropoff_lat,
            'dropoff_lng' => $request->dropoff_lng,
            'customer_name' => Auth::user()->name ?? 'Guest User',
            'customer_email' => Auth::user()->email ?? 'guest@tawasullimo.ae',
            'customer_phone' => null,
            'user_id' => Auth::id(),
        ]);

        // Send email notification
        try {
            Mail::to('support@tawasullimo.ae')->send(new BookingNotification($booking));
        } catch (\Exception $e) {
            // Log the error but don't fail the booking
            \Log::error('Failed to send booking notification email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Your booking request has been submitted successfully! We will contact you shortly.',
            'booking_id' => $booking->id
        ]);
    }
}