@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow rounded-4 border-0">

        <div class="card-header bg-primary text-white">
            <h4>Add Student</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Student No</label>
                        <input type="text" name="student_no" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label>Address</label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>

                </div>

                <button class="btn btn-primary mt-4">
                    Save Student
                </button>
            </form>

        </div>
    </div>
</div>
@endsection