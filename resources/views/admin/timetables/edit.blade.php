@extends('layouts.admin')

@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">✏️ Edit Timetable</h3>

        <a href="{{ route('timetables.index') }}" class="btn btn-light">
            Back
        </a>
    </div>

    <form action="{{ route('timetables.update', $timetable->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Class</label>

                <select name="class_id" class="form-select" required>

                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ $timetable->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Subject</label>

                <select name="subject_id" class="form-select" required>

                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ $timetable->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->subject_name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Teacher</label>

                <select name="teacher_id" class="form-select" required>

                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ $timetable->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Day</label>

                <select name="day" class="form-select" required>

                    <option value="Monday" {{ $timetable->day == 'Monday' ? 'selected' : '' }}>Monday</option>

                    <option value="Tuesday" {{ $timetable->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>

                    <option value="Wednesday" {{ $timetable->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>

                    <option value="Thursday" {{ $timetable->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>

                    <option value="Friday" {{ $timetable->day == 'Friday' ? 'selected' : '' }}>Friday</option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Time</label>

                <select name="time" class="form-select" required>

                    <option {{ $timetable->time == '9:00 - 10:30' ? 'selected' : '' }}>
                        9:00 - 10:30
                    </option>

                    <option {{ $timetable->time == '10:30 - 12:00' ? 'selected' : '' }}>
                        10:30 - 12:00
                    </option>

                    <option {{ $timetable->time == '12:30 - 2:00' ? 'selected' : '' }}>
                        12:30 - 2:00
                    </option>

                    <option {{ $timetable->time == '2:00 - 3:30' ? 'selected' : '' }}>
                        2:00 - 3:30
                    </option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Room</label>

                <input type="text"
                       name="room"
                       class="form-control"
                       value="{{ $timetable->room }}">
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-success px-4">
                Update Timetable
            </button>
        </div>

    </form>

</div>

@endsection