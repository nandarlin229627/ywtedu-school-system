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

            {{-- CLASS --}}
            <div class="col-md-6">
                <label class="form-label">Class</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ $timetable->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TEACHER --}}
            <div class="col-md-6">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ $timetable->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SUBJECT --}}
            <div class="col-md-6">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">Select Subject</option>
                </select>
            </div>

            {{-- DAY --}}
            <div class="col-md-6">
                <label class="form-label">Day</label>
                <select name="day" id="day" class="form-select" required>
                    <option value="">Select Day</option>
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                        <option value="{{ $day }}"
                            {{ $timetable->day == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TIME SLOT --}}
            <div class="col-md-6">
                <label class="form-label">Available Time Slots</label>
                <select name="time" id="time_slot" class="form-select" required>
                    <option value="{{ $timetable->time }}">
                        {{ $timetable->time }}
                    </option>
                </select>
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-primary px-4">
                Update Timetable
            </button>
        </div>

    </form>

</div>


{{-- AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    let selectedSubject = "{{ $timetable->subject_id }}";
    let selectedClass = "{{ $timetable->class_id }}";
    let selectedTeacher = "{{ $timetable->teacher_id }}";
    let selectedDay = "{{ $timetable->day }}";

    // ======================
    // TEACHER → SUBJECT (EDIT LOAD)
    // ======================
    function loadSubjects(teacherId) {

        if (!teacherId) return;

        $('#subject_id').html('<option>Loading...</option>');

        $.get('/admin/teacher/' + teacherId + '/subjects', function(data){

            let html = '<option value="">Select Subject</option>';

            data.forEach(function(s){
                let selected = (s.id == selectedSubject) ? 'selected' : '';
                html += `<option value="${s.id}" ${selected}>${s.subject_name}</option>`;
            });

            $('#subject_id').html(html);
        });
    }

    // initial load
    loadSubjects(selectedTeacher);

    $('#teacher_id').on('change', function () {
        loadSubjects($(this).val());
    });


    // ======================
    // CLASS + TEACHER + DAY → TIME SLOTS
    // ======================
    function loadSlots() {

        let classId = $('#class_id').val();
        let teacherId = $('#teacher_id').val();
        let day = $('#day').val();

        if (classId && teacherId && day) {

            $('#time_slot').html('<option>Loading...</option>');

            $.ajax({
                url: '/admin/timetable/available-slots',
                type: 'GET',
                data: {
                    class_id: classId,
                    teacher_id: teacherId,
                    day: day
                },
                success: function (data) {

                    let html = '<option value="">Select Time Slot</option>';

                    data.forEach(function(slot){
                        let selected = (slot == "{{ $timetable->time }}") ? 'selected' : '';
                        html += `<option value="${slot}" ${selected}>${slot}</option>`;
                    });

                    $('#time_slot').html(html);
                }
            });
        }
    }

    $('#class_id, #teacher_id, #day').on('change', loadSlots);

    // auto load slots on page open
    loadSlots();

});
</script>

@endsection