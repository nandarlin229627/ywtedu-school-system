@extends('layouts.admin')

@section('content')
<!-- TOP BAR -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">

    <div>
        <h4 class="fw-bold mb-1">Teachers Management</h4>
        <p class="text-muted mb-0">
            Manage all teachers, subjects, and status
        </p>
    </div>

    <div class="d-flex gap-2">

        <!-- Create -->
        <a href="{{ route('teachers.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Add Teacher
        </a>

    </div>

</div>
<!-- STATS -->
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card-custom text-center">
            <h6>Total Teachers</h6>
            <h3>{{ $totalTeachers }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom text-center">
            <h6>Active</h6>
            <h3 class="text-success">{{ $activeTeachers }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom text-center">
            <h6>Leave</h6>
            <h3 class="text-warning">{{ $leaveTeachers }}</h3>
        </div>
    </div>

</div>

<!-- SEARCH & ADD NEW -->
<div class="d-flex justify-content-between mb-3">
    <form class="row g-2 flex-grow-1" style="flex:1;">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control"
                   value="{{ request('search') }}"
                   placeholder="Search teacher...">
        </div>

        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Leave</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    
</div>

<!-- TABLE -->
<div class="card-custom">

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <!-- <th>No</th> -->
                <th>Name</th>
                <th>Subjects</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>

        <tbody>
        @foreach($teachers as $teacher)
            <tr>

                <!-- <td>{{ $teacher->teacher_no }}</td> -->

                <td>
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ $teacher->user->name }}"
                             width="35" class="rounded-circle">
                        {{ $teacher->user->name }}
                    </div>
                </td>

                <td>
                    @foreach($teacher->subjects as $subject)
                        <span class="badge bg-info">{{ $subject->subject_name }}</span>
                    @endforeach
                </td>

               
                <td>
                    <span class="badge bg-success">{{ $teacher->status }}</span>
                </td>

                <td class="text-end">

                    <a href="{{ route('teachers.edit',$teacher->id) }}"
                       class="btn btn-sm btn-light">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <a href="{{ route('teachers.profile',$teacher->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>

                    <button class="btn btn-sm btn-danger deleteTeacher"
                            data-id="{{ $teacher->id }}">
                        <i class="bi bi-trash"></i>
                    </button>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

@endsection

<!-- AJAX DELETE -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).on('click', '.deleteTeacher', function () {

    let id = $(this).data('id');
    let row = $(this).closest('tr');

    if (!confirm('Delete teacher?')) return;

    $.ajax({
        url: '/teachers/' + id,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            row.fadeOut();
        }
    });

});
</script>