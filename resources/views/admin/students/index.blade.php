@extends('layouts.admin')

@section('content')
    
    <style>
        /* Responsive Main Container Card */
        .card-custom { 
            background: #ffffff; 
            border-radius: 16px; 
            border: 1px solid #f1f5f9; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); 
            padding: 28px; 
            height: 100%;
        }
        
        /* Modern Stats Cards Enhancements */
        .stat-card-modern {
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            background: #ffffff;
            padding: 20px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(0,0,0,0.05), 0 8px 8px -5px rgba(0,0,0,0.03);
            border-color: #e2e8f0;
        }
        
        /* Gradients using standard crisp modern variations */
        .gradient-primary { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white !important; }
        .gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white !important; }
        .gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white !important; }
        .gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white !important; }

        .class-stat-card { 
            background: #ffffff;
            border-radius: 16px; 
            padding: 20px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0; 
            text-align: center; 
            transition: all 0.2s ease;
        }
        .class-stat-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        /* Table UI/UX Refinement */
        .table-responsive {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead { 
            background: #f8fafc; 
            color: #64748b; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .table th {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .table td { 
            vertical-align: middle; 
            padding: 16px 20px; 
            white-space: nowrap;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        .table tr {
            transition: background-color 0.15s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Inline Dropdown Status Select Styling */
        .status-select {
            border: none;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 6px 24px 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 10px;
            transition: all 0.2s ease;
        }
        
        /* Dynamic Select Background Color based on Value */
        .status-active { background-color: #d1fae5 !important; color: #065f46 !important; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23065f46' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E"); }
        .status-pending { background-color: #fef3c7 !important; color: #92400e !important; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2392400e' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E"); }
        .status-inactive { background-color: #fee2e2 !important; color: #991b1b !important; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23991b1b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E"); }
        
        /* Action Utility Buttons */
        .btn-action-view { background: #f1f5f9; color: #4f46e5; border-radius: 8px; border: none; }
        .btn-action-view:hover { background: #e0e7ff; color: #4338ca; }
        .btn-action-edit { background: #f1f5f9; color: #64748b; border-radius: 8px; padding: .25rem .5rem; display: inline-flex; align-items: center; border: none; }
        .btn-action-edit:hover { background: #e2e8f0; color: #334155; }
        .btn-action-delete { background: #f1f5f9; color: #ef4444; border-radius: 8px; border: none; }
        .btn-action-delete:hover { background: #fee2e2; color: #dc2626; }
        
        .btn-primary { background: #4f46e5; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 500; }
        .btn-primary:hover { background: #4338ca; }
        
        /* Modal Tabs */
        .profile-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }

        /* Shared Sidebar Overlay from Dashboard */
        .sidebar-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.3);
            z-index: 1050;
            backdrop-filter: blur(4px);
            display: none;
        }
        .sidebar-overlay.active { display: block; }

        /* Mobile Student UI Card Refinement */
        @media (max-width: 767px) {
            .main { padding: 15px !important; overflow-x: hidden; }
            .student-mobile-card {
                background: #ffffff;
                border-radius: 14px;
                padding: 18px;
                margin-bottom: 15px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 1px 3px rgba(0,0,0,0.01);
            }
            .student-mobile-card .btn-sm { font-size: 0.8rem; padding: 8px 12px; border-radius: 8px; }
        }

        /* Better Dropdown UX */
        .scrollable-menu {
            max-height: 350px;
            overflow-x: hidden;
            min-width: 220px;
            border-radius: 12px !important;
            padding: 8px;
            border: 1px solid #e2e8f0;
        }
        .dropdown-item { padding: 8px 14px; border-radius: 8px; transition: all 0.2s; font-size: 0.9rem; color: #475569; }
        .dropdown-item:hover { background-color: #f1f5f9; color: #4f46e5; }
        .dropdown-item.active { background-color: #4f46e5 !important; color: white !important; }
        .dropdown-header { text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; font-weight: 700; color: #94a3b8; margin-top: 8px; }
        .btn-white { background: white; font-weight: 500; font-size: 0.9rem; border-color: #cbd5e1; color: #334155; }
        .btn-white:hover { background: #f8fafc; border-color: #cbd5e1; }

        /* Toast Alert CSS */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 1060; }
    </style>
</head>
<body>

    <div class="toast-container">
        <div id="statusToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage"></div>
                <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="overlay"></div>

    <aside class="sidebar" id="sidebar">
       <div class="sidebar-brand">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <h5 class="text-white mt-2">Admin Portal</h5>
        </div>

         <!-- MENU -->
        <nav class="mt-3">

            <!-- DASHBOARD -->
            <a href="{{ url('/dashboard') }}" class="sidebar-link">
                <i class="bi bi-speedometer2 me-3"></i>
                Dashboard
            </a>

            <!-- STUDENTS -->
            <a href="{{ url('/admin/students') }}" class="sidebar-link">
                <i class="bi bi-mortarboard-fill me-3"></i>
                Students
            </a>

            <!-- TEACHERS -->
            <a href="{{ url('/admin/teachers') }}" class="sidebar-link">
                <i class="bi bi-person-badge-fill me-3"></i>
                Teachers
            </a>

            <!-- PARENTS -->
            <a href="{{ url('/parents') }}" class="sidebar-link">
                <i class="bi bi-people-fill me-3"></i>
                Parents
            </a>

            <!-- STAFF -->
            <a href="{{ url('/admin/staff') }}" class="sidebar-link">

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
            <a href="{{ url('/admin/timetables') }}" class="sidebar-link">
                <i class="bi bi-calendar-week-fill me-3"></i>
                Timetable
            </a>

            <!-- ATTENDANCE -->
            <div>

                <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#attendanceMenu">

                    <span>
                        <i class="bi bi-clipboard-check-fill me-3"></i>
                        Attendance
                    </span>

                    <i class="bi bi-chevron-down"></i>

                </a>

                <div class="collapse ps-3" id="attendanceMenu">

                    <a href="{{ route('student.attendance') }}" class="submenu-link">

                        <i class="bi bi-dot"></i>
                        Student Attendance

                    </a>

                    <a href="{{ route('teacher.attendance') }}" class="submenu-link">

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

    <main class="main">
         <!-- TOPBAR -->
        <div class="topbar">

            <!-- MOBILE BUTTON -->
            <button class="menu-toggle" id="menuBtn">

                <i class="bi bi-list"></i>

            </button>

            <h5 class="mb-0 fw-bold">
                Admin Dashboard
            </h5>

            <!-- USER ACTIONS DROPDOWN -->
            <div class="dropdown user-dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center gap-2 border-0" type="button" id="userMenu"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="text-start d-none d-sm-block me-1">
                        <div class="fw-bold lh-1 mb-1 text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}
                        </div>
                        <div class="text-muted small lh-1" style="font-size: 0.75rem;">Administrator</div>
                    </div>
                    <i class="bi bi-chevron-down text-muted small ms-1"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <div class="dropdown-header">
                        <span class="text-muted text-uppercase fw-bold style"
                            style="font-size: 0.65rem; letter-spacing: 0.05em;">Account Actions</span>
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
                            <form method="POST" action="{{ route('logout') }}" class="w-100"
                                onsubmit="return confirm('Do you want to logout?')">
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Student Management</h4>
            <a href="{{ route('admin.students.create') }}" class="btn btn-success d-flex align-items-center gap-2 shadow-sm rounded-3" style="background-color: #10b981; border: none; padding: 10px 18px;">
                <i class="bi bi-plus-lg"></i>
                <span>Add Student</span>
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium d-block mb-1">Total Students</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalStudents }}</h3>
                        </div>
                        <div class="rounded-3 gradient-primary text-white d-none d-sm-block" style="padding: 10px; border-radius: 12px;">
                            <i class="bi bi-people-fill fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium d-block mb-1">Active</span>
                            <h3 class="fw-bold mb-0 text-success">{{ $activeStudents }}</h3>
                        </div>
                        <div class="rounded-3 gradient-success text-white d-none d-sm-block" style="padding: 10px; border-radius: 12px;">
                            <i class="bi bi-person-check-fill fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium d-block mb-1">Pending</span>
                            <h3 class="fw-bold mb-0 text-warning">{{ $pendingStudents }}</h3>
                        </div>
                        <div class="rounded-3 gradient-warning text-white d-none d-sm-block" style="padding: 10px; border-radius: 12px;">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card-modern p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium d-block mb-1">Inactive</span>
                            <h3 class="fw-bold mb-0 text-danger">{{ $inactiveStudents }}</h3>
                        </div>
                        <div class="rounded-3 gradient-danger text-white d-none d-sm-block" style="padding: 10px; border-radius: 12px;">
                            <i class="bi bi-person-x-fill fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h5 class="fw-bold mb-0 text-dark">Directory Overview</h5>
            
            <form action="{{ route('admin.students.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 flex-grow-1 justify-content-md-end" style="max-width: 800px;">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 shadow-sm" placeholder="Search by name or ID..." value="{{ request('search') }}" style="border-color: #dee2e6;">
                </div>

              <div class="dropdown">
    <button class="btn btn-white border shadow-sm dropdown-toggle px-3 rounded-3" type="button" id="classSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-filter-left me-2 text-primary"></i>{{ request('grade') ? request('grade') : 'All Grades' }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 scrollable-menu" aria-labelledby="classSelectDropdown">
        <li>
            <a class="dropdown-item {{ !request('grade') ? 'active' : '' }}" href="{{ route('admin.students.index') }}">All Grades</a>
        </li>
        <li><hr class="dropdown-divider"></li>

        {{-- Grouping Logic: SchoolClass ကို class_name အလိုက် group လုပ်ပြီး ပြသခြင်း --}}
        @foreach($classes->groupBy('class_name') as $gradeName => $sectionsInGrade)
            <li><h6 class="dropdown-header">{{ $gradeName }}</h6></li>
            @foreach($sectionsInGrade as $section)
                <li>
                    <a class="dropdown-item {{ request('grade') == $section->class_name ? 'active' : '' }}" 
                       href="{{ route('admin.students.index', array_merge(request()->query(), ['grade' => $section->class_name])) }}">
                       {{ $section->class_name }} - {{ $section->section }}
                    </a>
                </li>
            @endforeach
        @endforeach
    </ul>
</div>
                
                @if(request('search') || request('grade'))
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light border text-danger rounded-3">
                        <i class="bi bi-x-circle me-1"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-xl-9">
                <div class="card-custom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Student Directory</h5>
                            <p class="text-muted small mb-0">Total {{ $students->total() }} students enrolled this term</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-3" style="border-radius: 10px;">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">Student Name</th>
                                    <th>ID Number</th>
                                    <th>Class</th>
                                    <th>Status (Inline Edit)</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random" width="38" height="38" class="rounded-circle shadow-sm">
                                            <div><div class="fw-semibold text-dark">{{ $student->name }}</div></div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-secondary border fw-medium">#{{ $student->student_no }}</span></td>
                                    <!-- <td>
                                        <span class="fw-medium text-dark">
                                            @if($student->classes->isNotEmpty())
                                                {{ $student->classes->first()->class_name . '-' . $student->classes->first()->section }}
                                            @else
                                                <span class="text-muted fw-normal">{{ $student->grade ?? 'Unassigned' }}</span>
                                            @endif
                                        </span>
                                    </td> -->

                                    <td>
                                        <span class="fw-medium text-dark">
                                            @if($student->schoolClass)
                                                {{ $student->schoolClass->class_name }}{{ $student->schoolClass->section ? '-' . $student->schoolClass->section : '' }}
                                            @else
                                                <span class="text-muted fw-normal">{{ $student->grade ?? 'Unassigned' }}</span>
                                            @endif
                                        </span>
                                    </td>





                                    <td>
                                        <select class="status-select status-{{ $student->status }}" data-student-id="{{ $student->id }}">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->value ?? $status }}" {{ $student->status == ($status->value ?? $status) ? 'selected' : '' }}>
                                                    {{ ucfirst($status->name ?? $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-action-view view-student-btn" data-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#studentDetailModal" title="View Profile">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-action-edit" title="Edit Record">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline mb-0" onsubmit="return confirm('Delete this record?')">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-action-delete" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted fw-medium">
                                        <i class="bi bi-folder-x fs-3 d-block mb-2 text-secondary"></i>
                                        No students found matching the criteria.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-md-none">
                        @forelse($students as $student)
                        <div class="student-mobile-card">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random" width="35" height="35" class="rounded-circle">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">{{ $student->name }}</h6>
                                        <small class="text-muted">#{{ $student->student_no }}</small>
                                    </div>
                                </div>
                                
                                <select class="status-select status-{{ $student->status }}" data-student-id="{{ $student->id }}">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value ?? $status }}" {{ $student->status == ($status->value ?? $status) ? 'selected' : '' }}>
                                            {{ ucfirst($status->name ?? $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <div>
                                    <span class="text-muted small d-block">Class</span>
                                    <span class="fw-medium text-dark small">
                                        @if($student->classes->isNotEmpty())
                                            {{ $student->classes->first()->class_name . '-' . $student->classes->first()->section }}
                                        @else
                                            {{ $student->grade ?? 'Unassigned' }}
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-action-view view-student-btn" data-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#studentDetailModal"><i class="bi bi-eye-fill"></i></button>
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-action-edit"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline mb-0" onsubmit="return confirm('Delete this record?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted fw-medium">No students found.</div>
                        @endforelse
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 px-1 gap-3">
                        <small class="text-muted fw-medium">Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} entries</small>
                        <nav>{{ $students->links('pagination::bootstrap-5') }}</nav>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-3">
                <div class="d-flex flex-column gap-3 h-100">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center bg-white" style="border: 1px solid #e2e8f0 !important;">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-semibold mb-2" style="font-size: 0.8rem; width: fit-content; margin: 0 auto;">
                            Selected Class
                        </span>
                        <h3 class="fw-bold text-dark mb-1" style="font-size: 1.6rem;">{{ $selectedGrade ?? 'All Grades' }}</h3>
                        <p class="text-muted small fw-medium mb-2">Total {{ $gradeTotalStudents ?? 0 }} Students</p>
                        
                        <div class="row g-0 pt-2 border-top">
                            <div class="col-6 border-end">
                                <h5 class="fw-bold text-primary mb-0">{{ $gradeMales ?? 0 }}</h5>
                                <span class="text-muted" style="font-size: 0.7rem;">Males</span>
                            </div>
                            <div class="col-6">
                                <h5 class="fw-bold text-danger mb-0">{{ $gradeFemales ?? 0 }}</h5>
                                <span class="text-muted" style="font-size: 0.7rem;">Females</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2 overflow-auto" style="max-height: 450px; padding-right: 4px;">
                        @foreach($sections as $section)
                        <div class="class-stat-card p-3 d-flex align-items-center justify-content-between text-start" style="border-radius: 12px;">
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Grade {{ $section->class_name }}-{{ $section->section }}</h6>
                                <span class="text-muted small">Section Area</span>
                            </div>
                            <span class="badge bg-light text-dark border fw-semibold" style="font-size: 0.85rem;">
                                {{ $section->students_count }} Studs
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="studentDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold text-dark mb-0">Student Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4" id="modalTargetContainer">
                    <div class="text-center py-4" id="modalLoaderSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="modalProfileContent" class="d-none">
                        <div class="text-center mb-4">
                            <img id="m_avatar" src="" width="80" height="80" class="rounded-circle shadow-sm mb-2">
                            <h5 class="fw-bold text-dark mb-0" id="m_name"></h5>
                            <span class="badge bg-light text-secondary border mt-1" id="m_no"></span>
                        </div>
                        <div class="profile-item">
                            <span class="text-muted small fw-medium">Class / Room</span>
                            <span class="fw-semibold text-dark small" id="m_class"></span>
                        </div>
                        <div class="profile-item">
                            <span class="text-muted small fw-medium">Academic Grade Track</span>
                            <span class="fw-semibold text-dark small" id="m_grade"></span>
                        </div>
                        <div class="profile-item">
                            <span class="text-muted small fw-medium">Current Status</span>
                            <span class="badge" id="m_status_badge"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* =========================
       SIDEBAR TOGGLE
    ========================= */
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (toggleBtn && sidebar && overlay) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        };

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }

    /* =========================
       TOAST FUNCTION
    ========================= */
    function showToast(message, type = 'success') {
        const toastEl = document.getElementById('statusToast');
        const toastMsg = document.getElementById('toastMessage');

        toastEl.className = `toast align-items-center text-white border-0 bg-${type}`;
        toastMsg.textContent = message;

        const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        toast.show();
    }

    /* =========================
       STATUS UPDATE (ALL SELECTS)
    ========================= */
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function () {

            const studentId = this.dataset.studentId;
            const newStatus = this.value;

            if (!newStatus) return;

            // update UI instantly
            this.className = `status-select status-${newStatus.toLowerCase()}`;

            fetch(`/admin/students/${studentId}/update-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(async res => {
                const data = await res.json();

                if (!res.ok) throw new Error(data.message || 'Update failed');

                showToast(data.message || 'Status updated');

                // sync all same student selects (desktop + mobile)
                document.querySelectorAll(`.status-select[data-student-id="${studentId}"]`)
                    .forEach(el => {
                        el.value = newStatus;
                        el.className = `status-select status-${newStatus.toLowerCase()}`;
                    });
            })
            .catch(err => {
                showToast(err.message, 'danger');
            });
        });
    });

    /* =========================
       VIEW STUDENT MODAL
    ========================= */
   /* =========================
   VIEW STUDENT MODAL
========================= */
document.querySelectorAll('.view-student-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const studentId = this.dataset.id;
        const loader = document.getElementById('modalLoaderSpinner');
        const content = document.getElementById('modalProfileContent');

        // 1. Show loading state
        if (loader) loader.classList.remove('d-none');
        if (content) content.classList.add('d-none');

        fetch(`/admin/students/${studentId}`, {
            headers: { 
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Failed to load student');
            return res.json();
        })
        .then(response => {
            // 2. Handle data structure (check if nested in 'data' key)
            const student = response.data || response;

            if (!student || !student.name) {
                throw new Error("Student data is missing or invalid.");
            }

            // 3. Populate Modal Fields
            const avatar = document.getElementById('m_avatar');
            if (avatar) avatar.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(student.name)}&background=random`;

            const nameEl = document.getElementById('m_name');
            if (nameEl) nameEl.textContent = student.name;

            const noEl = document.getElementById('m_no');
            if (noEl) noEl.textContent = `#${student.student_no}`;

            const gradeEl = document.getElementById('m_grade');
            if (gradeEl) gradeEl.textContent = student.grade || 'N/A';

            // Class logic
            const classEl = document.getElementById('m_class');
            if (classEl) {
                if (student.classes && student.classes.length > 0) {
                    classEl.textContent = `${student.classes[0].class_name}-${student.classes[0].section}`;
                } else {
                    classEl.textContent = 'Unassigned';
                }
            }

            // Status Badge logic
            const badge = document.getElementById('m_status_badge');
            if (badge && student.status) {
                badge.textContent = student.status.toUpperCase();
                badge.className = 'badge';
                if (student.status === 'active') badge.classList.add('bg-success');
                else if (student.status === 'pending') badge.classList.add('bg-warning', 'text-dark');
                else badge.classList.add('bg-danger');
            }

            // 4. Show content
            if (loader) loader.classList.add('d-none');
            if (content) content.classList.remove('d-none');
        })
        .catch(err => {
            console.error(err);
            showToast(err.message, 'danger');
            const modal = bootstrap.Modal.getInstance(document.getElementById('studentDetailModal'));
            if (modal) modal.hide();
        });
    });
});

});
</script>
</body>
</html>