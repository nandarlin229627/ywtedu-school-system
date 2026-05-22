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

            {{-- CLASS --}}
            <div class="col-md-6">
                <label class="form-label">Class</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SECTION (AUTO SHOW ONLY INFO) --}}
            <!-- <div class="col-md-6">
                <label class="form-label">Section</label>
                <input type="text" id="section" class="form-control" readonly placeholder="Auto show">
            </div> -->

            {{-- TEACHER --}}
            <div class="col-md-6">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">
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
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                </select>
            </div>

            {{-- TIME SLOT (DYNAMIC AVAILABLE SLOTS) --}}
            <div class="col-md-6">
                <label class="form-label">Available Time Slots</label>
                <select name="time" id="time_slot" class="form-select" required>
                    <option value="">Select Time Slot</option>
                </select>
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-primary px-4">
                Save Timetable
            </button>
        </div>

    </form>

</div>

{{-- AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // ======================
    // TEACHER → SUBJECT
    // ======================
    $('#teacher_id').on('change', function () {

        let teacherId = $(this).val();

        $('#subject_id').html('<option>Loading...</option>');

        $.get('/admin/teacher/' + teacherId + '/subjects', function(data){

            let html = '<option value="">Select Subject</option>';

            data.forEach(function(s){
                html += `<option value="${s.id}">${s.subject_name}</option>`;
            });

            $('#subject_id').html(html);

        });

    });


    // ======================
    // CLASS + TEACHER + DAY → AVAILABLE TIME SLOTS
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
                        html += `<option value="${slot}">
                                    ${slot}
                                </option>`;
                    });

                    $('#time_slot').html(html);

                }
            });

        }
    }

    $('#class_id, #teacher_id, #day').on('change', loadSlots);

});
</script>

@endsection