<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mo Hospital')</title>

    <!-- Barba.js & GSAP -->
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- Fonts & Icons -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Optional: Flatpickr Theme (e.g., Material Blue) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dde1e7 0%, #f0f2f5 100%);
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px) saturate(150%);
            -webkit-backdrop-filter: blur(12px) saturate(150%);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        .glass-card-header {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px) saturate(150%);
            -webkit-backdrop-filter: blur(8px) saturate(150%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .table-sticky-header>thead>tr>th {
            position: sticky;
            top: -1px;
            background: rgba(248, 249, 250, 0.85);
            backdrop-filter: blur(5px) saturate(150%);
            -webkit-backdrop-filter: blur(5px) saturate(150%);
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }

        .hover-scale:hover {
            transform: translateY(-2px) scale(1.03);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .chartjs-tooltip {
            background: rgba(30, 27, 75, 0.9) !important;
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            border-radius: 0.5rem !important;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }

        /* Custom Button Hover for Manage Slots */
        .manage-slot-button:hover {
            background-color: #ffc107;
            /* Bright yellow for emphasis */
            color: #ffffff !important;
            /* Ensure text remains white */
        }

        /* Icon circle background and size */
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
    </style>
    @stack('style')

</head>

<body class="bg-light" data-barba="wrapper">

    {{-- Navbar --}}
    <div class="d-flex flex-column" style="min-height: 100vh;">
        {{-- Navbar --}}
        @include('layouts.components.navbar') <!-- Include the Navbar component -->

        <div class="d-flex flex-grow-1">
            {{-- Sidebar --}}
            @include('layouts.components.sidebar') <!-- Include the Sidebar component -->

            {{-- Main Content --}}
            <main class="flex-grow-1 p-3" data-barba="container" data-barba-namespace="{{ Route::currentRouteName() }}"
                style="margin-left: 250px; padding-top: 80px;">
                @include('layouts.components.notification')

                {{-- Dynamic Title --}}
                <h1>@yield('title', isset($doctor) ? 'Doctor Dashboard' : 'Patient Dashboard')</h1>

                <div class="container-fluid">
                    {{-- Dashboard Specific Content --}}
                    @yield('dashboard-content')
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
    @stack('scripts')


</body>

</html>
