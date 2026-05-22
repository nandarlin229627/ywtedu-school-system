<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            display: flex;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #111827;
            color: white;
            padding: 20px;
        }

        .sidebar.hide {
            margin-left: -260px;
        }

        .nav-link {
            color: #cbd5e1;
            margin: 8px 0;
            border-radius: 10px;
            padding: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #2563eb;
            color: white;
        }

        /* MAIN */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 25px;
        }

        @media(max-width: 992px) {
            .sidebar {
                margin-left: -260px;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR INCLUDE --}}
    @include('layouts.partials.parent-sidebar')

    {{-- MAIN CONTENT --}}
    <main class="main-content">
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hide");
        }
    </script>

    @stack('scripts')

</body>
</html>