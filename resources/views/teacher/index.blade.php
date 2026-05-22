@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h1>🎓 Teacher Dashboard</h1>

        <!-- LOGOUT BUTTON -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to logout?')">

                <i class="bi bi-box-arrow-right"></i> Logout

            </button>
        </form>

    </div>

    <div class="card p-4 shadow-sm">

        <h4>Welcome, {{ Auth::user()->name }}</h4>

        <p>This is your Teacher dashboard.</p>

    </div>

</div>

@endsection