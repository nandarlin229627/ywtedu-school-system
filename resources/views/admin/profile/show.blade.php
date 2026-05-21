@extends('layouts.admin')

@section('content')

<style>
/* ================= PROFILE MODERN UI ================= */

.profile-wrapper {
    min-height: 100vh;
    background: #f8fafc;
    padding: 2rem 1rem;
}

.profile-card {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #eef2f7;
    transition: 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

.profile-header {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    padding: 1.5rem;
}

.profile-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.profile-body {
    padding: 2rem;
}

.info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 700;
    letter-spacing: 0.08em;
}

.info-value {
    font-size: 1.05rem;
    font-weight: 600;
    color: #0f172a;
}

.badge-role {
    background: #e0e7ff;
    color: #3730a3;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.75rem;
}

.btn-modern {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-modern:hover {
    transform: scale(1.05);
    color: #fff;
    box-shadow: 0 10px 20px rgba(79,70,229,0.3);
}

.divider {
    border-top: 1px solid #eef2f7;
    margin: 1.2rem 0;
}
</style>

<div class="profile-wrapper">

    <div class="container d-flex justify-content-center">

        <div class="col-md-8 col-lg-6">

            <!-- PROFILE CARD -->
            <div class="profile-card">

                <!-- HEADER -->
                <div class="profile-header text-center">

                    <div class="profile-avatar mx-auto">
                        👤
                    </div>

                    <h4 class="mb-0 fw-bold">Admin Profile</h4>
                    <small>Account Information & Security</small>

                </div>

                <!-- BODY -->
                <div class="profile-body">

                    <div class="mb-3">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>

                    <div class="divider"></div>

                    <div class="mb-3">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>

                    <div class="divider"></div>

                    <div class="row">
                        <div class="col-6">
                            <div class="info-label">Role</div>
                            <span class="badge-role">
                                {{ $user->role }}
                            </span>
                        </div>

                        <div class="col-6">
                            <div class="info-label">Joined</div>
                            <div class="info-value">
                                {{ $user->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- ACTION -->
                    <div class="text-end">
                        <a href="{{ route('admin.profile.edit') }}" class="btn-modern">
                            ✏️ Edit Profile
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection