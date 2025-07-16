@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="display-4 text-primary">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h5 class="card-title mt-3">Total Bookings</h5>
                <p class="card-text display-6">{{ $totalBookings }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="display-4 text-success">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="card-title mt-3">Total Users</h5>
                <p class="card-text display-6">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Bookings</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->customer_name ?: ($booking->user ? $booking->user->name : 'N/A') }}</td>
                                    <td>{{ $booking->date->format('M d, Y') }}</td>
                                    <td>{{ $booking->city }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No bookings yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">User</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No users yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection