@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card-custom p-4">

        <h4 class="fw-bold mb-4">
            Teacher Attendance
        </h4>

        <form action="{{ route('teacher.attendance.store') }}"
              method="POST">

            @csrf

            <div class="mb-4">

                <input type="date"
                       name="date"
                       value="{{ $today }}"
                       class="form-control"
                       required>

            </div>

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>Teacher</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($teachers as $teacher)

                    @php

                        $attendance = $attendances
                            ->where('teacher_id', $teacher->id)
                            ->first();

                    @endphp

                    <tr>

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <img
                                  src="https://ui-avatars.com/api/?name={{ $teacher->user->name }}"
                                  width="35"
                                  class="rounded-circle">

                                {{ $teacher->user->name }}

                            </div>

                        </td>

                        <td>

                            <select
                              name="attendance[{{ $teacher->id }}]"
                              class="form-select">

                                <option value="Present"
                                  {{ optional($attendance)->status == 'Present' ? 'selected' : '' }}>
                                    Present
                                </option>

                                <option value="Absent"
                                  {{ optional($attendance)->status == 'Absent' ? 'selected' : '' }}>
                                    Absent
                                </option>

                                <option value="Late"
                                  {{ optional($attendance)->status == 'Late' ? 'selected' : '' }}>
                                    Late
                                </option>

                            </select>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            <button class="btn btn-primary">
                Save Attendance
            </button>

        </form>

    </div>

</div>

@endsection