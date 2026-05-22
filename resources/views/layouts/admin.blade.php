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

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f5f7fb;
            overflow-x:hidden;
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar{
            width:260px;
            height:100vh;
            background:#111827;
            position:fixed;
            top:0;
            left:0;
            z-index:1000;
            overflow-y:auto;
            transition:0.3s ease;
        }

        .sidebar-brand{
            padding:20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }

        .sidebar-link{
            display:flex;
            align-items:center;
            padding:14px 20px;
            color:#d1d5db;
            text-decoration:none;
            transition:0.2s;
            font-size:15px;
        }

        .sidebar-link:hover{
            background:#1f2937;
            color:#fff;
        }

        .submenu-link{
            display:block;
            padding:10px 20px;
            color:#cbd5e1;
            text-decoration:none;
            font-size:14px;
        }

        .submenu-link:hover{
            color:#fff;
        }

        /* MAIN CONTENT */
        .main{
            margin-left:260px;
            padding:20px;
            transition:0.3s ease;
            min-height:100vh;
        }

        /* TOPBAR */
        .topbar{
            background:#fff;
            padding:15px 20px;
            border-radius:12px;
            margin-bottom:20px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        /* MOBILE TOGGLE */
        .menu-toggle{
            display:none;
            border:none;
            background:none;
            font-size:24px;
        }

        /* OVERLAY */
        .sidebar-overlay{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.5);
            z-index:999;
            display:none;
        }

        .sidebar-overlay.show{
            display:block;
        }

        /* MOBILE */
        @media(max-width:992px){

            .sidebar{
                left:-260px;
            }

            .sidebar.show{
                left:0;
            }

            .main{
                margin-left:0;
                width:100%;
                padding:15px;
            }

            .menu-toggle{
                display:block;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="overlay"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <!-- BRAND -->
    <div class="sidebar-brand text-center">

        <img src="{{ asset('images/logo.png') }}"
             width="70"
             class="mb-2">

        <h5 class="text-white fw-bold">
            Admin Portal
        </h5>

    </div>

    <!-- MENU -->
    <nav class="mt-3">

        <!-- DASHBOARD -->
        <a href="{{ url('/dashboard') }}" class="sidebar-link">
            <i class="bi bi-speedometer2 me-3"></i>
            Dashboard
        </a>

        <!-- STUDENTS -->
        <a href="{{ url('/students') }}" class="sidebar-link">
            <i class="bi bi-mortarboard-fill me-3"></i>
            Students
        </a>

        <!-- TEACHERS -->
        <a href="{{ url('/teachers') }}" class="sidebar-link">
            <i class="bi bi-person-badge-fill me-3"></i>
            Teachers
        </a>

        <!-- PARENTS -->
        <a href="{{ url('/parents') }}" class="sidebar-link">
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
        <a href="{{ url('/admin/subjects') }}" class="sidebar-link">
            <i class="bi bi-book-half me-3"></i>
            Subjects
        </a>

        <!-- ROOMS -->
        <a href="{{ url('/admin/rooms') }}" class="sidebar-link">
            <i class="bi bi-door-open-fill me-3"></i>
            Rooms
        </a>

        <!-- CLASSES -->
        <a href="{{ url('/admin/classes') }}" class="sidebar-link">
            <i class="bi bi-building-fill me-3"></i>
            Classes
        </a>

        <!-- TIMETABLE -->
        <a href="{{ url('/timetables') }}" class="sidebar-link">
            <i class="bi bi-calendar-week-fill me-3"></i>
            Timetable
        </a>

        <!-- ATTENDANCE -->
        <div>

            <a class="sidebar-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#attendanceMenu">

                <span>
                    <i class="bi bi-clipboard-check-fill me-3"></i>
                    Attendance
                </span>

                <i class="bi bi-chevron-down"></i>

            </a>

            <div class="collapse ps-3" id="attendanceMenu">

                <a href="{{ route('student.attendance') }}"
                   class="submenu-link">

                    <i class="bi bi-dot"></i>
                    Student Attendance

                </a>

                <a href="{{ route('teacher.attendance') }}"
                   class="submenu-link">

                    <i class="bi bi-dot"></i>
                    Teacher Attendance

                </a>

            </div>

        </div>

        <!-- FEES -->
        <a href="#" class="sidebar-link">
            <i class="bi bi-wallet2 me-3"></i>
            Fees
        </a>

    </nav>

</aside>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <!-- MOBILE BUTTON -->
        <button class="menu-toggle"
                id="menuBtn">

            <i class="bi bi-list"></i>

        </button>

        <h5 class="mb-0 fw-bold">
            Admin Dashboard
        </h5>

        <div>
            {{ auth()->user()->name }}
        </div>

    </div>

    <!-- PAGE CONTENT -->
    @yield('content')

</div>

<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

<script>

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');

    menuBtn.addEventListener('click', () => {

        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');

    });

    overlay.addEventListener('click', () => {

        sidebar.classList.remove('show');
        overlay.classList.remove('show');

    });

</script>

</body>
</html>