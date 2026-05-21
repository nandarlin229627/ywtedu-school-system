@extends('layouts.admin')

@section('content')

<style>
/* ================= PROFILE EDIT UI ================= */

.edit-wrapper {
    background: #f8fafc;
    min-height: 100vh;
    padding: 2rem 1rem;
}

.edit-card {
    max-width: 650px;
    margin: auto;
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #eef2f7;
    box-shadow: 0 12px 30px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: 0.3s ease;
}

.edit-card:hover {
    transform: translateY(-3px);
}

.edit-header {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 1.5rem;
    text-align: center;
}

.edit-header h3 {
    margin: 0;
    font-weight: 700;
}

.edit-body {
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #475569;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 10px 12px;
    transition: 0.2s;
}

.form-control:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.15rem rgba(16,185,129,0.15);
}

.btn-save {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s;
    width: 100%;
}

.btn-save:hover {
    transform: scale(1.03);
    box-shadow: 0 10px 20px rgba(16,185,129,0.25);
}
</style>

<div class="edit-wrapper">

    <div class="edit-card">

        <!-- HEADER -->
        <div class="edit-header">
            <h3>✏️ Edit Admin Profile</h3>
            <small>Update your account information</small>
        </div>

        <!-- BODY -->
        <div class="edit-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PATCH')

                <!-- NAME -->
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text"
                           name="name"
                           value="{{ $user->name }}"
                           class="form-control"
                           required>
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email"
                           name="email"
                           value="{{ $user->email }}"
                           class="form-control"
                           required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">New Password (optional)</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Leave blank to keep current password">
                </div>

                <button type="submit" class="btn-save">
                    💾 Save Changes
                </button>

            </form>

        </div>

    </div>

</div>

@endsection