<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Teacher Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('teacher_style.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <style>
        /* --- Root Variables --- */
:root {
    --bg-body: #F3F6FD;
    --primary-purple: #7B61FF;
    --sidebar-bg: #FFFFFF;
    --sidebar-text: #8E92BC;
    --text-dark: #2D2D53;
    --white: #ffffff;
    --border-color: #E8EDF9;
    --transition: all 0.3s ease;
}

/* --- Base Reset --- */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: var(--bg-body);
    display: flex;
    height: 100vh;
    overflow: hidden;
}

/* --- Sidebar Styling --- */
.sidebar {
    width: 260px;
    background: var(--sidebar-bg);
    padding: 30px 20px;
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    height: 100vh;
    transition: var(--transition);
}

.logo {
    font-size: 24px;
    font-weight: 800;
    color: var(--primary-purple);
    margin-bottom: 40px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.nav-menu {
    list-style: none;
    flex-grow: 1;
}

.nav-link {
    text-decoration: none;
    display: block;
    margin-bottom: 8px;
}

.nav-item {
    color: var(--sidebar-text);
    padding: 12px 15px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
    transition: var(--transition);
    cursor: pointer;
}

/* Active State */
.nav-item.active {
    background: var(--primary-purple);
    color: var(--white);
    box-shadow: 0 4px 15px rgba(123, 97, 255, 0.3);
}

.nav-item:hover:not(.active) {
    background: #F0EFFF;
    color: var(--primary-purple);
}

/* --- Main Content & Top Bar --- */
.main-content {
    flex-grow: 1;
    padding: 30px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.top-bar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    width: 100%;
}

.left-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-container {
    flex: 0 1 400px;
    background: white;
    padding: 12px 20px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    border: 1px solid var(--border-color);
}

.search-container input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
}

.user-profile-group {
    display: flex;
    align-items: center;
    gap: 20px;
}

.notif-btn {
    background: white;
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
    border: 1px solid var(--border-color);
    color: #64748b;
    position: relative;
}

.profile-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}

.profile-avatar {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    object-fit: cover;
}

.profile-name {
    color: var(--text-dark);
    font-weight: 700;
}

/* --- Mobile Elements --- */
.mobile-menu-toggle {
    display: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--primary-purple);
    padding: 10px;
}

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 1000;
}

/* --- Responsive Layout (Mobile & Tablet) --- */
@media (max-width: 1024px) {
    .mobile-menu-toggle {
        display: block;
    }

    .sidebar {
        position: fixed;
        left: -280px;
        top: 0;
        z-index: 1100;
    }

    .sidebar.active {
        left: 0;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .main-content {
        padding: 20px;
        width: 100%;
    }

    .search-container {
        flex: 0 1 250px;
    }

    .hide-on-mobile {
        display: none;
    }
}

@media (max-width: 768px) {
    .top-bar-container {
        gap: 10px;
    }

    .search-container {
        display: none; /* ဖုန်းမှာ ရှာရခက်ရင် ဖျောက်ထားနိုင်သည် */
    }

    .profile-name {
        display: none;
    }
}
    </style>
    @stack('styles')

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo"><i class="fas fa-graduation-cap"></i> YWTEDU</div>

        <li>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit"
            onclick="return confirm('Do you want to logout?')"
            style="background:none;border:none;color:red;cursor:pointer;font-size:14px;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</li>

        <ul class="nav-menu">
            <a href="{{ route('dashboard') }}">
                <li class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</li>
            </a>

            <a href="#">
                <li class="nav-item"><i class="fas fa-chalkboard-teacher"></i> My Classes</li>
            </a>

            <a href="#">
                <li class="nav-item"><i class="fas fa-calendar-check"></i> Attendance</li>
            </a>

            <a href="#">
                <li class="nav-item"><i class="fas fa-star"></i> Grades</li>
            </a>
        </ul>
    </aside>

    <!-- MAIN -->
    <main class="main-content">

        @yield('content')

    </main>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>

    @stack('scripts')
</body>
</html>