@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb / Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}" class="text-decoration-none text-muted">Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Class</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Class</h1>
        </div>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('admin.classes.update', $class->id) }}" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Class Name Input -->
                    <div class="col-12 mb-4">
                        <label for="class_name" class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">
                            Class Name
                        </label>
                        <input type="text" 
                               id="class_name"
                               name="class_name"
                               value="{{ old('class_name', $class->class_name) }}"
                               class="form-control form-control-lg @error('class_name') is-invalid @enderror"
                               placeholder="e.g., Grade 10 - Section A"
                               required>
                        
                        @error('class_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teacher Selector -->
                    <div class="col-md-6 mb-4">
                        <label for="teacher_id" class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">
                            Assigned Teacher
                        </label>
                        <select id="teacher_id" 
                                name="teacher_id" 
                                class="form-select form-select-lg @error('teacher_id') is-invalid @enderror">
                            <option value="">Select Teacher...</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" {{ old('teacher_id', $class->teacher_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->user->name ?? 'Unknown Teacher' }}
                                </option>
                            @endforeach
                        </select>
                        
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Room Selector -->
                    <div class="col-md-6 mb-4">
                        <label for="room_id" class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">
                            Classroom / Location
                        </label>
                        <select id="room_id" 
                                name="room_id" 
                                class="form-select form-select-lg @error('room_id') is-invalid @enderror">
                            <option value="">Select Room...</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}" {{ old('room_id', $class->room_id) == $r->id ? 'selected' : '' }}>
                                    {{ $r->room_name }}
                                </option>
                            @endforeach
                        </select>
                        
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5 border-top pt-4">
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-light px-4 rounded-3">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-4 rounded-3 fw-medium d-inline-flex align-items-center">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection