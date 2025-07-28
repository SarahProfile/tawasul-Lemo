@extends('admin.layout')

@section('page-title', 'Page Content Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Manage Website Content</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Edit content for different pages of your website. Click on a page to manage its content.</p>
                
                <div class="row">
                    @foreach($pages as $page)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        @switch($page)
                                            @case('home')
                                                <i class="fas fa-home fa-3x text-primary"></i>
                                                @break
                                            @case('about')
                                                <i class="fas fa-info-circle fa-3x text-success"></i>
                                                @break
                                            @case('services')
                                                <i class="fas fa-cogs fa-3x text-warning"></i>
                                                @break
                                            @case('career')
                                                <i class="fas fa-briefcase fa-3x text-info"></i>
                                                @break
                                            @case('contact')
                                                <i class="fas fa-envelope fa-3x text-danger"></i>
                                                @break
                                            @default
                                                <i class="fas fa-file fa-3x text-secondary"></i>
                                        @endswitch
                                    </div>
                                    
                                    <h5 class="card-title text-capitalize">{{ $page }} Page</h5>
                                    
                                    @if(isset($contents[$page]))
                                        <p class="text-muted small">{{ $contents[$page]->count() }} content items</p>
                                    @else
                                        <p class="text-muted small">No content yet</p>
                                    @endif
                                    
                                    <a href="{{ route('admin.content.edit', $page) }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-1"></i> Edit Content
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>How it works:</strong> Each page can have multiple sections, and each section can contain text, images, and other content. You can edit all content dynamically from the admin panel.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection