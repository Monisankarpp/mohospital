<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Doctor Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid">
        <!-- Doctor Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 py-3 px-4 bg-white shadow-sm">
            <div>
                <h1 class="h4 fw-semibold text-dark">@yield('page-title', 'Dashboard')</h1>
                <p class="text-muted mb-0">Welcome back, Dr. {{ auth()->user()->name }}</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-3 text-end">
                    <small class="text-muted d-block">Last login</small>
                    <span class="fw-semibold">{{ now()->format('M j, Y h:i A') }}</span>
                </div>
                <div class="avatar avatar-md">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid px-0">
            @yield('dashboard-content')
        </div>
    </div>

    @stack('scripts')
</body>

</html>
