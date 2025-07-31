@extends('admin.layout')

@section('page-title', 'Edit Contact Location')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Locations
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Contact Location</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.locations.update', $location) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Location Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $location->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', $location->city) }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="2" required>{{ old('address', $location->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" value="{{ old('country', $location->country) }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $location->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $location->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="map_embed_url" class="form-label">
                            <i class="fas fa-map-marked-alt me-1"></i> Google Maps Embed URL
                        </label>
                        <textarea class="form-control @error('map_embed_url') is-invalid @enderror" 
                                  id="map_embed_url" name="map_embed_url" rows="3" required>{{ old('map_embed_url', $location->map_embed_url) }}</textarea>
                        @error('map_embed_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <strong>📍 How to get Google Maps embed URL:</strong><br>
                            1. Go to <a href="https://maps.google.com" target="_blank">Google Maps</a><br>
                            2. Search for your location<br>
                            3. Click <strong>"Share"</strong> button<br>
                            4. Select <strong>"Embed a map"</strong> tab<br>
                            5. Copy the entire URL from the src attribute<br>
                            <small class="text-info">💡 Tip: The URL should start with "https://www.google.com/maps/embed"</small>
                        </div>
                    </div>
                    
                    <!-- Map Preview Section -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-eye me-1"></i> Map Preview
                        </label>
                        <div class="border rounded p-2" style="height: 300px;">
                            <iframe id="map_preview" 
                                    src="{{ $location->map_embed_url }}" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy">
                            </iframe>
                        </div>
                        <small class="text-muted">This is how the map will appear on your contact page</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $location->order) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (visible on website)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Location Details</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Created:</strong> {{ $location->created_at->format('M j, Y g:i A') }}<br>
                    <strong>Last Updated:</strong> {{ $location->updated_at->format('M j, Y g:i A') }}<br>
                    <strong>Status:</strong> {{ $location->is_active ? 'Active' : 'Inactive' }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('contact') }}" target="_blank" class="btn btn-info btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> View on Website
                    </a>
                    
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapUrlInput = document.getElementById('map_embed_url');
    const mapPreview = document.getElementById('map_preview');
    
    mapUrlInput.addEventListener('input', function() {
        const url = this.value.trim();
        if (url && url.includes('maps.google.com/maps/embed')) {
            mapPreview.src = url;
        }
    });
    
    // Auto-format map URL if user pastes iframe code
    mapUrlInput.addEventListener('paste', function(e) {
        setTimeout(() => {
            let content = this.value;
            // Extract URL from iframe if user pasted full iframe code
            const srcMatch = content.match(/src="([^"]*)/);
            if (srcMatch) {
                this.value = srcMatch[1];
                mapPreview.src = srcMatch[1];
            }
        }, 100);
    });
});
</script>
@endsection