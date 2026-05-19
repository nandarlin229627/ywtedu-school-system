<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YWTEDU Pro Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- External CSS Files - Untouched -->
   <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/topbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fb;
        }

        .main {
            padding: 20px;
        }


        /* Ensure card heights match in a row */
        .card-box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            height: 100%;
        }

        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .bg-blue { background: #4A90E2; }
        .bg-green { background: #2ecc71; }
        .bg-orange { background: #f39c12; }
        .bg-red { background: #e74c3c; }
        .bg-purple { background: #9b59b6; }
        .bg-cyan { background: #1abc9c; }

        .quick-btn {
            background: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: 0.3s;
            cursor: pointer;
            border: 1px solid #eee;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
        }

        .quick-btn:hover {
            transform: translateY(-5px);
            background: #4A90E2;
            color: white;
        }

        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }

        .alert-item {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 0.85rem;
            border-left: 4px solid;
        }

        .profile-info { text-align: right; }
        .profile-name { font-weight: 600; font-size: 0.9rem; line-height: 1; }
        .profile-role { color: #6c757d; font-size: 0.75rem; }
        
        .stat-value { font-size: 1.3rem; font-weight: 700; }
        .stat-label { color: #6c757d; font-size: 0.8rem; }

        /* Responsive Chart Container */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        /* This is likely causing the issue in your topbar.css */
/* Override external CSS to force placeholder visibility */
    .search-box input::placeholder {
        color: #92a0ca !important; /* Forces the color back */
        opacity: 1 !important;
    }

    /* Ensure the search box doesn't shrink too much on mobile */
    @media (max-width: 576px) {
        .search-box {
            width: 150px !important; /* Gives enough room for the text */
        }
        .search-box input {
            padding-left: 30px !important; /* Adjust icon spacing */
            font-size: 0.9rem !important;
        }
    }
    </style>
</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="overlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo"><img src="{{ asset('images/logo.png') }}"  alt="Logo"></div>
            <h5 class="text-white mt-2">Admin Portal</h5>
        </div>
        <nav>
            <a href="index.html" class="active"><i class="bi bi-grid me-3"></i> Dashboard</a>
            <a href="students.html"><i class="bi bi-people me-3"></i> Students</a>
            <a href="teachers.html"><i class="bi bi-person-badge me-3"></i> Teachers</a>
            <a href="parents.html"><i class="bi bi-person-heart me-3"></i> Parents</a>
            <a href="staffs.html"><i class="bi bi-person-heart me-3"></i> Staffs</a>
            <a href="timetable.html"><i class="bi bi-calendar3 me-3"></i> Timetable</a>
            <a href="attendance.html"><i class="bi bi-calendar-check me-3"></i> Attendance</a>
            <a href="fees.html"><i class="bi bi-cash-stack me-3"></i> Fees</a>
        </nav>
    </aside>

    <div class="main">
        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <!-- Mobile Toggle Button -->
                <button class="btn btn-light d-lg-none" id="toggleBtn">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="fw-bold m-0 d-none d-sm-block">Dashboard Overview</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Takes up more space on desktop, less on mobile -->
<!-- Visible on all devices -->
<div class="search-box">
    <input type="text" class="form-control rounded-pill" placeholder="Search student/staff...">
</div>
                <div class="position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </div>
                <div class="dropdown">
                    <div class="d-flex align-items-center gap-2" role="button" data-bs-toggle="dropdown">
                        <div class="profile-info d-none d-sm-block">
                            <div class="profile-name">{{ Auth::user()->name }}</div>
                            <!-- <span>{{ Auth::user()->name }}</span> -->
                            <div class="profile-role">Super Admin</div>
                        </div>
                        <i class="bi bi-person-circle fs-3 text-primary"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <!-- LOGOUT -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
                </div>
            </div>
        </div>

        <!-- 1. OVERALL STATISTICS (Optimized for Mobile/Tablet) -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card-box text-center p-3">
                    <div class="icon-circle bg-blue mx-auto mb-2"><i class="bi bi-people"></i></div>
                    <div class="stat-label">Students</div>
                    <div class="stat-value">1,250</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card-box text-center p-3">
                    <div class="icon-circle bg-green mx-auto mb-2"><i class="bi bi-person-badge"></i></div>
                    <div class="stat-label">Teachers</div>
                    <div class="stat-value">85</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card-box text-center p-3">
                    <div class="icon-circle bg-purple mx-auto mb-2"><i class="bi bi-person-heart"></i></div>
                    <div class="stat-label">Parents</div>
                    <div class="stat-value">1,100</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card-box text-center p-3">
                    <div class="icon-circle bg-cyan mx-auto mb-2"><i class="bi bi-calendar-check"></i></div>
                    <div class="stat-label">Attendance</div>
                    <div class="stat-value">92%</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card-box text-center p-3 border-bottom border-danger border-4">
                    <div class="icon-circle bg-red mx-auto mb-2"><i class="bi bi-cash-stack"></i></div>
                    <div class="stat-label">Pending Fees</div>
                    <div class="stat-value">240</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card-box text-center p-3">
                    <div class="icon-circle bg-orange mx-auto mb-2"><i class="bi bi-door-open"></i></div>
                    <div class="stat-label">Classes</div>
                    <div class="stat-value">42</div>
                </div>
            </div>
        </div>

        <!-- MIDDLE SECTION (CHARTS) -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-xl-8">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="card-box">
                            <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-pie-chart-fill me-2"></i>Attendance Overview</h6>
                            <div class="chart-container">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card-box">
                            <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-success"></i>Fee Status</h6>
                            <div class="chart-container">
                                <canvas id="feeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-box">
                            <h6 class="fw-bold mb-3">Revenue & Growth Trend</h6>
                            <div style="height: 200px;">
                                <canvas id="growthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts & Quick Actions -->
            <div class="col-12 col-xl-4">
                <div class="card-box bg-light border-0">
                    <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-megaphone-fill me-2"></i>Critical Alerts</h6>
                    <div class="alert-item bg-white border-danger shadow-sm">
                        <div class="text-danger fw-bold">Fee Overdue</div>
                        <small>45 students from G-10 unpaid.</small>
                    </div>
                    <div class="alert-item bg-white border-warning shadow-sm">
                        <div class="text-warning fw-bold">Low Attendance</div>
                        <small>Grade 8-B dropped to 75%.</small>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">Quick Actions</h6>
                        <div class="row g-2">
                            <div class="col-6"><a href="#" class="quick-btn"><i class="bi bi-person-plus text-primary"></i><small>Add Student</small></a></div>
                            <div class="col-6"><a href="#" class="quick-btn"><i class="bi bi-person-video3 text-success"></i><small>Add Teacher</small></a></div>
                            <div class="col-6"><a href="#" class="quick-btn"><i class="bi bi-calendar-plus text-info"></i><small>Attendance</small></a></div>
                            <div class="col-6"><a href="#" class="quick-btn"><i class="bi bi-wallet2 text-warning"></i><small>Collect Fee</small></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM SECTION -->
        <div class="row g-3">
            <div class="col-12 col-lg-6">
                <div class="card-box">
                    <h6 class="fw-bold mb-3">Recent Activities</h6>
                    <div class="activity-item d-flex justify-content-between">
                        <span><i class="bi bi-plus-circle-fill text-success me-2"></i>New student added</span>
                        <small class="text-muted">2m ago</small>
                    </div>
                    <div class="activity-item d-flex justify-content-between">
                        <span><i class="bi bi-cash text-primary me-2"></i>Fee received</span>
                        <small class="text-muted">15m ago</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card-box">
                    <h6 class="fw-bold mb-3">Upcoming Timetable</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Time</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>09:00 AM</td><td>Mathematics</td><td>10-A</td></tr>
                                <tr><td>11:30 AM</td><td>Physics Lab</td><td>11-B</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // SIDEBAR TOGGLE LOGIC
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.add('show');
            overlay.classList.add('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('active');
        });

        // CHARTS
        const ctxAttendance = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctxAttendance, {
            type: 'doughnut',
            data: {
                labels: ['Stud. Present', 'Stud. Absent', 'Teach. Present', 'Teach. Absent'],
                datasets: [
                    {
                        data: [1100, 150, 0, 0],
                        backgroundColor: ['#2ecc71', '#e74c3c', 'transparent', 'transparent'],
                    },
                    {
                        data: [0, 0, 80, 5],
                        backgroundColor: ['transparent', 'transparent', '#4A90E2', '#f39c12'],
                        weight: 0.6
                    }
                ]
            },
            options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                // This ensures the legend color matches the correct dataset
                generateLabels: function(chart) {
                    const data = chart.data;
                    return data.labels.map((label, i) => {
                        // If index 0 or 1, take color from Dataset 0 (Students)
                        // If index 2 or 3, take color from Dataset 1 (Teachers)
                        const datasetIndex = i < 2 ? 0 : 1;
                        const bgColor = data.datasets[datasetIndex].backgroundColor[i];
                        
                        return {
                            text: label,
                            fillStyle: bgColor,
                            strokeStyle: bgColor,
                            lineWidth: 0,
                            hidden: false,
                            index: i
                        };
                    });
                }
            }
        },
        tooltip: {
            callbacks: {
                // Prevents tooltips from showing for the "transparent" placeholder sections
                label: function(context) {
                    const val = context.raw;
                    if (val === 0) return null;
                    return context.label + ': ' + val;
                }
            }
        }
    }
}
        });

        const ctxFee = document.getElementById('feeChart').getContext('2d');
        new Chart(ctxFee, {
            type: 'bar',
            data: {
                labels: ['Paid', 'Unpaid', 'Pending'],
                datasets: [{ data: [900, 150, 200], backgroundColor: ['#4A90E2', '#e74c3c', '#f39c12'] }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }}}
        });

        const ctxGrowth = document.getElementById('growthChart').getContext('2d');
        new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    { label: 'Revenue', data: [5000, 7000, 6500, 8000, 9500, 12000], borderColor: '#4A90E2', tension: 0.4 },
                    { label: 'New Students', data: [100, 150, 120, 200, 180, 250], borderColor: '#2ecc71', tension: 0.4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>
</body>
</html>