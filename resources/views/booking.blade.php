@extends('layouts.app')

@section('title', 'Book Your Ride - Tawasul Limousine')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"></script>
@endsection

@push('styles')
<style>
    .booking-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #000000 0%, #333333 100%);
        padding: 100px 20px 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        width: 100%;
        max-width: 800px;
        padding: 40px;
    }

    .booking-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .booking-header .logo img {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
    }

    .booking-header h1 {
        font-size: 2.5rem;
        font-weight: 300;
        color: #000000;
        margin-bottom: 10px;
        font-family: 'Sequel Sans', Arial, sans-serif;
    }

    .booking-header p {
        color: #6D6D6D;
        font-size: 1rem;
        margin-bottom: 0;
    }

    /* Use the exact same form styles as home page */
    .booking-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        width: 100%;
    }

    .location-row {
        display: flex;
        gap: 1rem;
        width: 100%;
    }

    .contact-row {
        display: flex;
        gap: 1rem;
        width: 100%;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
        font-family: 'Sequel Sans', Arial, sans-serif;
    }

    .form-group input,
    .form-group select {
        padding: 1rem;
        border: 2px solid #E5E5E5;
        border-radius: 10px;
        font-size: 1rem;
        font-family: 'Sequel Sans', Arial, sans-serif;
        background: white;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #000000;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
    }

    .form-group input[readonly] {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .form-group input::placeholder {
        color: #B6B6B6;
    }

    .form-bottom {
        margin-top: 1rem;
    }

    .see-prices-btn {
        width: 100%;
        background: #000000;
        color: white;
        padding: 18px 30px;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Sequel Sans', Arial, sans-serif;
    }

    .see-prices-btn:hover {
        background: #333333;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .see-prices-btn:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid #28a745;
        display: none;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid #dc3545;
        display: none;
    }

    .divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
        color: #B6B6B6;
        font-size: 0.9rem;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #E5E5E5;
        z-index: 1;
    }

    .divider span {
        background: white;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .quick-actions {
        text-align: center;
        margin-bottom: 30px;
    }

    .quick-actions p {
        color: #6D6D6D;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .quick-actions a {
        color: #000000;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        margin: 0 15px;
        display: inline-block;
    }

    .quick-actions a:hover {
        color: #333333;
    }

    .back-to-home {
        text-align: center;
        margin-top: 20px;
    }

    .back-to-home a {
        color: #6D6D6D;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .back-to-home a:hover {
        color: #000000;
    }

    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .booking-page {
            padding: 80px 10px 30px;
        }

        .booking-container {
            padding: 30px 20px;
        }

        .booking-header h1 {
            font-size: 2rem;
        }

        .form-row,
        .location-row,
        .contact-row {
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 0;
        }
    }

    @media (max-width: 480px) {
        .booking-header h1 {
            font-size: 1.5rem;
        }

        .see-prices-btn {
            padding: 15px 20px;
            font-size: 1rem;
        }

        .quick-actions a {
            display: block;
            margin: 5px 0;
        }
    }
</style>
@endpush

