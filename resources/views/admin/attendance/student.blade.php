@extends('layouts.admin')

@section('content')

<style>
.card {
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}
.table th {
    background: #343a40;
    color: white;
}
.alert {
    border-radius: 10px;
    font-weight: 500;
}
</style>

<div class="container">

    <h2 class="mb-3">📅 Student Attendance - {{ $today }}</h2>

    {{-- 🔔 ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 📊 STATS --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card bg-success text-white p-3">
                <h5>Present</h5>
                <h2>{{ $present }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-danger text-white p-3">
                <h5>Absent</h5>
                <h2>{{ $absent }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-dark p-3">
                <h5>Late</h5>
                <h2>{{ $late }}</h2>
            </div>
        </div>

    </div>

    {{-- 🔍 SEARCH / FILTER --}}
    <form method="GET" class="row mb-3">

        <div class="col-md-5">
            <input type="text" name="search"
                   class="form-control"
                   placeholder="🔍 Search student name">
        </div>

        <div class="col-md-4">
            <select name="class_id" class="form-control">
                <option value="">All Classes</option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

    </form>

    {{-- FORM --}}
    <form action="{{ route('student.attendance.store') }}" method="POST">
        @csrf

        <input type="hidden" name="date" value="{{ $today }}">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Late</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($students as $student)

                    @php
                        $status = $attendances[$student->id]->status ?? null;
                    @endphp

                    <tr>
                        <td><strong>{{ $student->user->name ?? $student->name }}</strong></td>

                        <td>
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="Present"
                                   {{ $status == 'Present' ? 'checked' : '' }}>
                        </td>

                        <td>
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="Absent"
                                   {{ $status == 'Absent' ? 'checked' : '' }}>
                        </td>

                        <td>
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="Late"
                                   {{ $status == 'Late' ? 'checked' : '' }}>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            😕 No students found
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <button class="btn btn-success mt-3" id="saveBtn" onclick="loadingState()">
            💾 Save Attendance
        </button>

        <a href="/attendance/monthly" class="btn btn-info mt-3">
            📊 Monthly Report
        </a>

    </form>

</div>

{{-- JS --}}
<script>
function loadingState() {
    let btn = document.getElementById("saveBtn");
    btn.innerHTML = "⏳ Saving...";
    btn.disabled = true;
}

// auto hide alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(a => a.remove());
}, 3000);
</script>

@endsection