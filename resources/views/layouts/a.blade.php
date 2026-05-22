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

    <style>
        body {
            background: #f5f7fb;
            overflow-x: hidden;
        }

        .main {
            margin-left: 260px;
            padding: 25px;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #111827;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 25px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #d1d5db;
            text-decoration: none;
            transition: 0.2s;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .sidebar-link.active {
            background: #2563eb;
            color: #fff;
        }

        .submenu-link {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 14px;
        }

        .submenu-link:hover {
            color: #fff;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }

        @media(max-width: 992px) {

            .sidebar {
                left: -260px;
                transition: 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                margin-left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 999;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }

        }
    </style>
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

        <h5 class="text-white fw-bold">
            Admin Portal
        </h5>

    </div>

    <!-- MENU -->
    <nav class="mt-3">

        <!-- DASHBOARD -->
        <a href="{{ url('/dashboard') }}"
           class="sidebar-link">

            <i class="bi bi-speedometer2 me-3"></i>
            Dashboard

        </a>

        <!-- STUDENTS -->
        <a href="{{ url('/students') }}"
           class="sidebar-link">

            <i class="bi bi-mortarboard-fill me-3"></i>
            Students

        </a>

        <!-- TEACHERS -->
        <a href="{{ url('/teachers') }}"
           class="sidebar-link">

            <i class="bi bi-person-badge-fill me-3"></i>
            Teachers

        </a>

        <!-- PARENTS -->
        <a href="{{ url('/parents') }}"
           class="sidebar-link">

            <i class="bi bi-people-fill me-3"></i>
            Parents

        </a>

        <!-- STAFF -->
        <a href="#"
           class="sidebar-link">

            <i class="bi bi-briefcase-fill me-3"></i>
            Staffs

        </a>

        <!-- SUBJECTS -->
        <a href="{{ url('/admin/subjects') }}"
           class="sidebar-link">

            <i class="bi bi-book-half me-3"></i>
            Subjects

        </a>

        <!-- ROOMS -->
        <a href="{{ url('/admin/rooms') }}"
           class="sidebar-link">

            <i class="bi bi-door-open-fill me-3"></i>
            Rooms

        </a>

        <!-- CLASSES -->
        <a href="{{ url('/admin/classes') }}"
           class="sidebar-link">

            <i class="bi bi-building-fill me-3"></i>
            Classes

        </a>

        <!-- TIMETABLE -->
        <a href="{{ url('/timetables') }}"
           class="sidebar-link">

            <i class="bi bi-calendar-week-fill me-3"></i>
            Timetable

        </a>

        <!-- ATTENDANCE -->
        <div class="sidebar-dropdown">

            <a class="sidebar-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#attendanceMenu"
               role="button">

                <span>
                    <i class="bi bi-clipboard-check-fill me-3"></i>
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

            <i class="bi bi-wallet2 me-3"></i>
            Fees

        </a>

        <!-- SETTINGS -->
        <a href="#"
           class="sidebar-link">

            <i class="bi bi-gear-fill me-3"></i>
            Settings

        </a>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="sidebar-link border-0 bg-transparent w-100 text-start">

                <i class="bi bi-box-arrow-right me-3"></i>
                Logout

            </button>
        </form>

    </nav>

</aside>

<!-- MAIN CONTENT -->
<div class="main">

    @yield('content')

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
</script>

</body>
</html>