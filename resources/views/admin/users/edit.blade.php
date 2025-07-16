@extends('admin.layout')

@section('title', 'Edit User')
@section('page-title', 'Edit User: ' . $user->name)

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave blank to keep current password.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input @error('is_admin') is-invalid @enderror" type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">
                        Admin User
                    </label>
                    @error('is_admin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Check this box to give the user admin privileges.</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection