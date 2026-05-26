@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">

    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body p-5">

            <h3 class="fw-bold mb-4">

                Add New Staff

            </h3>

            <form action="{{ route('admin.staff.store') }}"
                method="POST">

                @csrf

                <div class="row g-4">

                    <div class="col-md-6">

                        <label>Name</label>

                        <input type="text"
                            name="name"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Email</label>

                        <input type="email"
                            name="email"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Phone</label>

                        <input type="text"
                            name="phone"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Role</label>

                        <input type="text"
                            name="role"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Department</label>

                        <input type="text"
                            name="department"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Experience</label>

                        <input type="number"
                            name="experience"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Salary</label>

                        <input type="number"
                            name="salary"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Attendance</label>

                        <input type="number"
                            name="attendance"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Status</label>

                        <select name="status"
                            class="form-select rounded-3">

                            <option value="active">
                                Active
                            </option>

                            <option value="leave">
                                Leave
                            </option>

                        </select>

                    </div>

                    <div class="col-12">

                        <label>Address</label>

                        <textarea name="address"
                            class="form-control rounded-3"></textarea>

                    </div>

                </div>

                <button class="btn btn-primary mt-4 px-5 rounded-pill">

                    Save Staff

                </button>

            </form>

        </div>

    </div>

</div>

@endsection