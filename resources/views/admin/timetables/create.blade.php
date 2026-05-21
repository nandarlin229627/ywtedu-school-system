@extends('layouts.admin')

@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">➕ Create Timetable</h3>

        <a href="{{ route('timetables.index') }}" class="btn btn-light">
            Back
        </a>
    </div>

    <form action="{{ route('timetables.store') }}" method="POST">

        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Class</label>

                <select name="class_id" class="form-select" required>

                    <option value="">Select Class</option>

                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->class_name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Subject</label>

                <select name="subject_id" class="form-select" required>

                    <option value="">Select Subject</option>

                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->subject_name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Teacher</label>

                <select name="teacher_id" class="form-select" required>

                    <option value="">Select Teacher</option>

                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Day</label>

                <select name="day" class="form-select" required>
                    <option value="">Select Day</option>

                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Time</label>

                <select name="time" class="form-select" required>

                    <option value="">Select Time</option>

                    <option>9:00 - 10:30</option>
                    <option>10:30 - 12:00</option>
                    <option>12:30 - 2:00</option>
                    <option>2:00 - 3:30</option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Room</label>

                <input type="text"
                       name="room"
                       class="form-control"
                       placeholder="Example: Lab 2">
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-primary px-4">
                Save Timetable
            </button>
        </div>

    </form>

</div>

@endsection