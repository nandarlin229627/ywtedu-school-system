@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary: #4361ee;
        --surface: #ffffff;
        --bg: #f5f7fb;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg);
    }

    .attendance-content-wrapper {
        padding: 12px 0;
        min-height: 100vh;
        background:
            radial-gradient(circle at 10% 10%, #eef2ff 0%, transparent 35%),
            radial-gradient(circle at 90% 20%, #ecfeff 0%, transparent 40%),
            var(--bg);
    }

    h4.fw-bold {
        font-size: 1.5rem;
        letter-spacing: -0.02em;
    }

    .glass-card {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(226,232,240,0.8);
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }

    .filter-bar {
        display: flex;
        gap: 12px;
        padding: 14px;
        border-radius: 18px;
        background: rgba(248, 250, 252, 0.8);
        border: 1px solid #e2e8f0;
        max-width: 400px;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .custom-table thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        color: #64748b;
        padding: 0 16px;
        border: none;
    }

    .custom-table tbody tr {
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.015);
        border-radius: 16px;
        transition: all 0.2s ease;
    }

    .custom-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.06);
    }

    .custom-table tbody td {
        padding: 16px;
        border: none;
    }

    .custom-table tbody tr td:first-child {
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }

    .custom-table tbody tr td:last-child {
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    .attendance-toggle {
        display: flex;
        gap: 6px;
        justify-content: center;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 999px;
        max-width: fit-content;
        margin: 0 auto;
    }

    .attendance-toggle input {
        display: none;
    }

    .attendance-toggle label {
        padding: 6px 18px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.8rem;
        cursor: pointer;
        color: #64748b;
        transition: all 0.2s ease;
        margin-bottom: 0;
    }

    .attendance-toggle input[value="Present"]:checked + label {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .attendance-toggle input[value="Late"]:checked + label {
        background: #f59e0b;
        color: white;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .attendance-toggle input[value="Absent"]:checked + label {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }
</style>

<div class="attendance-content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0" style="color: #0f172a;">Teacher Attendance</h4>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f4fbf7 100%); border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 56px; height: 56px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="bi bi-person-check-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase tracking-wider text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Present Today</span>
                        <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.75rem;">{{ $presentCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #fff8f8 100%); border-left: 5px solid #ef4444 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 56px; height: 56px; background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="bi bi-person-dash-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase tracking-wider text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Absent Today</span>
                        <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.75rem;">{{ $absentCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #fffbf2 100%); border-left: 5px solid #f59e0b !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 56px; height: 56px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="bi bi-alarm-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase tracking-wider text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Late Status</span>
                        <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.75rem;">{{ $lateCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f4f7ff 100%); border-left: 5px solid #4361ee !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 56px; height: 56px; background: rgba(67, 97, 238, 0.1); color: #4361ee;">
                        <i class="bi bi-activity fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase tracking-wider text-muted fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Attendance Rate</span>
                        <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.75rem;">{{ $attendanceRate }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <form method="GET" class="filter-bar mb-4">
            <input type="date" name="date" class="form-control border-0 bg-transparent" value="{{ $attendanceDate }}">
            <button class="btn btn-primary px-4 rounded-3 fw-semibold" style="background: var(--primary); border: none;">Load</button>
        </form>

        <form method="POST" action="{{ route('admin.attendance.teacher.store') }}">
            @csrf
            <input type="hidden" name="date" value="{{ $attendanceDate }}">

            <div class="table-responsive">
                <table class="custom-table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Teacher Details</th>
                            <th class="text-center" style="width: 35%;">Attendance Status</th>
                            <th class="text-end" style="width: 25%;">Remark / Note</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-box rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold text-primary me-3" style="width: 40px; height: 40px; font-size: 0.85rem; background: rgba(67, 97, 238, 0.1) !important; flex-shrink: 0;">
                                    {{ strtoupper(substr($teacher->user->name ?? 'TR', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $teacher->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted" style="font-size: 0.8rem;">ID: #{{ $teacher->teacher_no }} | {{ $teacher->phone }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="attendance-toggle">
                                <input type="radio" name="attendance[{{ $teacher->id }}]" value="Present" id="p{{ $teacher->id }}" {{ $teacher->current_status == 'Present' ? 'checked' : '' }}>
                                <label for="p{{ $teacher->id }}">Present</label>

                                <input type="radio" name="attendance[{{ $teacher->id }}]" value="Late" id="l{{ $teacher->id }}" {{ $teacher->current_status == 'Late' ? 'checked' : '' }}>
                                <label for="l{{ $teacher->id }}">Late</label>

                                <input type="radio" name="attendance[{{ $teacher->id }}]" value="Absent" id="a{{ $teacher->id }}" {{ $teacher->current_status == 'Absent' ? 'checked' : '' }}>
                                <label for="a{{ $teacher->id }}">Absent</label>
                            </div>
                        </td>
                        <td class="text-end">
                            <input type="text" name="remark[{{ $teacher->id }}]"
                                   class="form-control form-control-sm border-0 bg-light rounded-3 px-3 py-2 text-end"
                                   style="max-width: 200px; display: inline-block; font-size: 0.85rem;"
                                   value="{{ $teacher->current_remark }}"
                                   placeholder="Add private note...">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted p-5">
                            <div class="mb-2"><i class="bi bi-inboxes fs-1 text-secondary opacity-50"></i></div>
                            No active teachers found.
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($teachers->count() > 0)
            <div class="text-end mt-4">
                <button class="btn btn-primary px-5 py-2.5 rounded-pill shadow-md fw-bold" style="background: var(--primary); border: none;">
                    <i class="bi bi-check-circle-fill me-2"></i> Save Teacher Attendance
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection