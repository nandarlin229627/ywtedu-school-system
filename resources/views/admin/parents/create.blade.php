@extends('layouts.admin')

@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Add Parent</h4>

        <a href="{{ route('parents.index') }}"
           class="btn btn-light">
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>
        </div>
    @endif

    <form action="{{ route('parents.store') }}"
          method="POST">

        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label>Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-6">
                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-6">
                <label>Phone</label>

                <input type="text"
                       name="phone"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-12">
                <label>Address</label>

                <textarea name="address"
                          class="form-control"
                          rows="4"></textarea>
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-primary">
                Save Parent
            </button>
        </div>

    </form>

</div>

@endsection