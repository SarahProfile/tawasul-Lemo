@extends('admin.layout')

@section('title', 'Booking Details')
@section('page-title', 'Booking #' . $booking->id)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Booking Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Trip Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>City:</strong></td>
                                <td>{{ $booking->city }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td>{{ $booking->date->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Time:</strong></td>
                                <td>{{ $booking->time->format('H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pickup:</strong></td>
                                <td>{{ $booking->pickup_location }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dropoff:</strong></td>
                                <td>{{ $booking->dropoff_location }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $booking->customer_name ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $booking->customer_email ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $booking->customer_phone ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>User Account:</strong></td>
                                <td>
                                    @if($booking->user)
                                        <a href="{{ route('admin.users.show', $booking->user) }}">{{ $booking->user->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($booking->pickup_lat && $booking->pickup_lng && $booking->dropoff_lat && $booking->dropoff_lng)
                <div class="mt-4">
                    <h6>Location Coordinates</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Pickup:</strong> {{ $booking->pickup_lat }}, {{ $booking->pickup_lng }}
                        </div>
                        <div class="col-md-6">
                            <strong>Dropoff:</strong> {{ $booking->dropoff_lat }}, {{ $booking->dropoff_lng }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Booking ID:</strong></td>
                        <td>{{ $booking->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $booking->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Updated:</strong></td>
                        <td>{{ $booking->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Bookings
    </a>
</div>
@endsection