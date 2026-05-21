<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #f3f6fd;
            --purple: #7B61FF;
            --white: #fff;
            --text: #2d2d53;
            --border: #e8edf9;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: Arial;
            background: var(--bg);
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: var(--white);
            border-right: 1px solid var(--border);
            padding: 20px;
            transition: 0.3s;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: var(--purple);
            margin-bottom: 20px;
        }

        .nav-item {
            padding: 10px;
            margin: 5px 0;
            border-radius: 8px;
            display: flex;
            gap: 10px;
            cursor: pointer;
            color: #555;
        }

        .nav-item:hover {
            background: #eeeaff;
            color: var(--purple);
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        /* TOP BAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* CARDS */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .card {
            background: white;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .icon {
            background: #e8e6ff;
            padding: 10px;
            border-radius: 10px;
        }

        /* MODULE SECTION */
        .module {
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        /* MOBILE */
        @media(max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -260px;
                height: 100%;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        .toggle {
            font-size: 20px;
            cursor: pointer;
            color: var(--purple);
        }

        .logout {
            color: red;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

    <div class="logo"><i class="fas fa-graduation-cap"></i> YWTEDU</div>

    <a href="#" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
    <a href="#" class="nav-item"><i class="fas fa-user-tie"></i> Teachers</a>
    <a href="#" class="nav-item"><i class="fas fa-book"></i> Assignments</a>
    <a href="#" class="nav-item"><i class="fas fa-calendar"></i> Leaves</a>
    <a href="#" class="nav-item"><i class="fas fa-money-bill"></i> Salary</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout" onclick="return confirm('Logout?')">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOP BAR -->
    <div class="topbar">
        <div>
            <span class="toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </span>
            <h2>Welcome {{ auth()->user()->name ?? 'Teacher' }}</h2>
        </div>
    </div>

    <!-- DASHBOARD CARDS -->
    <div class="grid">

        <div class="card">
            <div class="icon"><i class="fas fa-users"></i></div>
            <div>
                <h4>Total Students</h4>
                <b>{{ $totalStudents ?? 0 }}</b>
            </div>
        </div>

        <div class="card">
            <div class="icon"><i class="fas fa-book"></i></div>
            <div>
                <h4>Total Classes</h4>
                <b>{{ $totalClasses ?? 0 }}</b>
            </div>
        </div>

        <div class="card">
            <div class="icon"><i class="fas fa-clock"></i></div>
            <div>
                <h4>Today Classes</h4>
                <b>{{ $todayClasses ?? 0 }}</b>
            </div>
        </div>

    </div>

    <!-- TEACHER MANAGEMENT MODULE -->
    <div class="module">
        <h3>Teacher Management</h3>

        <table>
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Class</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>John Doe</td>
                <td>Math</td>
                <td>Grade 10</td>
                <td>Active</td>
            </tr>

            <tr>
                <td>Jane Smith</td>
                <td>English</td>
                <td>Grade 9</td>
                <td>Active</td>
            </tr>
        </table>
    </div>

    <!-- LEAVE + SALARY PREVIEW -->
    <div class="module">
        <h3>Leave & Salary</h3>
        <p><b>Pending Leaves:</b> 2</p>
        <p><b>This Month Salary:</b> $500</p>
    </div>

</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}
</script>

</body>
</html>