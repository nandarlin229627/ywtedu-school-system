@extends('layouts.admin')

@section('content')
<!-- Include FontAwesome and Google Fonts (Move these to your main layout if possible) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Premium UI Overrides */
    .profile-scope {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 1140px;
        margin: 0 auto;
    }
    
    .custom-card {
        border: 1px solid rgba(243, 244, 246, 1);
        border-radius: 20px;
        background-color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .custom-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.04), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }

    .avatar-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
        margin: 0 auto 1.25rem;
    }

    .avatar-circle {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 700;
        border-radius: 24px;
        box-shadow: 0 10px 20px -3px rgba(79, 70, 229, 0.3);
    }

    .status-indicator {
        position: absolute;
        bottom: -5px;
        right: -5px;
        border: 4px solid #ffffff;
    }
    
    .info-row {
        display: flex;
        align-items: center;
        padding: 14px 12px;
        border-radius: 12px;
        transition: background-color 0.2s ease;
    }

    .info-row:hover {
        background-color: #f9fafb;
    }

    .info-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background-color: #f3f4f6;
        color: #4b5563;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #9ca3af;
        font-weight: 600;
    }
    
    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .badge-subject {
        background: #f5f3ff;
        color: #6d28d9;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 0.85rem;
        border: 1px solid #ede9fe;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .stat-box {
        background-color: #f9fafb;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        transition: border-color 0.2s ease;
    }

    .stat-box:hover {
        border-color: #e5e7eb;
    }
    
    .btn-action {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-back {
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.9rem;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
    }

    .btn-back:hover {
        background: #f9fafb;
        color: #1f2937;
    }
</style>

<div class="container-fluid py-5 profile-scope">

    <!-- TOP HEADER / NAV BAR -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-5 pb-4 border-bottom">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}" class="text-decoration-none text-muted small fw-medium">Teachers</a></li>
                    <li class="breadcrumb-item active text-dark small fw-semibold" aria-current="page">Profile Overview</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Teacher Directory</h3>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-back shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to List
        </a>
    </div>

    <div class="row g-4">
        <!-- LEFT PANEL: CARD & METADATA -->
        <div class="col-lg-4">
            <div class="custom-card p-4 text-center">
                
                <!-- Avatar with dynamic state indicator -->
                <div class="avatar-wrapper">
                    <div class="avatar-circle">
                        {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                    </div>
                    @if(($teacher->status ?? 'active') == 'active')
                        <span class="status-indicator badge rounded-circle bg-success p-2"><span class="visually-hidden">Active</span></span>
                    @else
                        <span class="status-indicator badge rounded-circle bg-warning p-2"><span class="visually-hidden">Inactive</span></span>
                    @endif
                </div>
                
                <h5 class="fw-bold text-dark mb-1">{{ $teacher->user->name }}</h5>
                <!-- <p class="text-muted small mb-4">Employee ID &bull; {{ $teacher->teacher_no }}</p> -->

                <div class="mt-4 text-start">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                        <h6 class="fw-bold text-dark mb-0">Core Information</h6>
                        <span class="badge {{ ($teacher->status ?? 'active') == 'active' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} rounded-pill px-2.5 py-1 fw-bold text-uppercase fs-7">
                            {{ $teacher->status ?? 'active' }}
                        </span>
                    </div>
                    
                    <!-- Email field -->
                    <div class="info-row gap-3">
                        <div class="info-icon-box text-primary bg-primary-subtle">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="text-truncate">
                            <div class="info-label">Email Address</div>
                            <div class="info-value text-break small">{{ $teacher->user->email }}</div>
                        </div>
                    </div>
                    
                    <!-- Phone field -->
                    <div class="info-row gap-3">
                        <div class="info-icon-box text-success bg-success-subtle">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="info-label">Phone Connection</div>
                            <div class="info-value">{{ $teacher->phone ?? '—' }}</div>
                        </div>
                    </div>
                    
                    <!-- Qualifications field -->
                    <div class="info-row gap-3">
                        <div class="info-icon-box text-warning bg-warning-subtle">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="info-label">Qualification</div>
                            <div class="info-value">{{ $teacher->qualification ?? '—' }}</div>
                        </div>
                    </div>
                    
                    <!-- Hire Date field -->
                    <div class="info-row gap-3">
                        <div class="info-icon-box text-info bg-info-subtle">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="info-label">Hired Date</div>
                            <div class="info-value">{{ $teacher->hire_date ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: PERFORMANCE STATS & ASSIGNMENTS -->
        <div class="col-lg-8">
            <div class="custom-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-4">Performance Insights</h5>
                    
                    <!-- STATS DASHBOARD GRID -->
                    <div class="row g-3 mb-5">
                        <div class="col-sm-4">
                            <div class="stat-box d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted small fw-medium">Subjects</span>
                                    <i class="fa-solid fa-book-open text-indigo fs-5" style="color: #4f46e5;"></i>
                                </div>
                                <h3 class="fw-bold mb-0 text-dark">
                                    {{ $teacher->subjects->count() }}
                                </h3>
                            </div>
                        </div>
                        <!-- <div class="col-sm-4">
                            <div class="stat-box d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted small fw-medium">Attendance</span>
                                    <i class="fa-regular fa-circle-check text-success fs-5"></i>
                                </div>
                                <h3 class="fw-bold mb-0 text-success">95%</h3>
                            </div>
                        </div> -->
                        <div class="col-sm-4">
                            <div class="stat-box d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted small fw-medium">Salary</span>
                                    <i class="fa-solid fa-wallet text-warning fs-5"></i>
                                </div>
                                <h4 class="fw-bold mb-0 text-dark text-nowrap">
                                    {{ number_format($teacher->salary ?? 0) }} <span class="fs-7 fw-normal text-muted">MMK</span>
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- FOOTER / ADMINISTRATIVE QUICK ACTIONS -->
                <div class="pt-4 border-top mt-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <!-- <span class="text-muted small"><i class="fa-solid fa-shield-halved me-1.5 opacity-75"></i>Admin Authorization level required to mutate data profiles.</span> -->
                        <div class="d-flex gap-2 w-100 w-md-auto justify-content-end">
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-primary btn-action shadow-sm px-4">
                                <i class="fa-regular fa-pen-to-square me-2"></i>Edit File
                            </a>
                            <button class="btn btn-outline-danger btn-action deleteTeacher" data-id="{{ $teacher->id }}">
                                <i class="fa-regular fa-trash-can me-2"></i>Delete Record
                            </button>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>
@endsection