@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow rounded-4">

        <div class="card-body p-5">

            <h3 class="fw-bold mb-4">

                Edit Staff

            </h3>

            <form action="{{ route('admin.staff.update', $staff->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">

                        <label>Name</label>

                        <input type="text"
                            name="name"
                            value="{{ $staff->name }}"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Email</label>

                        <input type="email"
                            name="email"
                            value="{{ $staff->email }}"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Salary</label>

                        <input type="number"
                            name="salary"
                            value="{{ $staff->salary }}"
                            class="form-control rounded-3">

                    </div>

                    <div class="col-md-6">

                        <label>Status</label>

                        <select name="status"
                            class="form-select rounded-3">

                            <option value="active"
                                {{ $staff->status == 'active' ? 'selected' : '' }}>

                                Active

                            </option>

                            <option value="leave"
                                {{ $staff->status == 'leave' ? 'selected' : '' }}>

                                Leave

                            </option>

                        </select>

                    </div>

                </div>

                <button class="btn btn-primary mt-4 px-5 rounded-pill">

                    Update Staff

                </button>

            </form>

        </div>

    </div>

</div>

@endsection