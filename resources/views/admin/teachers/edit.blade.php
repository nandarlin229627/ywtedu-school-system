@extends('layouts.admin')

@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Edit Teacher</h4>
        <a href="{{ route('teachers.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $teacher->user->name) }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $teacher->user->email) }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Teacher No</label>
                <input type="text" name="teacher_no"
                       value="{{ old('teacher_no', $teacher->teacher_no) }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Hire Date</label>
                <input type="date" name="hire_date"
                value="{{ old('hire_date', \Carbon\Carbon::parse($teacher->hire_date)->format('Y-m-d')) }}"
                class="form-control" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Subjects</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($subjects as $subject)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="subjects[]" 
                                   value="{{ $subject->id }}" 
                                   id="subject{{ $subject->id }}"
                                   {{ (is_array(old('subjects', $teacher->subjects->pluck('id')->toArray())) && in_array($subject->id, old('subjects', $teacher->subjects->pluck('id')->toArray()))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject{{ $subject->id }}">
                                {{ $subject->subject_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

        

            <div class="col-md-6">
                <label class="form-label">Qualification</label>
                <input type="text" name="qualification"
                       value="{{ old('qualification', $teacher->qualification) }}" 
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                    value="{{ old('phone', $teacher->phone) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Salary</label>
                <input type="number" name="salary"
                       value="{{ old('salary', $teacher->salary) }}"
                       class="form-control" min="0" step="0.01" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="leave" {{ old('status', $teacher->status) == 'leave' ? 'selected' : '' }}>Leave</option>
                    <option value="inactive" {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-success px-4">
                <i class="bi bi-save"></i> Update Teacher
            </button>
        </div>

    </form>

</div>

@endsection