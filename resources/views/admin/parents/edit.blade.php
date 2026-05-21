@extends('layouts.admin')

@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Edit Parent</h4>

        <a href="{{ route('parents.index') }}"
           class="btn btn-light">
            Back
        </a>
    </div>

    <form action="{{ route('parents.update', $parent->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label>Name</label>

                <input type="text"
                       name="name"
                       value="{{ $parent->user->name }}"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-6">
                <label>Email</label>

                <input type="email"
                       name="email"
                       value="{{ $parent->user->email }}"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-6">
                <label>Phone</label>

                <input type="text"
                       name="phone"
                       value="{{ $parent->phone }}"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-12">
                <label>Address</label>

                <textarea name="address"
                          class="form-control"
                          rows="4">{{ $parent->address }}</textarea>
            </div>

        </div>

        <div class="mt-4">
            <button class="btn btn-success">
                Update Parent
            </button>
        </div>

    </form>

</div>

@endsection