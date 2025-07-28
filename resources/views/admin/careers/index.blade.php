@extends('admin.layout')

@section('page-title', 'Career Positions')

@section('page-actions')
    <a href="{{ route('admin.careers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Add New Position
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Career Positions</h5>
                <span class="badge bg-primary">{{ $positions->count() }} positions</span>
            </div>
            <div class="card-body">
                @if($positions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Responsibilities</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($positions as $position)
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">{{ $position->order }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $position->title }}</strong>
                                        </td>
                                        <td>
                                            @if($position->image)
                                                <img src="{{ asset($position->image) }}" alt="{{ $position->title }}" 
                                                     class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ count($position->responsibilities) }} items</span>
                                        </td>
                                        <td>
                                            @if($position->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.careers.edit', $position) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.careers.destroy', $position) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this position?')">
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
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No career positions yet</h5>
                        <p class="text-muted">Create your first career position to start recruiting talent.</p>
                        <a href="{{ route('admin.careers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add First Position
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection