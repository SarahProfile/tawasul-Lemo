@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users Management')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create User
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $users->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>No users found</h5>
                <p class="text-muted">Start by creating your first user.</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create User</a>
            </div>
        @endif
    </div>
</div>
@endsection