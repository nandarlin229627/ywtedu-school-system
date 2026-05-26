@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2 px-sm-3">

    {{-- ALERTS --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-3 small">
            {{ session('error') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3 small">
            {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- HEADER --}}
    <div class="card border-0 shadow-sm p-3 mb-3 rounded-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div>
                <h3 class="fw-bold mb-1">📅 Weekly Timetable Management</h3>
                <p class="text-muted mb-2 small">
                    Manage class schedules, teachers, subjects, and 45-minute slots.
                </p>

                <div class="d-flex flex-wrap gap-2">

                    @if(request('class_id') && $classes->where('id', request('class_id'))->first())
                        @php $selectedClass = $classes->where('id', request('class_id'))->first(); @endphp
                        <span class="badge bg-primary px-3 py-2">
                            🎓 {{ $selectedClass->class_name }}
                        </span>
                    @else
                        <span class="badge bg-secondary px-3 py-2">🎓 All Classes</span>
                    @endif

                    @if(request('teacher_id') && $teachers->where('id', request('teacher_id'))->first())
                        @php $selectedTeacher = $teachers->where('id', request('teacher_id'))->first(); @endphp
                        <span class="badge bg-success px-3 py-2">
                            👨‍🏫 {{ $selectedTeacher->user?->name }}
                        </span>
                    @endif

                    <span class="badge bg-light text-dark border px-3 py-2">
                        📆 {{ now()->format('d M Y') }}
                    </span>

                </div>
            </div>

            <a href="{{ route('admin.timetables.create') }}"
               class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                ➕ Create Timetable
            </a>

        </div>
    </div>


    {{-- FILTER --}}
    <div class="card border-0 shadow-sm p-3 mb-3">
        <form method="GET" action="{{ route('admin.timetables.index') }}">
            <div class="row g-2">

                <div class="col-md-5">
                    <label class="form-label small">Class</label>
                    <select name="class_id" class="form-select form-select-sm">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label small">Teacher</label>
                    <select name="teacher_id" class="form-select form-select-sm">
                        <option value="">All Teachers</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user?->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-2 d-grid d-md-flex align-items-end">
                    <button class="btn btn-dark btn-sm w-100 py-1.5" style="font-size: 0.85rem;">Apply</button>
                </div>

            </div>
        </form>
    </div>


    {{-- ========================= --}}
    {{-- EMPTY STATE OR TABLE --}}
    {{-- ========================= --}}

    @if(request('class_id') || request('teacher_id'))

        {{-- TABLE --}}
        <!-- <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle mb-0"
                       style="table-layout: fixed; min-width: 980px; font-size: 0.8rem;">

                    <thead class="table-primary small">
                        <tr>
                            <th>Day</th>
                            <th>09:00</th>
                            <th>09:45</th>
                            <th>10:30</th>
                            <th>11:15</th>
                            <th>Break</th>
                            <th>01:00</th>
                            <th>01:45</th>
                            <th>02:30</th>
                            <th>03:15</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
                            $times = [
                                '09:00 - 09:45','09:45 - 10:30','10:30 - 11:15',
                                '11:15 - 12:00','12:00 - 01:00',
                                '01:00 - 01:45','01:45 - 02:30',
                                '02:30 - 03:15','03:15 - 04:00'
                            ];
                        @endphp

                        @foreach($days as $day)
                            <tr>
                                <td class="fw-bold bg-light">{{ $day }}</td>

                                @foreach($times as $time)

                                    @php
                                        $slot = $timetables
                                            ->where('day', $day)
                                            ->where('time', $time)
                                            ->first();
                                    @endphp

                                    <td>

                                        @if($time == '12:00 - 01:00')
                                            🍱 Lunch
                                        @elseif($slot)
                                            <div>
                                                <b>{{ $slot->subject?->subject_name }}</b><br>
                                                <small>{{ $slot->teacher?->user?->name }}</small><br>
                                                <small>{{ $slot->schoolClass?->class_name }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif

                                    </td>

                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div> -->








    {{-- TABLE --}}
    <div class="card card-custom border-0 shadow-sm overflow-hidden">
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered text-center align-middle mb-0" style="table-layout: fixed; min-width: 980px; font-size: 0.8 module;">
                <thead class="table-primary small">
                    <tr>
                        <th style="width: 80px;" class="py-2">Day</th>
                        <th style="width: 100px;" class="py-2">09:00 - 09:45</th>
                        <th style="width: 100px;" class="py-2">09:45 - 10:30</th>
                        <th style="width: 100px;" class="py-2">10:30 - 11:15</th>
                        <th style="width: 100px;" class="py-2">11:15 - 12:00</th>
                        <th style="width: 85px;" class="py-2">12:00 - 01:00</th>
                        <th style="width: 100px;" class="py-2">01:00 - 01:45</th>
                        <th style="width: 100px;" class="py-2">01:45 - 02:30</th>
                        <th style="width: 100px;" class="py-2">02:30 - 03:15</th>
                        <th style="width: 100px;" class="py-2">02:15 - 04:00</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    @php
                        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
                        $times = [
                            '09:00 - 09:45', '09:45 - 10:30', '10:30 - 11:15', '11:15 - 12:00',
                            '12:00 - 01:00', '01:00 - 01:45', '01:45 - 02:30', '02:30 - 03:15', '03:15 - 04:00'
                        ];
                    @endphp

                    @foreach($days as $day)
                        <tr>
                            <td class="fw-bold bg-warning bg-opacity-10 text-dark border-end-0 small py-1 px-1">
                                {{ $day }}
                            </td>

                            @foreach($times as $time)
                                @php
                                    $slot = $timetables->where('day', $day)->where('time', $time)->first();
                                @endphp

                                <td class="p-1 style-td-slot">
                                    {{-- BREAK --}}
                                    @if($time == '12:00 - 01:00')
                                        <div class="bg-info bg-opacity-10 text-info border border-info border-opacity-20 py-2 d-flex align-items-center justify-content-center fw-bold rounded flex-column style-break-box">
                                            <span style="font-size: 0.9rem;">🍱</span>
                                            <span style="font-size: 0.65rem; letter-spacing: 0.5px;">LUNCH</span>
                                        </div>
 {{-- SLOT --}}
                                    @elseif($slot)
                                        <div class="p-1 border rounded bg-light d-flex flex-column justify-content-between text-start shadow-2xs h-100">
                                            <div class="lh-sm mb-1" style="text-align:center">
                                                <div class="fw-bold text-primary text-truncate" title="{{ $slot->subject?->subject_name }}" style="font-size: 0.75rem;">
                                                     {{ $slot->subject?->subject_name }}
                                                </div>
                                                <div class="text-success text-truncate my-0.5" style="font-size: 0.7rem;" title="{{ $slot->teacher?->user?->name }}">
                                                     {{ $slot->teacher?->user?->name }}
                                                </div>
                                                <!-- <div class="text-dark opacity-75 text-truncate" style="font-size: 0.7rem;">
                                                    🏫 {{ $slot->room }}
                                                </div> -->

                                                {{-- ⭐️ CLASS NAME (ADDED) --}}
                                                <div class="text-dark text-truncate"
                                                    style="font-size: 0.7rem; opacity: 0.85;">
                                                     {{ $slot->schoolClass?->class_name }}
                                                </div>
                                            </div>

                                            <div class="d-flex gap-1 mt-1 pt-1 border-top align-items-center justify-content-stretch">
                                                <a href="{{ route('admin.timetables.edit', $slot->id) }}"
                                                   class="btn btn-xs btn-light border btn-action flex-grow-1 p-0 m-0 text-center" style="font-size: 0.65rem; line-height: 1.4;">
                                                   Edit
                                                </a>
                                                <form action="{{ route('admin.timetables.destroy', $slot->id) }}" method="POST" class="flex-grow-1 d-grid m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-xs btn-outline-danger btn-action p-0 m-0 text-center" style="font-size: 0.65rem; line-height: 1.4;"
                                                            onclick="return confirm('Delete this slot?')">
                                                        Del
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    {{-- EMPTY --}}
                                    @else
                    
                                         <span>-</span>
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









    @else

        {{-- EMPTY STATE --}}
        <div class="card border-0 shadow-sm p-5 text-center rounded-4">

            <div style="font-size: 50px;">📅</div>

            <h4 class="fw-bold mt-2">No Timetable Selected</h4>

            <p class="text-muted">
                Please select a Class or Teacher to view timetable.
            </p>

            <span class="badge bg-light text-dark border px-3 py-2">
                Use filter above 👆
            </span>

        </div>

    @endif

</div>
@endsection