@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">

        <h4 class="fw-bold">Parent Profile</h4>

        <a href="{{ route('parents.index') }}"
           class="btn btn-light">
            Back
        </a>

    </div>

    <div class="row">

        <div class="col-md-4">

            <div class="card-custom text-center p-4">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($parent->user->name) }}"
                    class="rounded-circle mb-3"
                    width="120">

                <h5>{{ $parent->user->name }}</h5>

                <p>{{ $parent->user->email }}</p>

                <hr>

                <div class="text-start">

                    <p>
                        <strong>Phone:</strong>
                        {{ $parent->phone }}
                    </p>

                    <p>
                        <strong>Address:</strong>
                        {{ $parent->address }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection