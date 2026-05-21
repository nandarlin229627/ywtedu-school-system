@extends('layouts.admin')

@section('content')

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card-custom text-center">
            <h6>Total Parents</h6>
            <h3>{{ $totalParents }}</h3>
        </div>
    </div>

</div>

<div class="d-flex justify-content-between mb-3">

    <form class="row g-2 flex-grow-1">

        <div class="col-md-8">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search parent..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                Search
            </button>
        </div>

    </form>

    <div class="ms-3">
        <a href="{{ route('parents.create') }}"
           class="btn btn-success">
            Add Parent
        </a>
    </div>

</div>

<div class="card-custom">

    <table class="table table-hover">

        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($parents as $parent)

            <tr>

                <td>{{ $parent->user->name }}</td>

                <td>{{ $parent->user->email }}</td>

                <td>{{ $parent->phone }}</td>

                <td class="text-end">

                    <a href="{{ route('parents.edit', $parent->id) }}"
                       class="btn btn-sm btn-light">
                        Edit
                    </a>

                    <a href="{{ route('parents.profile', $parent->id) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>

                    <button class="btn btn-sm btn-danger deleteParent"
                            data-id="{{ $parent->id }}">
                        Delete
                    </button>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$(document).on('click', '.deleteParent', function () {

    let id = $(this).data('id');

    let row = $(this).closest('tr');

    if (!confirm('Delete Parent?')) return;

    $.ajax({

        url: '/parents/' + id,

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