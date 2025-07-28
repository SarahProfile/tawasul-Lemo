@extends('admin.layout')

@section('page-title', 'Edit ' . ucfirst($page) . ' Page Content')

@section('page-actions')
    <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Pages
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ ucfirst($page) }} Page Content</h5>
                <div>
                    <a href="{{ url('/' . ($page === 'home' ? '' : $page)) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-external-link-alt me-1"></i> View Page
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($contents->count() > 0)
                    <form method="POST" action="{{ route('admin.content.update', $page) }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf
                        @method('PUT')
                        
                        @foreach($contents as $section => $sectionContents)
                            <div class="section-group mb-4">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-layer-group me-2"></i>{{ ucfirst(str_replace('_', ' ', $section)) }}
                                </h6>
                                
                                <div class="row">
                                    @foreach($sectionContents as $content)
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">{{ ucfirst(str_replace('_', ' ', $content->key)) }}</label>
                                            
                                            @if($content->type === 'image')
                                                <div class="mb-2">
                                                    @if($content->value)
                                                        <img src="{{ asset($content->value) }}" alt="{{ $content->key }}" class="img-thumbnail" style="max-height: 100px;">
                                                        <br><small class="text-muted">Current: {{ $content->value }}</small>
                                                    @else
                                                        <div class="text-muted">No image uploaded yet</div>
                                                    @endif
                                                </div>
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="images[{{ $section }}][{{ $content->key }}]"
                                                       accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                                                <small class="text-muted">Upload new image (JPG, PNG, GIF, WebP). Leave empty to keep current image.</small>
                                            @elseif(strlen($content->value) > 100)
                                                <textarea class="form-control" 
                                                          name="content[{{ $section }}][{{ $content->key }}]" 
                                                          rows="4">{{ $content->value }}</textarea>
                                            @else
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="content[{{ $section }}][{{ $content->key }}]" 
                                                       value="{{ $content->value }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No content available</h5>
                        <p class="text-muted">Content for this page hasn't been set up yet. Visit the page first to generate the content structure.</p>
                        <a href="{{ url('/' . ($page === 'home' ? '' : $page)) }}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Visit {{ ucfirst($page) }} Page
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($contents->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Add New Content</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.content.update', $page) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Section name" name="new_section">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Content key" name="new_key">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Content value" name="new_value">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-plus me-1"></i> Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-save draft functionality
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            // You can add auto-save functionality here
            console.log('Content changed:', this.name, this.value);
        });
    });
});
</script>
@endsection