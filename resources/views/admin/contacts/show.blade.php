@extends('admin.layout')

@section('page-title', 'Contact Message Details')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
        <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">
                <i class="fas fa-trash me-1"></i> Delete
            </button>
        </form>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Message Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Name:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $contact->name }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-sm-9">
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Phone:</strong>
                    </div>
                    <div class="col-sm-9">
                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Date Received:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $contact->created_at->format('F j, Y \a\t g:i A') }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Message:</strong>
                    </div>
                    <div class="col-sm-9">
                        <div class="p-3 bg-light rounded">
                            {{ $contact->message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $contact->email }}?subject=Re: Your message to Tawasul Limo&body=Dear {{ $contact->name }},%0D%0A%0D%0AThank you for contacting Tawasul Limo." class="btn btn-success">
                        <i class="fas fa-reply me-1"></i> Reply via Email
                    </a>
                    
                    <a href="tel:{{ $contact->phone }}" class="btn btn-info">
                        <i class="fas fa-phone me-1"></i> Call {{ $contact->name }}
                    </a>
                    
                    <button class="btn btn-secondary" onclick="copyToClipboard('{{ $contact->message }}')">
                        <i class="fas fa-copy me-1"></i> Copy Message
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Contact Information</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Submitted:</strong> {{ $contact->created_at->diffForHumans() }}<br>
                    <strong>Last Updated:</strong> {{ $contact->updated_at->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Message copied to clipboard!');
    });
}
</script>
@endsection