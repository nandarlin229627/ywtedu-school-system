<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5, #6366f1);
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #312e81;
            --body-bg: #f8fafc;
            --text-main: #334155;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--body-bg); 
            color: var(--text-main); 
            overflow-x: hidden;
        }

        /* Main Content Layout */
        .main { 
            margin-left: 260px; 
            padding: 40px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
        }

        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            margin: 4px 12px;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            transition: transform 0.2s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #f8fafc;
        }

        .sidebar-link:hover i {
            transform: scale(1.05);
        }

        /* Dropdown Submenu Layout */
        .submenu-container {
            margin: 2px 12px 4px 12px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
            padding: 4px 0;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            padding: 10px 24px 10px 48px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .submenu-link:hover {
            color: #f8fafc;
        }

        /* TOPBAR */
        .topbar {
            background: #fff;
            padding: 16px 24px;
            border-radius: 16px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        }

        /* MOBILE TOGGLE */
        .menu-toggle {
            display: none;
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            color: #334155;
            font-size: 20px;
            transition: background 0.2s;
        }

        .menu-toggle:hover {
            background: #f1f5f9;
        }

        /* NOTIFICATION STYLES */
        .noti-dropdown .noti-btn {
            background: #ffffff;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .noti-dropdown .noti-btn:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .noti-dropdown .dropdown-menu {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            padding: 6px;
            width: 320px;
            margin-top: 8px !important;
        }

        .noti-item {
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.85rem;
            color: #334155;
            transition: all 0.15s ease;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .noti-item:hover {
            background-color: #f1f5f9;
        }

        .noti-icon-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Pulse badge effect */
        .badge-pulse {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: pulse 1.6s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        /* USER PROFILE DROPDOWN */
        .user-dropdown .dropdown-toggle {
            background: #ffffff;
            padding: 6px 14px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            color: #334155;
            transition: all 0.2s ease;
        }

        .user-dropdown .dropdown-toggle:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .user-dropdown .avatar-placeholder {
            width: 36px;
            height: 36px;
            background: var(--primary-gradient);
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .user-dropdown .dropdown-menu {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            padding: 6px;
            min-width: 220px;
            margin-top: 8px !important;
        }

        .user-dropdown .dropdown-header, .noti-dropdown .dropdown-header {
            padding: 10px 12px 6px;
        }

        .user-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            color: #475569;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }

        .user-dropdown .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .user-dropdown .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .user-dropdown .dropdown-item form button {
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            color: inherit;
            font-size: inherit;
            font-weight: inherit;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* OVERLAY */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* RESPONSIVE DESIGN BREAKPOINTS */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                margin-left: 0;
                padding: 24px;
                width: 100%;
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="overlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand text-center d-flex flex-column align-items-center justify-content-center">
            <div class="mb-2 d-flex align-items-center justify-content-center" 
                style="width: 88px; height: 88px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; padding: 4px; border: 1px solid rgba(255, 255, 255, 0.1);">
                <img src="{{ asset('images/logo.png') }}" 
                    alt="Logo" 
                    class="img-fluid" 
                    style="border-radius: 10%; width: 100%; height: 100%; object-fit: cover;">
            </div>

            <h6 class="text-white fw-bold mb-0" style="letter-spacing: 0.5px; font-size: 0.95rem;">
                Admin Portal
            </h6>
        </div>

        <nav class="mt-3">
            <a href="{{ url('/dashboard') }}" class="sidebar-link">
                <i class="bi bi-speedometer2 me-3"></i>Dashboard
            </a>

            <a href="{{ url('/admin/students') }}" class="sidebar-link">
                <i class="bi bi-mortarboard-fill me-3"></i>Students
            </a>

            <a href="{{ url('/admin/teachers') }}" class="sidebar-link">
                <i class="bi bi-person-badge-fill me-3"></i>Teachers
            </a>

            <a href="{{ url('/parents') }}" class="sidebar-link">
                <i class="bi bi-people-fill me-3"></i>Parents
            </a>

            <a href="{{ url('/admin/staff') }}" class="sidebar-link">
                <i class="bi bi-briefcase-fill me-3"></i>Staff
            </a>

            <a href="{{ url('/admin/subjects') }}" class="sidebar-link">
                <i class="bi bi-book-half me-3"></i>Subjects
            </a>

            <a href="{{ url('/admin/rooms') }}" class="sidebar-link">
                <i class="bi bi-door-open-fill me-3"></i>Rooms
            </a>

            <a href="{{ url('/admin/classes') }}" class="sidebar-link">
                <i class="bi bi-building-fill me-3"></i>Classes
            </a>

            <a href="{{ url('/admin/timetables') }}" class="sidebar-link">
                <i class="bi bi-calendar-week-fill me-3"></i>Timetable
            </a>

            <div>
                <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#attendanceMenu" role="button" aria-expanded="false">
                    <span>
                        <i class="bi bi-clipboard-check-fill me-3"></i>Attendance
                    </span>
                    <i class="bi bi-chevron-down style-arrow" style="font-size: 0.8rem;"></i>
                </a>

                <div class="collapse submenu-container" id="attendanceMenu">
                    <a href="{{ route('student.attendance') }}" class="submenu-link">
                        <i class="bi bi-circle me-2" style="font-size: 6px;"></i> Student Attendance
                    </a>
                    <a href="{{ route('teacher.attendance') }}" class="submenu-link">
                        <i class="bi bi-circle me-2" style="font-size: 6px;"></i> Teacher Attendance
                    </a>
                </div>
            </div>

            <a href="#" class="sidebar-link">
                <i class="bi bi-wallet2 me-3"></i>Fees
            </a>
        </nav>
    </aside>

    <div class="main">

        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle d-lg-none" id="menuBtn">
                    <i class="bi bi-list"></i>
                </button>

                <h5 class="mb-0 fw-bold text-dark d-none d-sm-block">
                    Admin Dashboard
                </h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                
                <div class="dropdown noti-dropdown">
                    <button class="btn noti-btn position-relative border-0" type="button" id="notiMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="badge-pulse"></span>
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notiMenu">
                        <div class="dropdown-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-1">
                            <span class="text-dark fw-bold" style="font-size: 0.85rem;">Notifications</span>
                            <a href="#" class="text-primary text-decoration-none small fw-semibold" style="font-size: 0.75rem;">Mark all read</a>
                        </div>
                        
                        <li>
                            <a class="dropdown-item noti-item" href="#">
                                <div class="noti-icon-wrapper bg-primary-subtle text-primary">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium text-wrap">New student registered successfully.</p>
                                    <span class="text-muted small" style="font-size: 0.7rem;">5 mins ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item noti-item" href="#">
                                <div class="noti-icon-wrapper bg-warning-subtle text-warning">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium text-wrap">Classroom 3B is reaching capacity limit.</p>
                                    <span class="text-muted small" style="font-size: 0.7rem;">2 hours ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <div class="border-top mt-1 pt-1 text-center">
                            <a href="#" class="dropdown-item text-primary small fw-medium justify-content-center py-2" style="font-size: 0.8rem;">
                                View All Notifications
                            </a>
                        </div>
                    </ul>
                </div>

                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2 border-0" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="text-start d-none d-sm-block me-1">
                            <div class="fw-bold lh-1 mb-1 text-dark" style="font-size: 0.85rem;">{{ Auth::user()->name }}</div>
                            <div class="text-muted small lh-1" style="font-size: 0.75rem;">Administrator</div>
                        </div>
                        <i class="bi bi-chevron-down text-muted small ms-1" style="font-size: 0.75rem;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <div class="dropdown-header">
                            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Account Actions</span>
                        </div>
                        <li>
                            <a class="dropdown-item" href="{{ url('/admin/profile') }}">
                                <i class="bi bi-person text-primary fs-5"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1" style="border-color: #f1f5f9;">
                        </li>
                        <li>
                            <div class="dropdown-item text-danger">
                                <form method="POST" action="{{ route('logout') }}" class="w-100" onsubmit="return confirm('Do you want to logout?')">
                                    @csrf
                                    <button type="submit">
                                        <i class="bi bi-box-arrow-right fs-5"></i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <main>
            @yield('content')
        </main>

    </div>

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