@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb / Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}" class="text-decoration-none text-muted">Rooms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Room</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Add New Room</h1>
        </div>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('admin.rooms.store') }}" autocomplete="off">
                @csrf

                <!-- Input Group -->
                <div class="mb-4">
                    <label for="room_name" class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">
                        Room Name
                    </label>
                    <input type="text" 
                           id="room_name"
                           name="room_name"
                           value="{{ old('room_name') }}"
                           class="form-control form-control-lg @error('room_name') is-invalid @enderror"
                           placeholder="e.g., Room 101, Lab A, Conference Room"
                           required
                           autofocus>
                    
                    <!-- Validation Error Message -->
                    @error('room_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <div class="form-text text-muted small mt-1">
                        Use a distinct name or number so users can easily find this location.
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5 border-top pt-4">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-light px-4 rounded-3">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-4 rounded-3 fw-medium d-inline-flex align-items-center">
                        <i class="fas fa-check me-2"></i> Save Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection