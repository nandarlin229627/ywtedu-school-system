<nav class="sidebar" id="sidebar">

    <div class="text-center">
        <img src="{{ asset('logo.png') }}" width="60" class="bg-white p-1 rounded">
        <h6 class="mt-2">YWTEDU</h6>
    </div>

    <ul class="nav flex-column mt-4">

        <li>
            <a class="nav-link active" href="{{ url('parent/dashboard') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
        </li>

        <li>
            <a class="nav-link" href="{{ url('parent/results') }}">
                <i class="bi bi-graph-up"></i> Results
            </a>
        </li>

        <li>
            <a class="nav-link" href="{{ url('parent/attendance') }}">
                <i class="bi bi-calendar-event"></i> Attendance
            </a>
        </li>

        <li>
            <a class="nav-link" href="{{ url('parent/fees') }}">
                <i class="bi bi-credit-card"></i> Fees
            </a>
        </li>

    </ul>
</nav>