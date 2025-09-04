<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="booking-url" content="{{ route('booking.store') }}">
    <title>@yield('title', 'Tawasul Limousine')</title>
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    
    @stack('styles')
    @yield('head')
</head>
<body>
    @include('layouts.header')
    
    <!-- Booking Modal -->
    <div id="bookingModal" class="booking-modal" style="display: none;">
        <div class="booking-modal-content">
            <div class="booking-modal-header">
                <h3>Book Your Trip</h3>
                <span class="booking-modal-close" onclick="closeBookingModal()">&times;</span>
            </div>
            <div class="booking-modal-body">
                <form id="bookingModalForm" class="booking-form-modal">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="modal_city">City</label>
                            <select id="modal_city" name="city" required>
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
                            <label for="modal_date">Date</label>
                            <input type="date" id="modal_date" name="date" required class="date-input">
                        </div>
                        <div class="form-group">
                            <label for="modal_time">Time</label>
                            <input type="time" id="modal_time" name="time" required class="time-input">
                        </div>
                    </div>
                    
                    <div class="location-row">
                        <div class="form-group">
                            <label for="modal_pickup">Pickup Location</label>
                            <input type="text" id="modal_pickup" name="pickup_location" placeholder="Click to select location" onclick="handleModalLocationInput('pickup')" required>
                            <input type="hidden" id="modal_pickup_lat" name="pickup_lat">
                            <input type="hidden" id="modal_pickup_lng" name="pickup_lng">
                        </div>
                        <div class="form-group">
                            <label for="modal_dropoff">Drop-off Location</label>
                            <input type="text" id="modal_dropoff" name="dropoff_location" placeholder="Click to select location" onclick="handleModalLocationInput('dropoff')" required>
                            <input type="hidden" id="modal_dropoff_lat" name="dropoff_lat">
                            <input type="hidden" id="modal_dropoff_lng" name="dropoff_lng">
                        </div>
                    </div>
                    
                    <div class="contact-row">
                        <div class="form-group">
                            <label for="modal_mobile">Mobile Number</label>
                            <input type="tel" id="modal_mobile" name="mobile" placeholder="Enter your mobile number" required>
                        </div>
                        <div class="form-group">
                            <label for="modal_email">Email Address</label>
                            <input type="email" id="modal_email" name="email" placeholder="Enter your email address" required>
                        </div>
                    </div>
                    
                    <div class="form-bottom">
                        <button type="submit" class="see-prices-btn">Book Now</button>
                        <button type="button" class="cancel-btn" onclick="closeBookingModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Map Modal for Location Selection -->
    <div id="mapModal" class="map-modal" style="display: none;">
        <div class="map-modal-content">
            <div class="map-modal-header">
                <h3 id="mapModalTitle">Select Location</h3>
                <span class="map-close" onclick="closeMapModal()">&times;</span>
            </div>
            <div class="map-modal-body">
                <input type="text" id="mapSearch" placeholder="Search for a location..." class="map-search-input">
                <button id="useCurrentLocationBtn" onclick="useCurrentLocationInMap()" class="current-location-btn">
                    📍 Use Current Location
                </button>
                <div id="map" class="map-container"></div>
            </div>
            <div class="map-modal-footer">
                <button onclick="closeMapModal()" class="cancel-location-btn">Cancel</button>
                <button onclick="confirmLocation()" class="confirm-location-btn">Confirm Location</button>
            </div>
        </div>
    </div>
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <!-- Main JavaScript -->
    @vite(['resources/js/app.js'])
    
    <!-- Google Maps API - Load after main JS -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', 'AIzaSyDbxuyBHu5VWQGbiZDlpJ1p2qhC7C8pF0g') }}&libraries=places&callback=initMap"></script>
    
    @stack('scripts')
    @yield('scripts')
</body>
</html>