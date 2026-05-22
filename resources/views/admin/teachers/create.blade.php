@extends('layouts.admin')

@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Add Teacher</h4>
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

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <!-- <div class="col-md-6">
                <label class="form-label">Teacher No</label>
                <input type="text" name="teacher_no" class="form-control" value="{{ old('teacher_no') }}" required>
            </div> -->

            <div class="col-md-6">
                <label class="form-label">Hire Date</label>
                <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date') }}" required>
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
                                   {{ (is_array(old('subjects')) && in_array($subject->id, old('subjects'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject{{ $subject->id }}">
                                {{ $subject->subject_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="col-md-6">
                <label class="form-label">Qualification</label>
                <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Salary</label>
                <input type="number" name="salary" class="form-control" value="{{ old('salary', 0) }}" min="0" step="0.01">
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-primary px-4">
                <i class="bi bi-check-circle"></i> Save Teacher
            </button>
        </div>

    </form>

</div>

@endsection