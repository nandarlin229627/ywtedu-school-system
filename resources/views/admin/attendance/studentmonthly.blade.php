@extends('layouts.admin')

@section('content')
<style>
    :root { 
        --primary: #4361ee; 
        --bg: #f5f7fb; 
    }
    
    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background: var(--bg); 
    }
    
    .report-content-wrapper { 
        padding: 12px 0; 
        min-height: 100vh; 
    }
    
    .glass-card { 
        background: rgba(255,255,255,0.9); 
        backdrop-filter: blur(12px); 
        -webkit-backdrop-filter: blur(12px);
        border-radius: 24px; 
        border: 1px solid rgba(226,232,240,0.7); 
        padding: 22px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.04); 
    }
    
    .filter-bar { 
        display: flex; 
        gap: 12px; 
        padding: 14px; 
        border-radius: 18px; 
        background: #f8fafc; 
        border: 1px solid #e2e8f0; 
    }
    
    /* Table responsive styling with multi-axis sticky anchoring */
    .table-container-scroll { 
        max-height: 600px; 
        overflow: auto; 
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }
    
    .table-container-scroll table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Sticky Headers */
    .table-container-scroll th { 
        position: sticky; 
        top: 0; 
        background: #f8fafc; 
        z-index: 10; 
        font-size: 0.85rem; 
        border-bottom: 2px solid #e2e8f0 !important;
    }
    
    /* Cross-section anchor: Top-left cell header lock */
    .table-container-scroll th:first-child {
        position: sticky;
        left: 0;
        z-index: 12;
        background: #f1f5f9;
    }

    /* Horizontal Column Anchor: Locks student details to the left on side-scrolling */
    .table-container-scroll tbody td:first-child {
        position: sticky;
        left: 0;
        z-index: 8;
        background: #ffffff;
        box-shadow: 4px 0 8px rgba(0,0,0,0.03);
        border-right: 2px solid #e2e8f0 !important;
    }

    /* Keep the row highlight effect correct over our fixed columns */
    .table-container-scroll tbody tr:hover td {
        background-color: #f8fafc;
    }
    
    /* Status Badge Visual Elements */
    .badge-p { background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; }
    .badge-l { background: #fef9c3; color: #854d0e; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; }
    .badge-a { background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; }
    .badge-none { color: #cbd5e1; font-size: 0.75rem; font-weight: 500; }
</style>

<div class="report-content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0" style="color: #0f172a;">Monthly Attendance Report</h4>
        <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold" style="font-size: 0.9rem;">
            <i class="bi bi-arrow-left me-2"></i> Back to Take Attendance
        </a>
    </div>

    <div class="glass-card">
        <form method="GET" action="{{ route('admin.attendance.studentmonthly') }}" class="filter-bar mb-4">
            <select name="class_id" class="form-select border-0 bg-transparent" required>
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                        {{ $class->class_name }}
                    </option>
                @endforeach
            </select>

            <input type="month" name="month" class="form-control border-0 bg-transparent" value="{{ $selectedMonth }}">

            <button class="btn btn-primary px-4 rounded-3 fw-semibold" style="background: var(--primary); border: none;">
                Generate Report
            </button>
        </form>

        @if($selectedClassId && count($students) > 0)
        <div class="table-container-scroll">
            <table class="table table-bordered align-middle text-center" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" style="min-width: 200px;">Student Name</th>
                        <th class="text-success" style="min-width: 45px;">P</th>
                        <th class="text-warning" style="min-width: 45px;">L</th>
                        <th class="text-danger" style="min-width: 45px;">A</th>
                        <th class="table-primary" style="min-width: 65px;">%</th>
                        @foreach($daysInMonth as $day)
                            <th style="min-width: 45px;">{{ $day->format('d') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    @php $data = $reportData[$student->id]; @endphp
                    <tr>
                        <td class="text-start">
                            <div class="fw-bold text-dark">{{ $student->name }}</div>
                            <small class="text-muted">ID: #{{ $student->student_no }}</small>
                        </td>
                        <td class="text-success fw-bold">{{ $data['present'] }}</td>
                        <td class="text-warning fw-bold">{{ $data['late'] }}</td>
                        <td class="text-danger fw-bold">{{ $data['absent'] }}</td>
                        <td>
                            <span class="badge {{ $data['percentage'] >= 75 ? 'bg-success' : 'bg-danger' }} px-2 py-1.5">
                                {{ $data['percentage'] }}%
                            </span>
                        </td>

                        @foreach($daysInMonth as $day)
                            @php 
                                $dateStr = $day->toDateString();
                                $record = $data['records']->get($dateStr);
                            @endphp
                            <td>
                                @if($record)
                                    @if($record->status == 'Present')
                                        <span class="badge-p">P</span>
                                    @elseif($record->status == 'Late')
                                        <span class="badge-l">L</span>
                                    @else
                                        <span class="badge-a">A</span>
                                    @endif
                                @else
                                    <span class="badge-none">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted p-5">
            <div class="mb-3"><i class="bi bi-calendar2-x fs-1 opacity-50"></i></div>
            Select a class and click "Generate Report" to view monthly attendance data.
        </div>
        @endif
    </div>
</div>
@endsection