@extends('layouts.admin')

@section('content')

<style>
/* ================= MODERN DASHBOARD UI ================= */

:root {
    --primary-gradient: linear-gradient(135deg, #4f46e5, #6366f1);
    --success-gradient: linear-gradient(135deg, #10b981, #10b981);
    --warning-gradient: linear-gradient(135deg, #f59e0b, #eab308);
    --danger-gradient: linear-gradient(135deg, #ef4444, #f87171);
}

/* STATS CARDS */
.dash-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.dash-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05);
    border-color: #cbd5e1;
}

.dash-card .card-info p {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.dash-card .card-info h2 {
    margin: 0.25rem 0 0 0;
    font-size: 2.25rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.03em;
}

/* GRADIENT ICONS */
.dash-card .icon-wrapper {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.5rem;
}

.dash-card.blue .icon-wrapper { background: var(--primary-gradient); box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3); }
.dash-card.green .icon-wrapper { background: var(--success-gradient); box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3); }
.dash-card.yellow .icon-wrapper { background: var(--warning-gradient); box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3); }
.dash-card.red .icon-wrapper { background: var(--danger-gradient); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3); }

/* CONTENT BLOCKS (CHART) */
.dash-panel {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    height: 100%;
}

.panel-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 700;
    color: #1e293b;
    font-size: 1rem;
}

.panel-body {
    padding: 1.5rem;
}
</style>

<div class="dash-container">

    <!-- TOP BAR -->
    <div class="dash-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
        <div>
            <h3 class="dash-title">Dashboard</h3>
            <p class="dash-subtitle">School Management Overview</p>
        </div>
        
        <!-- USER ACTIONS DROPDOWN -->
        <!-- <div class="dropdown user-dropdown">
            <button class="btn dropdown-toggle d-flex align-items-center gap-2 border-0" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar-placeholder">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="text-start d-none d-sm-block me-1">
                    <div class="fw-bold lh-1 mb-1 text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                    <div class="text-muted small lh-1" style="font-size: 0.75rem;">Administrator</div>
                </div>
                <i class="bi bi-chevron-down text-muted small ms-1"></i>
            </button>
            
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <div class="dropdown-header">
                    <span class="text-muted text-uppercase fw-bold style" style="font-size: 0.65rem; letter-spacing: 0.05em;">Account Actions</span>
                </div>
                <li>
                    <a class="dropdown-item" href="{{ url('/admin/profile') }}">
                        <i class="bi bi-person text-primary fs-5"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1" style="border-color: #f1f5f9;"></li>
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
        </div> -->
    </div>

    <!-- STATS CARDS -->
    <div class="row g-4">

        <!-- Teachers -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card blue">
                <div class="card-info">
                    <p>Teachers</p>
                    <h2>{{ $teachers }}</h2>
                </div>
                <div class="icon-wrapper">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card green">
                <div class="card-info">
                    <p>Students</p>
                    <h2>{{ $students }}</h2>
                </div>
                <div class="icon-wrapper">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <!-- Parents -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card yellow">
                <div class="card-info">
                    <p>Parents</p>
                    <h2>{{ $parents }}</h2>
                </div>
                <div class="icon-wrapper">
                    <i class="bi bi-person-heart"></i>
                </div>
            </div>
        </div>

        <!-- Staffs -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card red">
                <div class="card-info">
                    <p>Staffs</p>
                    <h2>{{ $staffs }}</h2>
                </div>
                <div class="icon-wrapper">
                    <i class="bi bi-person-workspace"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- LOWER ANALYTICS ROW -->
    <div class="row g-4 mt-2">
        
        <!-- Chart Panel -->
        <div class="col-12">
            <div class="dash-panel">
                <div class="panel-header">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i> Overview Analytics
                </div>
                <div class="panel-body">
                    <div style="position: relative; height:320px; width:100%">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('chart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Teachers', 'Students', 'Parents', 'Staffs'],
            datasets: [{
                data: [
                    {{ $teachers }},
                    {{ $students }},
                    {{ $parents }},
                    {{ $staffs }}
                ],
                backgroundColor: [
                    'rgba(79, 70, 229, 0.85)',  // Deep Indigo
                    'rgba(16, 185, 129, 0.85)', // Teal/Green
                    'rgba(245, 158, 11, 0.85)', // Amber/Yellow
                    'rgba(239, 44, 44, 0.85)'   // Rose/Red
                ],
                borderWidth: 0,
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 32,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { weight: '600' } }
                },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });
});
</script>

@endsection