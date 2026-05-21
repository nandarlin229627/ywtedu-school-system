@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- BACK BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Teacher Profile</h4>

        <a href="{{ route('teachers.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- PROFILE CARD -->
    <div class="row">

        <!-- LEFT CARD -->
        <div class="col-md-4">
            <div class="card-custom text-center p-4">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($teacher->user->name) }}&size=128"
                    class="rounded-circle shadow mb-3"
                    width="120">

                <h5 class="fw-bold mb-0">{{ $teacher->user->name }}</h5>
                <p class="text-muted mb-2">{{ $teacher->subject ?? 'No Subject' }}</p>

                <span class="badge bg-success">
                    {{ ucfirst($teacher->status ?? 'active') }}
                </span>

                <hr>

                <div class="text-start">

                    <p><strong>Teacher No:</strong> {{ $teacher->teacher_no }}</p>
                    <p><strong>Email:</strong> {{ $teacher->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $teacher->phone ?? '-' }}</p>
                    <p><strong>Qualification:</strong> {{ $teacher->qualification ?? '-' }}</p>
                    <p><strong>Hire Date:</strong> {{ $teacher->hire_date ?? '-' }}</p>

                </div>

            </div>
        </div>

        <!-- RIGHT CARD -->
        <div class="col-md-8">

            <div class="card-custom p-4">

                <h5 class="fw-bold mb-3">Quick Actions</h5>

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="p-3 border rounded text-center">
                            <h6>Total Classes</h6>
                            <h3 class="text-primary">12</h3>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded text-center">
                            <h6>Attendance</h6>
                            <h3 class="text-success">95%</h3>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded text-center">
                            <h6>Salary</h6>
                            <h3 class="text-warning">500K</h3>
                        </div>
                    </div>

                </div>

                <hr>

                <h6 class="fw-bold">About Teacher</h6>
                <p class="text-muted">
                    This section can be used for notes, performance summary, or admin remarks.
                </p>

                <div class="mt-3 d-flex gap-2">

                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <button class="btn btn-danger deleteTeacher" data-id="{{ $teacher->id }}">
                        <i class="bi bi-trash"></i> Delete
                    </button>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection