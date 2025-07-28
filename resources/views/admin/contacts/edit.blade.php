@extends('admin.layout')

@section('page-title', 'Edit Contact Message')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-info">
            <i class="fas fa-eye me-1"></i> View
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Contact Message</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $contact->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $contact->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="6" required>{{ old('message', $contact->message) }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Contact Information</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Submitted:</strong> {{ $contact->created_at->format('M j, Y g:i A') }}<br>
                    <strong>Last Updated:</strong> {{ $contact->updated_at->format('M j, Y g:i A') }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $contact->email }}" class="btn btn-success btn-sm">
                        <i class="fas fa-envelope me-1"></i> Send Email
                    </a>
                    <a href="tel:{{ $contact->phone }}" class="btn btn-info btn-sm">
                        <i class="fas fa-phone me-1"></i> Call Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection