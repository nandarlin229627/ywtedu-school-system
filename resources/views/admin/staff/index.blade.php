@extends('layouts.admin')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Staff Management</h2>
            <p class="text-muted">Modern School Staff Dashboard</p>
        </div>

        <a href="{{ route('admin.staff.create') }}"
            class="btn btn-primary rounded-pill px-4">

            + Add Staff

        </a>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-lg rounded-4 p-4 bg-primary text-white">

                <h6>Total Staff</h6>

                <h2>{{ $totalStaff }}</h2>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow rounded-4 p-4">

                <h6>Active Staff</h6>

                <h2 class="text-success">
                    {{ $activeStaff }}
                </h2>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow rounded-4 p-4">

                <h6>Leave Staff</h6>

                <h2 class="text-warning">
                    {{ $leaveStaff }}
                </h2>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body">

            <table class="table align-middle table-hover">

                <thead>

                    <tr>

                        <th>Staff</th>

                        <th>Staff No</th>

                        <th>Department</th>

                        <th>Salary</th>

                        <th>Attendance</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($staffs as $staff)

                    <tr>

                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <img src="https://ui-avatars.com/api/?name={{ $staff->name }}"
                                    class="rounded-circle"
                                    width="50">

                                <div>

                                    <div class="fw-bold">
                                        {{ $staff->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $staff->role }}
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>

                            <span class="badge bg-primary">
                                {{ $staff->staff_no }}
                            </span>

                        </td>

                        <td>{{ $staff->department }}</td>

                        <td>

                            MMK {{ number_format($staff->salary) }}

                        </td>

                        <td width="180">

                            <div class="progress" style="height:10px;">

                                <div class="progress-bar"
                                    style="width:{{ $staff->attendance }}%">
                                </div>

                            </div>

                            <small>
                                {{ $staff->attendance }}%
                            </small>

                        </td>

                        <td>

                            @if($staff->status == 'active')

                            <span class="badge bg-success">
                                Active
                            </span>

                            @else

                            <span class="badge bg-warning text-dark">
                                Leave
                            </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('admin.staff.show', $staff->id) }}"
                                class="btn btn-dark btn-sm">

                                View

                            </a>

                            <a href="{{ route('admin.staff.edit', $staff->id) }}"
                                class="btn btn-primary btn-sm">

                                Edit

                            </a>

                            <form action="{{ route('admin.staff.destroy', $staff->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection