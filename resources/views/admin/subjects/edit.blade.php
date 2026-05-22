@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb / Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}" class="text-decoration-none text-muted">Subjects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Subject</h1>
        </div>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('admin.subjects.update', $subject->id) }}" autocomplete="off">
                @csrf
                @method('PUT')

                <!-- Input Group -->
                <div class="mb-4">
                    <label for="subject_name" class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">
                        Subject Name
                    </label>
                    <input type="text" 
                           id="subject_name"
                           name="subject_name"
                           value="{{ old('subject_name', $subject->subject_name) }}"
                           class="form-control form-control-lg @error('subject_name') is-invalid @enderror"
                           placeholder="e.g., Advanced Mathematics"
                           required>
                    
                    <!-- Validation Error Message -->
                    @error('subject_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <div class="form-text text-muted small mt-1">
                        Ensure the subject name is unique and easily identifiable.
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5 border-top pt-4">
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-light px-4 rounded-3">
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