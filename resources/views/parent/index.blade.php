@extends('layouts.parent')

@section('content')

<div class="container py-4">

<div class="dropdown-item text-danger">
                        <form method="POST" action="{{ route('logout') }}" class="w-100" onsubmit="return confirm('Do you want to logout?')">
                            @csrf
                            <button type="submit">
                                <i class="bi bi-box-arrow-right fs-5"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>

    <h3>👨‍👩‍👧 Parent Dashboard</h3>

    @foreach($students as $student)

        <div class="card p-3 mb-3">

            <h4>👶 {{ $student->name }}</h4>

            {{-- CLASSES --}}
            <p>
                🏫 Class:
                @foreach($student->classes as $class)
                    <span class="badge bg-primary">{{ $class->name }}</span>
                @endforeach
            </p>

            {{-- ATTENDANCE --}}
            <p>📊 Total Attendance: {{ $student->attendances->count() }}</p>

            <p>✅ Present: {{ $student->attendances->where('status','present')->count() }}</p>

            <p>❌ Absent: {{ $student->attendances->where('status','absent')->count() }}</p>

           

        </div>

    @endforeach

</div>

@endsection