@extends('admin.layout')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking #' . $booking->id)

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $booking->city) }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $booking->date->format('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time', $booking->time->format('H:i')) }}" required>
                        @error('time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pickup_location" class="form-label">Pickup Location</label>
                        <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" id="pickup_location" name="pickup_location" value="{{ old('pickup_location', $booking->pickup_location) }}" required>
                        @error('pickup_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="dropoff_location" class="form-label">Dropoff Location</label>
                        <input type="text" class="form-control @error('dropoff_location') is-invalid @enderror" id="dropoff_location" name="dropoff_location" value="{{ old('dropoff_location', $booking->dropoff_location) }}" required>
                        @error('dropoff_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="pickup_lat" class="form-label">Pickup Latitude</label>
                        <input type="number" step="any" class="form-control @error('pickup_lat') is-invalid @enderror" id="pickup_lat" name="pickup_lat" value="{{ old('pickup_lat', $booking->pickup_lat) }}">
                        @error('pickup_lat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="pickup_lng" class="form-label">Pickup Longitude</label>
                        <input type="number" step="any" class="form-control @error('pickup_lng') is-invalid @enderror" id="pickup_lng" name="pickup_lng" value="{{ old('pickup_lng', $booking->pickup_lng) }}">
                        @error('pickup_lng')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="dropoff_lat" class="form-label">Dropoff Latitude</label>
                        <input type="number" step="any" class="form-control @error('dropoff_lat') is-invalid @enderror" id="dropoff_lat" name="dropoff_lat" value="{{ old('dropoff_lat', $booking->dropoff_lat) }}">
                        @error('dropoff_lat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="dropoff_lng" class="form-label">Dropoff Longitude</label>
                        <input type="number" step="any" class="form-control @error('dropoff_lng') is-invalid @enderror" id="dropoff_lng" name="dropoff_lng" value="{{ old('dropoff_lng', $booking->dropoff_lng) }}">
                        @error('dropoff_lng')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}">
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Customer Email</label>
                        <input type="email" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email', $booking->customer_email) }}">
                        @error('customer_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Customer Phone</label>
                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}">
                        @error('customer_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Associated User (Optional)</label>
                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $booking->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Booking</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection