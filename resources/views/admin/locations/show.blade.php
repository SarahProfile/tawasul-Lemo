@extends('admin.layout')

@section('page-title', 'Contact Location Details')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Locations
        </a>
        <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Location
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $location->name }}</h5>
                <span class="badge {{ $location->is_active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $location->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Address</h6>
                        <p class="mb-0">{{ $location->address }}</p>
                        <p class="mb-0">{{ $location->city }}, {{ $location->country }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Contact Information</h6>
                        @if($location->phone)
                            <p class="mb-0"><i class="fas fa-phone me-2"></i> {{ $location->phone }}</p>
                        @endif
                        @if($location->email)
                            <p class="mb-0"><i class="fas fa-envelope me-2"></i> {{ $location->email }}</p>
                        @endif
                        @if(!$location->phone && !$location->email)
                            <p class="text-muted mb-0">No contact information provided</p>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Coordinates</h6>
                        <p class="mb-0">
                            <strong>Latitude:</strong> {{ $location->latitude }}<br>
                            <strong>Longitude:</strong> {{ $location->longitude }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Display Settings</h6>
                        <p class="mb-0">
                            <strong>Order:</strong> {{ $location->order }}<br>
                            <strong>Status:</strong> {{ $location->is_active ? 'Active' : 'Inactive' }}
                        </p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="text-muted">Map Preview</h6>
                    <div class="ratio ratio-16x9" style="max-height: 400px;">
                        <iframe src="{{ $location->map_embed_url }}" 
                                allowfullscreen="" 
                                loading="lazy"
                                class="rounded">
                        </iframe>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="text-muted">Map Embed URL</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $location->map_embed_url }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $location->map_embed_url }}')">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Location Info</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Created:</strong> {{ $location->created_at->format('M j, Y g:i A') }}<br>
                    <strong>Last Updated:</strong> {{ $location->updated_at->format('M j, Y g:i A') }}<br>
                    <strong>Display Order:</strong> {{ $location->order }}<br>
                    <strong>Status:</strong> {{ $location->is_active ? 'Active' : 'Inactive' }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('contact') }}" target="_blank" class="btn btn-info btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> View on Website
                    </a>
                    
                    <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Location
                    </a>
                    
                    @if(!$location->is_active)
                        <form method="POST" action="{{ route('admin.locations.update', $location) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            @foreach($location->toArray() as $key => $value)
                                @if($key !== 'is_active')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="btn btn-success btn-sm w-100">
                                <i class="fas fa-eye me-1"></i> Activate Location
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.locations.update', $location) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            @foreach($location->toArray() as $key => $value)
                                @if($key !== 'is_active')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <input type="hidden" name="is_active" value="0">
                            <button type="submit" class="btn btn-secondary btn-sm w-100">
                                <i class="fas fa-eye-slash me-1"></i> Deactivate Location
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Are you sure you want to delete this location?')">
                            <i class="fas fa-trash me-1"></i> Delete Location
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        alert('URL copied to clipboard!');
    });
}
</script>
@endsection