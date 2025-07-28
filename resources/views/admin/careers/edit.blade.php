@extends('admin.layout')

@section('page-title', 'Edit Career Position')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.careers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Positions
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Career Position</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.careers.update', $career) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Position Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $career->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Position Image</label>
                        @if($career->image)
                            <div class="mb-2">
                                <img src="{{ asset($career->image) }}" alt="{{ $career->title }}" 
                                     class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Responsibilities</label>
                        <div id="responsibilities-container">
                            @foreach(old('responsibilities', $career->responsibilities) as $responsibility)
                                <div class="responsibility-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="responsibilities[]" 
                                               value="{{ $responsibility }}" placeholder="Enter responsibility" required>
                                        <button type="button" class="btn btn-danger remove-responsibility">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-responsibility">
                            <i class="fas fa-plus me-1"></i> Add Responsibility
                        </button>
                        @error('responsibilities')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $career->order) }}" min="0">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $career->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible on career page)
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.careers.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Position
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Position Details</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Created:</strong> {{ $career->created_at->format('M j, Y g:i A') }}<br>
                    <strong>Last Updated:</strong> {{ $career->updated_at->format('M j, Y g:i A') }}<br>
                    <strong>Status:</strong> {{ $career->is_active ? 'Active' : 'Inactive' }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('career') }}" target="_blank" class="btn btn-info btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> View on Website
                    </a>
                    
                    <form method="POST" action="{{ route('admin.careers.destroy', $career) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Are you sure you want to delete this position?')">
                            <i class="fas fa-trash me-1"></i> Delete Position
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('responsibilities-container');
    const addButton = document.getElementById('add-responsibility');
    
    addButton.addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'responsibility-item mb-2';
        newItem.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control" name="responsibilities[]" 
                       placeholder="Enter responsibility" required>
                <button type="button" class="btn btn-danger remove-responsibility">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        updateRemoveButtons();
    });
    
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-responsibility')) {
            e.target.closest('.responsibility-item').remove();
            updateRemoveButtons();
        }
    });
    
    function updateRemoveButtons() {
        const items = container.querySelectorAll('.responsibility-item');
        items.forEach((item, index) => {
            const button = item.querySelector('.remove-responsibility');
            button.disabled = items.length === 1;
        });
    }
    
    // Initialize
    updateRemoveButtons();
});
</script>
@endsection