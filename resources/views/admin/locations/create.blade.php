@extends('admin.layout')

@section('page-title', 'Add Contact Location')

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
                <h5 class="mb-0">Add New Contact Location</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.locations.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Location Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" placeholder="Main Office, Branch 1, etc." required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city') }}" placeholder="Dubai" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="2" placeholder="Full street address" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" value="{{ old('country', 'UAE') }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" placeholder="+971 4 xxx xxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" placeholder="office@example.com">
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
                                  id="map_embed_url" name="map_embed_url" rows="3" 
                                  placeholder="Paste the Google Maps embed URL here..." required>{{ old('map_embed_url') }}</textarea>
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
                            <div id="map_preview_placeholder" class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                <div class="text-center">
                                    <i class="fas fa-map-marker-alt fa-3x mb-2"></i>
                                    <p>Map preview will appear here after you enter the URL</p>
                                </div>
                            </div>
                            <iframe id="map_preview" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0; display: none;" 
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
                                       id="order" name="order" value="{{ old('order', 0) }}" min="0">
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
                                           {{ old('is_active', true) ? 'checked' : '' }}>
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
                            <i class="fas fa-save me-1"></i> Save Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Tips</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Getting Embed URL:</strong><br>
                    1. Search your location on Google Maps<br>
                    2. Click "Share" button<br>
                    3. Click "Embed a map"<br>
                    4. Copy the URL from the iframe src
                </small>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapUrlInput = document.getElementById('map_embed_url');
    const mapPreview = document.getElementById('map_preview');
    const mapPlaceholder = document.getElementById('map_preview_placeholder');
    
    mapUrlInput.addEventListener('input', function() {
        const url = this.value.trim();
        if (url && url.includes('maps.google.com/maps/embed')) {
            mapPreview.src = url;
            mapPreview.style.display = 'block';
            mapPlaceholder.style.display = 'none';
        } else {
            mapPreview.style.display = 'none';
            mapPlaceholder.style.display = 'flex';
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
                mapPreview.style.display = 'block';
                mapPlaceholder.style.display = 'none';
            }
        }, 100);
    });
});
</script>
@endsection