@extends('admin.layout')

@section('page-title', 'Contact Locations')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Location
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Contact Locations</h5>
            </div>
            <div class="card-body">
                @if($locations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($locations as $location)
                                    <tr>
                                        <td>
                                            <strong>{{ $location->name }}</strong>
                                        </td>
                                        <td>{{ Str::limit($location->address, 50) }}</td>
                                        <td>{{ $location->city }}, {{ $location->country }}</td>
                                        <td>{{ $location->phone ?: 'N/A' }}</td>
                                        <td>
                                            <span class="badge {{ $location->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $location->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $location->order }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.locations.show', $location) }}" 
                                                   class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.locations.edit', $location) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" 
                                                      class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No contact locations found</h5>
                        <p class="text-muted">Add your first contact location to get started.</p>
                        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add Location
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection