@extends('layouts.app')

@section('title', 'Elevated Travel Experience')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbxuyBHu5VWQGbiZDlpJ1p2qhC7C8pF0g&libraries=places&callback=initMap"></script>
@endsection

@push('styles')
<style>
/* Map Modal Styles */
.map-modal {
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.map-modal-content {
    background-color: white;
    border-radius: 10px;
    width: 90%;
    max-width: 800px;
    height: 80%;
    max-height: 600px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.map-modal-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
}

.map-modal-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
}

.map-close {
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    color: #666;
    transition: color 0.3s ease;
}

.map-close:hover {
    color: #000;
}

.map-modal-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 1rem;
}

.map-search-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 1rem;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.map-search-input:focus {
    border-color: #007bff;
}

.current-location-btn {
    width: 100%;
    padding: 0.75rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    margin-bottom: 1rem;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.current-location-btn:hover {
    background-color: #0056b3;
}

.current-location-btn:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
}

.map-container {
    flex: 1;
    border-radius: 5px;
    overflow: hidden;
    border: 1px solid #ddd;
}

.map-modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    background-color: #f8f9fa;
}

.confirm-location-btn,
.cancel-location-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.confirm-location-btn {
    background-color: #28a745;
    color: white;
}

.confirm-location-btn:hover {
    background-color: #218838;
}

.cancel-location-btn {
    background-color: #6c757d;
    color: white;
}

.cancel-location-btn:hover {
    background-color: #5a6268;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .map-modal-content {
        width: 95%;
        height: 90%;
    }
    
    .map-modal-header {
        padding: 0.75rem 1rem;
    }
    
    .map-modal-body {
        padding: 0.75rem;
    }
    
    .map-modal-footer {
        padding: 0.75rem 1rem;
        flex-direction: column;
    }
    
    .confirm-location-btn,
    .cancel-location-btn {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
    @include('content.home-content')
    
    <!-- Map Modal -->
    <div id="mapModal" class="map-modal" style="display: none;">
        <div class="map-modal-content">
            <div class="map-modal-header">
                <h3 id="mapModalTitle">Select Location</h3>
                <span class="map-close" onclick="closeMapModal()">&times;</span>
            </div>
            <div class="map-modal-body">
                <input type="text" id="mapSearch" placeholder="Search for a location..." class="map-search-input">
                <button id="useCurrentLocationBtn" class="current-location-btn" onclick="useCurrentLocationInMap()">
                    📍 Use Current Location
                </button>
                <div id="map" class="map-container"></div>
            </div>
            <div class="map-modal-footer">
                <button onclick="confirmLocation()" class="confirm-location-btn">Confirm Location</button>
                <button onclick="closeMapModal()" class="cancel-location-btn">Cancel</button>
            </div>
        </div>
    </div>
@endsection