@section('content')
<div class="booking-page">
    <div class="booking-container">
        <div class="booking-header">
            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Tawasul Limousine">
            </div>
            <h1>Book Your Ride</h1>
            <p>Fill in the details below to reserve your luxury transportation</p>
        </div>

        <div class="success-message" id="successMessage">
            <strong>Booking Successful!</strong> Your ride has been booked successfully. We will contact you shortly with confirmation details.
        </div>

        <div class="error-message" id="errorMessage">
            <strong>Booking Failed!</strong> <span id="errorText">Please check your details and try again.</span>
        </div>

        <form id="bookingForm" class="booking-form">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="city">City</label>
                    <select id="city" name="city" required>
                        <option value="">Select City</option>
                        <option value="Abu Dhabi">Abu Dhabi</option>
                        <option value="Dubai">Dubai</option>
                        <option value="Sharjah">Sharjah</option>
                        <option value="Ajman">Ajman</option>
                        <option value="Umm Al Quwain">Umm Al Quwain</option>
                        <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                        <option value="Fujairah">Fujairah</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required min="" class="date-input">
                </div>
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" id="time" name="time" required class="time-input">
                </div>
            </div>
            
            <div class="location-row">
                <div class="form-group">
                    <label for="pickup">Pickup Location</label>
                    <input type="text" id="pickup" name="pickup_location" placeholder="Getting current location..." onclick="handleLocationInput('pickup')" required readonly>
                    <input type="hidden" id="pickup_lat" name="pickup_lat">
                    <input type="hidden" id="pickup_lng" name="pickup_lng">
                </div>
                <div class="form-group">
                    <label for="dropoff">Drop-off Location</label>
                    <input type="text" id="dropoff" name="dropoff_location" placeholder="Click to select on map or type address" onclick="handleLocationInput('dropoff')" required readonly>
                    <input type="hidden" id="dropoff_lat" name="dropoff_lat">
                    <input type="hidden" id="dropoff_lng" name="dropoff_lng">
                </div>
            </div>

            <div class="contact-row">
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
            </div>
            
            <div class="form-bottom">
                <button type="submit" class="see-prices-btn" id="submitBookingBtn">
                    <span class="loading-spinner" id="loadingSpinner"></span>
                    <span id="btnText">Book Now</span>
                </button>
            </div>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <div class="quick-actions">
            <p>Need immediate assistance?</p>
            <a href="tel:600559595">📞 Call 600 55 95 95</a>
            <a href="mailto:support@tawasullimo.ae">✉️ Email Support</a>
        </div>

        <div class="back-to-home">
            <a href="{{ route('home') }}">← Back to Home</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // This page will use the same JavaScript from app.js since it extends layouts.app
    // The map modal and all location functionality will work the same as on the home page
    
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today
        const dateInput = document.getElementById('date');
        if (dateInput) {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            dateInput.setAttribute('min', formattedDate);
            dateInput.value = formattedDate;
        }
        
        // Set default time to current time + 1 hour
        const timeInput = document.getElementById('time');
        if (timeInput) {
            const now = new Date();
            now.setHours(now.getHours() + 1);
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            timeInput.value = `${hours}:${minutes}`;
        }

        // Override the default form submission from app.js for this specific page
        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            // Remove any existing event listeners
            bookingForm.replaceWith(bookingForm.cloneNode(true));
            const newBookingForm = document.getElementById('bookingForm');
            
            newBookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('submitBookingBtn');
                const btnText = document.getElementById('btnText');
                const loadingSpinner = document.getElementById('loadingSpinner');
                const successMsg = document.getElementById('successMessage');
                const errorMsg = document.getElementById('errorMessage');
                const errorText = document.getElementById('errorText');
                
                // Show loading state
                submitBtn.disabled = true;
                loadingSpinner.style.display = 'inline-block';
                btnText.textContent = 'Booking...';
                successMsg.style.display = 'none';
                errorMsg.style.display = 'none';
                
                // Prepare form data
                const formData = new FormData(this);
                
                // Basic validation
                const city = formData.get('city');
                const date = formData.get('date');
                const time = formData.get('time');
                const pickup = formData.get('pickup_location');
                const dropoff = formData.get('dropoff_location');
                const mobile = formData.get('mobile');
                const email = formData.get('email');
                
                if (!city || !date || !time || !pickup || !dropoff || !mobile || !email) {
                    alert('Please fill in all required fields');
                    resetButton();
                    return;
                }
                
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Please enter a valid email address');
                    resetButton();
                    return;
                }
                
                // Send booking request
                fetch('{{ route("booking.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message briefly
                        successMsg.style.display = 'block';
                        
                        // Redirect to home page after 2 seconds
                        setTimeout(() => {
                            window.location.href = '{{ route("home") }}';
                        }, 2000);
                    } else {
                        errorMsg.style.display = 'block';
                        errorText.textContent = data.message || 'Please check your details and try again.';
                        resetButton();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMsg.style.display = 'block';
                    errorText.textContent = 'Network error. Please check your connection and try again.';
                    resetButton();
                });
                
                function resetButton() {
                    submitBtn.disabled = false;
                    loadingSpinner.style.display = 'none';
                    btnText.textContent = 'Book Now';
                }
            });
        }
    });
</script>
@endpush