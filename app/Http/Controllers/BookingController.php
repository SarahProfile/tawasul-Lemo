<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;

class BookingController extends Controller
{
    public function create()
    {
        return view('booking');
    }
    
    public function store(Request $request)
    {
        // Log incoming request for debugging
        \Log::info('Booking request received:', [
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        try {
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
                'mobile' => 'required|string|max:20',
                'email' => 'required|email|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Booking validation failed:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Please check your form data.',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            // Log the data being inserted
            $bookingData = [
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
                'customer_email' => $request->email,
                'customer_phone' => $request->mobile,
                'user_id' => Auth::id(),
            ];
            
            \Log::info('Attempting to create booking with data:', $bookingData);
            
            // Create booking
            $booking = Booking::create($bookingData);

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
        } catch (\Exception $e) {
            \Log::error('Failed to create booking: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit your booking. Please try again or contact support.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}