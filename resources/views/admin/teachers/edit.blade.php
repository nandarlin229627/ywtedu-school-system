@extends('layouts.admin')

@section('title', 'Edit Teacher')

@section('content')

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-body p-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Edit Teacher
                </h4>

                <p class="text-muted mb-0">
                    Update teacher information and account settings
                </p>
            </div>

            <a href="{{ route('admin.teachers.index') }}"
               class="btn btn-light border rounded-3">

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
        <form action="{{ route('admin.teachers.update', $teacher->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- FULL NAME -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Full Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $teacher->user->name) }}"
                           class="form-control rounded-3"
                           required>

                </div>

                <!-- EMAIL -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Email Address
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $teacher->user->email) }}"
                           class="form-control rounded-3"
                           required>

                </div>

                <!-- PASSWORD -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        New Password
                    </label>

                    <div class="input-group">

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control rounded-start-3"
                               placeholder="Leave blank to keep current password">

                        <button type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword('password', this)">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                    <small class="text-muted">
                        Optional
                    </small>

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
                               placeholder="Confirm new password">

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
                           value="{{ old('hire_date', \Carbon\Carbon::parse($teacher->hire_date)->format('Y-m-d')) }}"
                           class="form-control rounded-3"
                           required>

                </div>

                <!-- PHONE -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $teacher->phone) }}"
                           class="form-control rounded-3">

                </div>

                <!-- QUALIFICATION -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Qualification
                    </label>

                    <input type="text"
                           name="qualification"
                           value="{{ old('qualification', $teacher->qualification) }}"
                           class="form-control rounded-3"
                           required>

                </div>

                <!-- SALARY -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Salary
                    </label>

                    <input type="number"
                           name="salary"
                           value="{{ old('salary', $teacher->salary) }}"
                           class="form-control rounded-3"
                           min="0"
                           step="0.01"
                           required>

                </div>

                <!-- STATUS -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select name="status"
                            class="form-select rounded-3"
                            required>

                        <option value="active"
                            {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="leave"
                            {{ old('status', $teacher->status) == 'leave' ? 'selected' : '' }}>
                            Leave
                        </option>

                        <option value="inactive"
                            {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <!-- SUBJECTS -->
                <div class="col-md-12">

                    <label class="form-label fw-semibold mb-3">
                        Assigned Subjects
                    </label>

                    <div class="row g-3">

                        @foreach($subjects as $subject)

                            <div class="col-md-3 col-sm-6">

                                <div class="form-check border rounded-3 p-3 bg-light">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="subjects[]"
                                           value="{{ $subject->id }}"
                                           id="subject{{ $subject->id }}"
                                           {{ (is_array(old('subjects', $teacher->subjects->pluck('id')->toArray())) && in_array($subject->id, old('subjects', $teacher->subjects->pluck('id')->toArray()))) ? 'checked' : '' }}>

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

            <!-- BUTTON -->
            <div class="mt-5 d-flex gap-2">

                <button type="submit"
                        class="btn btn-success px-4 py-2 rounded-3">

                    <i class="bi bi-save me-1"></i>
                    Update Teacher

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