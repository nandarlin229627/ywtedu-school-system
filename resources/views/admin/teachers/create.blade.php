@extends('layouts.admin')

@section('title', 'Add Teacher')

@section('content')

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-body p-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Add Teacher
                </h4>

                <p class="text-muted mb-0">
                    Create new teacher account and assign subjects
                </p>
            </div>

            <a href="{{ route('admin.teachers.index') }}"
               class="btn btn-light border">

                <i class="bi bi-arrow-left"></i>
                Back

            </a>

        </div>

        <!-- VALIDATION ERRORS -->
        @if ($errors->any())

            <div class="alert alert-danger border-0 shadow-sm rounded-3">

                <div class="fw-semibold mb-2">
                    Please fix the following errors:
                </div>

                <ul class="mb-0 ps-3">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form action="{{ route('admin.teachers.store') }}"
              method="POST">

            @csrf

            <div class="row g-4">

                <!-- FULL NAME -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Full Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control rounded-3"
                           value="{{ old('name') }}"
                           placeholder="Enter teacher name"
                           required>

                </div>

                <!-- EMAIL -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Email Address
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control rounded-3"
                           value="{{ old('email') }}"
                           placeholder="Enter email address"
                           required>

                </div>

                <!-- PASSWORD -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Password
                    </label>

                    <div class="input-group">

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control rounded-start-3"
                               placeholder="Enter password"
                               required>

                        <button type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword('password', this)">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Confirm Password
                    </label>

                    <div class="input-group">

                        <input type="password"
                               name="password_confirmation"
                               id="confirmPassword"
                               class="form-control rounded-start-3"
                               placeholder="Confirm password"
                               required>

                        <button type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword('confirmPassword', this)">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                </div>

                <!-- HIRE DATE -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Hire Date
                    </label>

                    <input type="date"
                           name="hire_date"
                           class="form-control rounded-3"
                           value="{{ old('hire_date') }}"
                           required>

                </div>

                <!-- PHONE -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           class="form-control rounded-3"
                           value="{{ old('phone') }}"
                           placeholder="Enter phone number">

                </div>

                <!-- QUALIFICATION -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Qualification
                    </label>

                    <input type="text"
                           name="qualification"
                           class="form-control rounded-3"
                           value="{{ old('qualification') }}"
                           placeholder="Bachelor / Master / PhD">

                </div>

                <!-- SALARY -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Salary
                    </label>

                    <input type="number"
                           name="salary"
                           class="form-control rounded-3"
                           value="{{ old('salary', 0) }}"
                           min="0"
                           step="0.01">

                </div>

                <!-- SUBJECTS -->
                <div class="col-md-12">

                    <label class="form-label fw-semibold mb-3">
                        Assign Subjects
                    </label>

                    <div class="row g-3">

                        @foreach($subjects as $subject)

                            <div class="col-md-3 col-sm-6">

                                <div class="form-check">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="subjects[]"
                                           value="{{ $subject->id }}"
                                           id="subject{{ $subject->id }}"
                                           {{ (is_array(old('subjects')) && in_array($subject->id, old('subjects'))) ? 'checked' : '' }}>

                                    <label class="form-check-label ms-2 fw-medium"
                                           for="subject{{ $subject->id }}">

                                        {{ $subject->subject_name }}

                                    </label>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <!-- BUTTONS -->
            <div class="mt-5 d-flex gap-2">

                <button type="submit"
                        class="btn btn-primary px-4 py-2 rounded-3">

                    <i class="bi bi-check-circle me-1"></i>
                    Save Teacher

                </button>

                <a href="{{ route('admin.teachers.index') }}"
                   class="btn btn-light border px-4 py-2 rounded-3">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>

    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');

        } else {

            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');

        }

    }

</script>

@endpush