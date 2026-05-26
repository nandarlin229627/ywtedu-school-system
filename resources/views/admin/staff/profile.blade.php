@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        <div class="bg-primary"
            style="height:180px;">
        </div>

        <div class="card-body text-center mt-n5">

            <img src="https://ui-avatars.com/api/?name={{ $staff->name }}"
                class="rounded-circle border border-5 border-white shadow"
                width="120">

            <h3 class="mt-3 fw-bold">
                {{ $staff->name }}
            </h3>

            <p class="text-muted">
                {{ $staff->role }}
            </p>

            <div class="row g-4 mt-4">

                <div class="col-md-3">

                    <div class="card bg-light border-0 rounded-4 p-3">

                        <h6>Staff No</h6>

                        <h5>{{ $staff->staff_no }}</h5>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card bg-light border-0 rounded-4 p-3">

                        <h6>Department</h6>

                        <h5>{{ $staff->department }}</h5>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card bg-light border-0 rounded-4 p-3">

                        <h6>Salary</h6>

                        <h5>
                            MMK {{ number_format($staff->salary) }}
                        </h5>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card bg-light border-0 rounded-4 p-3">

                        <h6>Status</h6>

                        <h5 class="{{ $staff->status == 'active' ? 'text-success' : 'text-warning' }}">

                            {{ ucfirst($staff->status) }}

                        </h5>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection