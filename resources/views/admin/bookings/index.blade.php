@extends('admin.layout')

@section('title', 'Bookings')
@section('page-title', 'Bookings Management')

@section('page-actions')
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create Booking
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>City</th>
                            <th>Pickup Location</th>
                            <th>Dropoff Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                {{ $booking->customer_name ?: ($booking->user ? $booking->user->name : 'N/A') }}
                                @if($booking->customer_email)
                                    <br><small class="text-muted">📧 {{ $booking->customer_email }}</small>
                                @endif
                                @if($booking->customer_phone)
                                    <br><small class="text-muted">📱 {{ $booking->customer_phone }}</small>
                                @endif
                            </td>
                            <td>{{ $booking->date->format('M d, Y') }}</td>
                            <td>{{ $booking->time->format('H:i') }}</td>
                            <td>{{ $booking->city }}</td>
                            <td>{{ Str::limit($booking->pickup_location, 30) }}</td>
                            <td>{{ Str::limit($booking->dropoff_location, 30) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this booking?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $bookings->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5>No bookings found</h5>
                <p class="text-muted">Start by creating your first booking.</p>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">Create Booking</a>
            </div>
        @endif
    </div>
</div>
@endsection