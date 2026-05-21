<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="overlay"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <!-- BRAND -->
    <div class="sidebar-brand text-center">

        <div class="sidebar-logo mb-2">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Logo"
                 width="70">
        </div>

        <h5 class="text-white">
            Admin Portal
        </h5>

    </div>

    <!-- MENU -->
    <nav class="mt-4">

        <!-- DASHBOARD -->
        <a href="{{ url('/dashboard') }}"
           class="sidebar-link">

            <i class="bi bi-grid me-3"></i>
            Dashboard

        </a>

        <!-- STUDENTS -->
        <a href="{{ url('/students') }}"
           class="sidebar-link">

            <i class="bi bi-people me-3"></i>
            Students

        </a>

        <!-- TEACHERS -->
        <a href="{{ url('/teachers') }}"
           class="sidebar-link">

            <i class="bi bi-person-badge me-3"></i>
            Teachers

        </a>

        <!-- PARENTS -->
        <a href="{{ url('/parents') }}"
           class="sidebar-link">

            <i class="bi bi-person-heart me-3"></i>
            Parents

        </a>

        <!-- STAFF -->
        <a href="#"
           class="sidebar-link">

            <i class="bi bi-person-workspace me-3"></i>
            Staffs

        </a>

        <!-- TIMETABLE -->
        <a href="{{ url('/timetables') }}"
           class="sidebar-link">

            <i class="bi bi-calendar3 me-3"></i>
            Timetable

        </a>

        <!-- ATTENDANCE DROPDOWN -->
        <div class="sidebar-dropdown">

            <a class="sidebar-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#attendanceMenu"
               role="button">

                <span>
                    <i class="bi bi-calendar-check me-3"></i>
                    Attendance
                </span>

                <i class="bi bi-chevron-down"></i>

            </a>

            <!-- SUBMENU -->
            <div class="collapse ps-4"
                 id="attendanceMenu">

                <!-- STUDENT ATTENDANCE -->
                <a href="{{ route('student.attendance') }}"
                   class="submenu-link">

                    <i class="bi bi-dot"></i>
                    Student Attendance

                </a>

                <!-- TEACHER ATTENDANCE -->
                <a href="{{ route('teacher.attendance') }}"
                   class="submenu-link">

                    <i class="bi bi-dot"></i>
                    Teacher Attendance

                </a>

            </div>

        </div>

        <!-- FEES -->
        <a href="#"
           class="sidebar-link">

            <i class="bi bi-cash-stack me-3"></i>
            Fees

        </a>

    </nav>

</aside>

<!-- MAIN CONTENT -->
<div class="main">

    @yield('content')

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>