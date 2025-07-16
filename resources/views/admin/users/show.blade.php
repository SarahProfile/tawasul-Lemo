@extends('admin.layout')

@section('title', 'User Details')
@section('page-title', 'User: ' . $user->name)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        @endif
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Role:</strong></td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Email Verified:</strong></td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                                <small class="text-muted">({{ $user->email_verified_at->format('M d, Y H:i') }})</small>
                            @else
                                <span class="badge bg-warning">Not Verified</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User's Bookings</h5>
                <a href="{{ route('admin.bookings.index') }}?user_id={{ $user->id }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($user->bookings && $user->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>City</th>
                                    <th>Pickup</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->bookings()->latest()->take(5)->get() as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->date->format('M d, Y') }}</td>
                                    <td>{{ $booking->city }}</td>
                                    <td>{{ Str::limit($booking->pickup_location, 30) }}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No bookings found for this user.</p>
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
                        <td><strong>User ID:</strong></td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Updated:</strong></td>
                        <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Bookings:</strong></td>
                        <td>{{ $user->bookings ? $user->bookings->count() : 0 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Users
    </a>
</div>
@endsection