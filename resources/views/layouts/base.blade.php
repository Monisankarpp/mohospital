<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mo Hospital')</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Barba.js & GSAP -->
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>

<body class="bg-light" data-barba="wrapper">
    {{-- Navbar --}}
    @include('layouts.components.navbar')

    <div class="d-flex flex-grow-1">
        {{-- Sidebar --}}
        @include('layouts.components.sidebar')

        {{-- Main Content --}}
        <main class="flex-grow-1 p-3" data-barba="container" data-barba-namespace="{{ Route::currentRouteName() }}">
            @include('layouts.components.notification')

            <div class="container-fluid">
                @yield('header')
                <div class="bg-white rounded shadow-sm p-4 transition-content">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Page Transition Animation -->
    <script>
        barba.init({
            transitions: [{
                name: 'fade-slide',
                once(data) {
                    gsap.from('.transition-content', {
                        y: 30,
                        opacity: 0,
                        duration: 0.4,
                        ease: 'power2.out'
                    });
                },
                async leave(data) {
                    await gsap.to(data.current.container.querySelector('.transition-content'), {
                        y: -20,
                        opacity: 0,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                },
                enter(data) {
                    gsap.from(data.next.container.querySelector('.transition-content'), {
                        y: 30,
                        opacity: 0,
                        duration: 0.4,
                        ease: 'power2.out'
                    });
                }
            }]
        });
    </script>

    @yield('scripts')
</body>

</html>
