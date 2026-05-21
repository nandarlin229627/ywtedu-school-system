@extends('layouts.admin')

@section('content')

<div class="container-fluid">
     {{-- ✅ PUT HERE --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="card-custom mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                <h3 class="fw-bold mb-1">📅 Timetable Manager</h3>
                <small class="text-muted">
                    Optimize and manage weekly class schedules
                </small>
            </div>

            <a href="{{ route('timetables.create') }}" class="btn btn-primary">
                ➕ Create Timetable
            </a>

        </div>
    </div>

    {{-- FILTER --}}
    <div class="card-custom mb-4">

        <form method="GET" action="{{ route('timetables.index') }}">

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Filter By Class</label>

                    <select name="class_id" class="form-select">
                        <option value="">All Classes</option>

                        @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Filter By Teacher</label>

                    <select name="teacher_id" class="form-select">
                        <option value="">All Teachers</option>

                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user?->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-dark w-100">
                        🔍 Filter
                    </button>
                </div>

            </div>

        </form>

    </div>

    {{-- TIMETABLE TABLE --}}
    <div class="card-custom">

        <div class="table-responsive">

            <table class="table table-bordered text-center align-middle">

                <thead class="table-primary">
                    <tr>
                        <th>Day</th>
                        <th>9:00 - 10:30</th>
                        <th>10:30 - 12:00</th>
                        <th>12:00 - 12:30</th>
                        <th>12:30 - 2:00</th>
                        <th>2:00 - 3:30</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

                        $times = [
                            '9:00 - 10:30',
                            '10:30 - 12:00',
                            '12:00 - 12:30',
                            '12:30 - 2:00',
                            '2:00 - 3:30'
                        ];
                    @endphp

                    @foreach($days as $day)
                        <tr>

                            <td class="fw-bold bg-warning">
                                {{ $day }}
                            </td>

                            @foreach($times as $time)

                                @php
                                    $slot = $timetables
                                        ->where('day', $day)
                                        ->where('time', $time)
                                        ->first();
                                @endphp

                                <td style="min-width:180px; height:120px;">

                                    {{-- LUNCH BREAK --}}
                                    @if($time === '12:00 - 12:30')
                                        <div class="bg-info text-white fw-bold p-2 rounded">
                                            🍱 Lunch Break
                                        </div>

                                    {{-- CLASS SLOT --}}
                                    @elseif($slot)

                                        <div class="border rounded p-2 bg-light" style="text-align:center">

                                            <h6 class="fw-bold text-primary mb-1">
                                                {{ $slot->subject?->subject_name ?? 'N/A' }}
                                            </h6>

                                            <div>
                                                <strong>Teacher:</strong>
                                                {{ $slot->teacher?->user?->name ?? 'N/A' }}
                                            </div>

                                            <div class="mt-1">
                                                <strong>Class:</strong>
                                                {{ $slot->schoolClass?->class_name ?? 'N/A' }}
                                            </div>

                                            <div class="mt-1">
                                                <strong>Room:</strong>
                                                {{ $slot->room ?? 'N/A' }}
                                            </div>

                                            <div class="mt-2 d-flex gap-2 justify-content-center">

                                                <a href="{{ route('timetables.edit', $slot->id) }}"
                                                   class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>

                                                <form action="{{ route('timetables.destroy', $slot->id) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete timetable?')">
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    {{-- EMPTY SLOT → ADD BUTTON --}}
                                    @else
                                        <a href="{{ route('timetables.create', ['day' => $day, 'time' => $time]) }}"
                                           class="btn btn-sm btn-outline-primary w-100">
                                            ➕ Add 
                                        </a>
                                    @endif

                                </td>

                            @endforeach

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection