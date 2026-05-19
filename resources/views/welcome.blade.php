<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YWTEDU - School Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4A90E2;
            --dark: #0B1C39;
        }

        body {
            background: linear-gradient(135deg, #e3ecff, #f9fbff);
            font-family: 'Segoe UI', sans-serif;
            color: var(--dark);
        }

        .navbar {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.7);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.6rem;
            color: var(--primary) !important;
        }

        .hero {
            padding: 110px 15px;
            text-align: center;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.8rem);
            font-weight: 900;
        }

        .hero span {
            color: var(--primary);
        }

        .hero p {
            max-width: 750px;
            margin: 20px auto;
            font-size: 1.1rem;
            color: #555;
        }

        .btn-main {
            background: rgb(234, 172, 14);
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-main:hover {
            background: var(--primary);
            color: white;
        }

        .section {
            padding: 90px 15px;
        }

        .card-box {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .footer {
            background: var(--dark);
            color: white;
            padding: 50px 15px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg px-3">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="logo.png" width="75" class="me-2">
                YWTEDU
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">

                <div class="ms-auto d-flex flex-column flex-lg-row align-items-lg-center gap-3 mt-3 mt-lg-0">

                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone-fill text-primary me-1"></i>
                        <a href="tel:+95977250080" class="text-dark text-decoration-none">
                            +95977250080
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope-fill text-primary me-1"></i>
                        <a href="mailto:leoacademy.mgy@gmail.com" class="text-dark text-decoration-none">
                            leoacademy.mgy@gmail.com
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </nav>


    <!-- HERO -->
    <section class="hero">
        <div class="container">

            <h1>The Smarter Way to <br><span>Manage Your School</span></h1>

            <p>
                YWTEDU is a modern, cloud-based ERP designed to automate admin tasks and
                connect teachers, students, and parents.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <button class="btn btn-main" data-bs-toggle="modal" data-bs-target="#demoModal">
                    Start Free Demo
                </button>

                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Login
                </button>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Why YWTEDU?</h2>
                <p>
                    Traditional school management is slow, paper-based, and inefficient. YWTEDU transforms your
                    institution into a fully digital smart school.
                </p>
            </div>

            <div class="row g-4 text-center">

                <div class="col-md-4">
                    <div class="card-box">
                        <div class="icon"><i class="bi bi-speedometer2"></i></div>
                        <h5>Fast & Efficient</h5>
                        <p>Reduce manual work by 80% with automation.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <div class="icon"><i class="bi bi-shield-lock"></i></div>
                        <h5>Secure System</h5>
                        <p>Role-based access for Admin, Teacher, Student, Parent.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <div class="icon"><i class="bi bi-cloud"></i></div>
                        <h5>Cloud Based</h5>
                        <p>Access your school data anytime, anywhere.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Core Modules</h2>
                <p>Everything your school needs in one system</p>
            </div>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="card-box text-center">
                        <div class="icon"><i class="bi bi-mortarboard"></i></div>
                        <h5>Academics</h5>
                        <p>Courses, exams, grading system, curriculum tracking.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box text-center">
                        <div class="icon"><i class="bi bi-people"></i></div>
                        <h5>Students</h5>
                        <p>Complete student profile & records management.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box text-center">
                        <div class="icon"><i class="bi bi-calendar-check"></i></div>
                        <h5>Attendance</h5>
                        <p>Daily attendance tracking with reports.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box text-center">
                        <div class="icon"><i class="bi bi-cash-stack"></i></div>
                        <h5>Finance</h5>
                        <p>Fee collection, invoices & payment tracking.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-title">
                <h2>How It Works</h2>
                <p>Simple 3-step system to digitize your school</p>
            </div>

            <div class="row text-center g-4">

                <div class="col-md-4">
                    <h1 class="text-primary">1</h1>
                    <h5>Create Account</h5>
                    <p>Register your school and setup admin panel.</p>
                </div>

                <div class="col-md-4">
                    <h1 class="text-primary">2</h1>
                    <h5>Add Data</h5>
                    <p>Import students, teachers, and classes.</p>
                </div>

                <div class="col-md-4">
                    <h1 class="text-primary">3</h1>
                    <h5>Manage Everything</h5>
                    <p>Start managing school digitally in real-time.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- STREAMLINED PRO FOOTER -->
    <footer class="footer pt-5 pb-4" style="background: #0f172a; color: #94a3b8;">
        <div class="container">
            <div class="row g-4 align-items-center">

                <!-- BRAND COLUMN -->
                <div class="col-lg-6 col-md-12 text-center text-lg-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                        <div class="bg-primary rounded-3 me-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-lightning-charge-fill text-white"></i>
                        </div>
                        <h3 class="text-white fw-bold mb-0">YWTEDU</h3>
                    </div>
                    <p class="small pe-lg-5 mb-4">
                        YWTEDU is a modern, cloud-based ERP designed to automate admin tasks and seamlessly connect
                        teachers, students, and parents.
                    </p>

                    <!-- SOCIAL ICONS -->
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a href="https://facebook.com/YWT" class="social-icon" title="Follow YWT on Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://tiktok.com/@YWT" class="social-icon" title="Follow YWT on TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="mailto:leoacademy.mgy@gmail.com" class="social-icon" title="Email Us">
                            <i class="bi bi-envelope-at-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- CONTACT INFO COLUMN -->
                <div class="col-lg-6 col-md-12">
                    <div class="p-4 rounded-4"
                        style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                        <h6 class="text-white fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">Contact
                            Information</h6>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-sm text-primary me-3"><i class="bi bi-geo-alt-fill"></i></div>
                                    <span class="small">Magway, Myanmar</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-sm text-primary me-3"><i class="bi bi-telephone-fill"></i></div>
                                    <span class="small">+95 977 2500 80</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="icon-sm text-primary me-3"><i class="bi bi-envelope-fill"></i></div>
                                    <span class="small">leoacademy.mgy@gmail.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">© 2026 YWTEDU ERP. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <p class="small mb-0">Developed by <span class="text-white fw-bold">YWT1121</span></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- CSS STYLES (Add to your <style> section) -->
    <style>
        .social-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.25rem;
        }

        .social-icon:hover {
            background: #6366f1;
            /* Primary color */
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .icon-sm {
            background: rgba(99, 102, 241, 0.1);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
    </style>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #0B1C39, #4A90E2);">
                    <div>
                        <h5 class="modal-title fw-bold">Welcome Back</h5>
                        <small>Login to YWTEDU Dashboard</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-4">

                    <!-- ✅ LARAVEL LOGIN FORM -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <!-- REMEMBER ME -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn w-100 text-white fw-semibold"
                            style="background: linear-gradient(135deg, #4A90E2, #6C5CE7); padding: 12px; border-radius: 12px;">
                            🔐 Login
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- DEMO MODAL (UNCHANGED SIMPLE) -->
    <div class="modal fade" id="demoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #4A90E2, #6C5CE7);">
                    <div>
                        <h5 class="modal-title fw-bold">Request Free Demo</h5>
                        <small>Fill in your details and we will contact you</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-4">

                    <form>

                        <div class="row g-3">

                            <!-- NAME -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Enter your name">
                                </div>
                            </div>

                            <!-- SCHOOL -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">School Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Enter school name">
                                </div>
                            </div>

                            <!-- PHONE -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="tel" class="form-control" placeholder="+95xxxxxxxxx">
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" placeholder="example@email.com">
                                </div>
                            </div>

                            <!-- MESSAGE -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Message</label>
                                <textarea class="form-control" rows="3"
                                    placeholder="Tell us about your school requirements..."></textarea>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn w-100 mt-4 text-white fw-semibold"
                            style="background: linear-gradient(135deg, #4A90E2, #6C5CE7); padding: 12px; border-radius: 12px;">
                            🚀 Send Request
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>