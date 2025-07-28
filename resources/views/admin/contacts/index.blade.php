@extends('admin.layout')

@section('page-title', 'Contact Messages')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Contact Messages</h5>
                <span class="badge bg-primary">{{ $contacts->total() }} messages</span>
            </div>
            <div class="card-body">
                @if($contacts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message Preview</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->id }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                        </td>
                                        <td>{{ Str::limit($contact->message, 50) }}</td>
                                        <td>{{ $contact->created_at->format('M j, Y g:i A') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">
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
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $contacts->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No contact messages yet</h5>
                        <p class="text-muted">Contact messages from your website will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection