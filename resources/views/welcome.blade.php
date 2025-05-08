<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MoHospital - Modern Healthcare Solutions</title>
    <meta name="description"
        content="MoHospital connects patients with top doctors, hospitals, and medical services for comprehensive healthcare solutions.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper + Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/GLTFLoader.js"></script>



    <style>
        :root {
            --primary-blue: #004e92;
            --dark-blue: #000428;
            --accent-gold: #ffd700;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.5rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            padding-bottom: 5px !important;
        }

        .nav-link:hover {
            color: var(--accent-gold) !important;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--accent-gold);
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .btn-outline-light {
            margin-left: 0.5rem;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-light {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            background-color: white;
            color: var(--primary-blue) !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 78, 146, 0.9), rgba(0, 4, 40, 0.9)), url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .hero-btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 0 10px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            bottom: -10px;
            left: 25%;
            background-color: var(--accent-gold);
        }

        .feature-card {
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }

        .stats-section {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            padding: 80px 0;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .testimonial-card {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-gold);
        }

        .footer {
            background-color: var(--dark-blue);
            color: white;
            padding: 0px 0 30px;
        }

        .footer-links h5 {
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-links h5:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--accent-gold);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent-gold);
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: var(--accent-gold);
            color: var(--dark-blue);
            transform: translateY(-3px);
        }

        /* This for booking model */
        .bg-primary-soft {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        .bg-info-soft {
            background-color: rgba(16, 185, 129, 0.1) !important;
        }

        .bg-success-soft {
            background-color: rgba(34, 197, 94, 0.1) !important;
        }

        .bg-gray-50 {
            background-color: #f9fafb !important;
        }

        .date-item {
            width: 60px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .time-slot {
            transition: all 0.2s ease;
        }

        .time-slot:hover {
            transform: translateY(-2px);
        }

        .step {
            transition: all 0.3s ease;
        }

        .step.active .rounded-circle {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }

        /* end */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital"></i> MoHospital
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#doctors">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                </ul>

                <!-- Show Login/Register buttons for guests (users not logged in) -->
                @guest
                    <div class="d-flex ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                        <a href="{{ route('register.form') }}" class="btn btn-light ms-2">Register</a>
                    </div>
                @endguest

                <!-- Show Dashboard button for authenticated users (logged in) -->
                @auth
                    <div class="d-flex ms-lg-3">
                        <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Your Health Is Our Priority</h1>
            <p class="hero-subtitle">Connecting you to the best healthcare professionals and facilities in the country
            </p>
            <div class="d-flex justify-content-center flex-wrap">
                <a href="#doctors" class="btn btn-light hero-btn">BOOK APPOINTMENT</a>
            </div>
        </div>
    </section>


    <!-- Services Section -->
    <section id="services" class="py-5 my-5">
        <div class="container">
            <h2 class="section-title text-center">Our Services</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>Doctor Appointments</h3>
                        <p>Book consultations with top specialists in various fields from the comfort of your home.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <div class="feature-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h3>Hospital Services</h3>
                        <p>Find and connect with the best hospitals for your treatment and care needs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <div class="feature-icon">
                            <i class="fas fa-prescription-bottle-alt"></i>
                        </div>
                        <h3>Pharmacy</h3>
                        <p>Order medicines online and get them delivered to your doorstep.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stat-number">500+</div>
                    <p>Qualified Doctors</p>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stat-number">100+</div>
                    <p>Partner Hospitals</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">50K+</div>
                    <p>Happy Patients</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">24/7</div>
                    <p>Support Available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <div class="container mt-n5">
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-body p-4">
                <form action="" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label text-muted">Search Doctors</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-primary"></i>
                                </span>
                                <input type="text" name="search" class="form-control form-control-lg border-start-0"
                                    placeholder="Name or specialty..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted">Specialization</label>
                            <select name="specialization" class="form-select form-select-lg">
                                <option value="">All Specialties</option>
                                @foreach ($specializations as $specialization)
                                    <option value="{{ $specialization }}"
                                        {{ request('specialization') == $specialization ? 'selected' : '' }}>
                                        {{ $specialization }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted">Availability</label>
                            <select name="status" class="form-select form-select-lg">
                                <option value="">Any Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Available
                                </option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Unavailable
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                                <i class="fas fa-filter me-2"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Doctors Listing -->
    <section id="doctors" class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #1e3a8a;">Our Healthcare Specialists</h2>
                <p class="lead" style="color: #4b5563;">Meet our team of board-certified physicians</p>
                <div class="divider"
                    style="height: 4px; width: 80px; background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%); margin: 10px auto; border-radius: 2px;">
                </div>
            </div>

            @if ($doctors->count() > 0)
                <div class="row g-4">
                    @foreach ($doctors as $doctor)
                        @php
                            $avatarUrl = "https://picsum.photos/seed/doctor-{$doctor->id}-person/600/400?grayscale";
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-lg"
                                style="transition: all 0.3s ease; border-top: 4px solid #3b82f6;">
                                <div class="position-relative" style="height: 280px; overflow: hidden;">
                                    <img src="{{ $avatarUrl }}" alt="Dr. {{ $doctor->user->name }}"
                                        class="img-fluid w-100 h-100 object-cover" style="filter: brightness(0.95);">
                                    <div class="position-absolute bottom-0 end-0 m-3">
                                        <span class="badge rounded-full px-3 py-2 text-sm font-semibold shadow-sm"
                                            style="background-color: #10b981; color: white;">
                                            {{ $doctor->specialization }}
                                        </span>
                                    </div>
                                    <div
                                        class="position-absolute top-0 left-0 w-full h-full bg-gradient-to-t from-gray-900/20 to-transparent">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="card-title mb-1 font-semibold" style="color: #1e3a8a;">Dr.
                                                {{ $doctor->user->name }}</h4>
                                            <p class="mb-2 text-sm" style="color: #6b7280;">
                                                <i class="fas fa-stethoscope me-2" style="color: #3b82f6;"></i>
                                                {{ $doctor->specialization }}
                                            </p>
                                            <div class="d-flex align-items-center mb-2 text-sm">
                                                <i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>
                                                <span
                                                    style="color: #6b7280;">{{ $doctor->location ?? 'Main Hospital' }}</span>
                                            </div>
                                            <div class="star-rating text-sm" style="color: #f59e0b;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star{{ $i > rand(3, 5) ? '-half-alt' : '' }}"></i>
                                                @endfor
                                                <span class="ms-1" style="color: #6b7280;">({{ rand(15, 200) }}
                                                    reviews)</span>
                                            </div>
                                        </div>
                                        <span class="badge rounded-full px-3 py-1 text-xs font-semibold"
                                            style="background-color: {{ $doctor->status ? '#10b981' : '#ef4444' }}; color: white;">
                                            {{ $doctor->status ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between align-items-center mt-4 pt-2 border-t border-gray-100">
                                        @auth
                                            <button class="btn rounded-full px-4 py-2 text-sm font-medium shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#bookModal"
                                                data-doctor-id="{{ $doctor->id }}"
                                                style="background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%); color: white; border: none;">
                                                <i class="fas fa-calendar-check me-1"></i> Book Now
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="btn rounded-full px-4 py-2 text-sm font-medium border shadow-sm"
                                                style="background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%); color: white; border: none;">
                                                <i class="fas fa-calendar-check me-1"></i> Book Now
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 my-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" alt="No doctors found"
                        style="height: 150px; opacity: 0.7; filter: grayscale(50%) brightness(0.8);" class="mb-4">
                    <h3 class="text-gray-600">No doctors available</h3>
                    <p class="text-gray-500">Please try again later or contact our support</p>
                    <a href="{{ url()->current() }}"
                        class="btn mt-3 rounded-full px-4 py-2 text-sm font-medium shadow-sm"
                        style="background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%); color: white;">
                        <i class="fas fa-sync-alt me-2"></i> Refresh
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $doctors->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden"
                style="border: 1px solid rgba(0,0,0,0.1);">

                <!-- Modal Header with Gradient -->
                <div class="modal-header border-0 py-4"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                            <i class="fas fa-calendar-check text-primary fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title text-white fw-semibold mb-0">Schedule Appointment</h5>
                            <p class="text-white-50 small mb-0" id="modalSubtitle">Select date & time</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Form Start -->
                <form method="POST" action="{{ route('appointments.book') }}" id="bookingForm">
                    @csrf
                    <input type="hidden" name="doctor_id" id="modalDoctorId">
                    <input type="hidden" name="date" id="selectedDate">
                    <input type="hidden" name="slot_id" id="selectedTimeSlot">

                    <div class="modal-body bg-gray-50 p-0">

                        <!-- Doctor Profile Section -->
                        <div class="px-4 pt-4">
                            <div
                                class="d-flex align-items-center bg-white rounded-3 p-3 shadow-sm border-start border-4 border-primary">
                                <i class="fas fa-user-md fa-3x text-primary rounded-circle border border-3 border-white shadow-sm"
                                    style="margin-right: -15px; z-index: 2; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;"></i>

                                <div class="flex-grow-1 ms-3 ps-3 border-start">
                                    <h6 id="modalDoctorName" class="mb-1 fw-bold text-dark fs-5">Dr.
                                        {{ $doctor->user->name }}
                                        <span class="badge bg-success bg-opacity-10 text-success ms-2 fw-normal">
                                            <i class="fas fa-circle-check"></i> Verified
                                        </span>
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <span class="badge bg-primary-soft text-primary rounded-pill fw-normal">
                                            <i class="fas fa-user-md me-1"></i>
                                            <span id="modalDoctorSpecialty">{{ $doctor->specialization }}</span>
                                        </span>
                                        <span class="badge bg-info-soft text-info rounded-pill fw-normal">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <span id="modalDoctorLocation">India</span>
                                        </span>
                                        <span class="badge bg-success-soft text-success rounded-pill fw-normal">
                                            <i class="fas fa-star me-1"></i>
                                            <span id="modalDoctorRating">{{ rand(1, 5) }} </span>
                                            ( {{ rand(40, 1000) }} reviews)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date Picker Section -->
                        <div class="px-4 pt-4">
                            <div class="bg-white rounded-3 shadow-sm p-3 mb-3 border">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 fw-semibold text-dark">
                                        <i class="far fa-calendar text-primary me-2"></i> Select Date
                                    </h6>
                                    <span class="badge bg-light text-muted fw-normal small" id="currentMonth">May
                                        2025</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <button type="button"
                                        class="btn btn-light btn-icon rounded-circle shadow-sm scroll-left"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <div class="date-scroll-wrapper d-flex overflow-auto flex-nowrap px-2"
                                        style="gap: 8px;">
                                        <!-- Dates will be loaded here -->
                                        <div class="text-center py-3 text-muted w-100">
                                            <i class="fas fa-spinner fa-spin me-2"></i> Loading available dates...
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="btn btn-light btn-icon rounded-circle shadow-sm scroll-right"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Time Slot Section -->
                        <input type="hidden" id="selectedTimeSlot" name="slot_id">
                        <input type="hidden" id="selectedStartTime" name="start_time">
                        <input type="hidden" id="selectedEndTime" name="end_time">

                        <div class="px-4 pt-2">
                            <div class="bg-white rounded-3 shadow-sm p-3 mb-3 border">
                                <h6 class="mb-3 fw-semibold text-dark">
                                    <i class="far fa-clock text-primary me-2"></i> Available Time Slots
                                </h6>
                                <div class="time-slots-wrapper">
                                    <div class="alert alert-info rounded-3 border-0 mb-0" id="timeSlotHelp">
                                        <i class="fas fa-info-circle me-2"></i> Please select a date to view available
                                        time slots
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 py-1" id="timeSlotsContainer"
                                        style="display: none;">
                                        <!-- Time slots will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Information (Collapsible) -->
                        <div class="px-4 pt-1">
                            <div class="accordion" id="patientInfoAccordion">
                                <div class="accordion-item border-0 rounded-3 shadow-sm">
                                    <h2 class="accordion-header" id="patientInfoHeading">
                                        <button class="accordion-button collapsed bg-white rounded-3 shadow-none"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#patientInfoCollapse">
                                            <i class="fas fa-user-circle text-primary me-2"></i>
                                            <span class="fw-semibold">Patient Notes
                                                (Optional)</span>
                                        </button>
                                    </h2>
                                    <div id="patientInfoCollapse" class="accordion-collapse collapse"
                                        aria-labelledby="patientInfoHeading">
                                        <div class="accordion-body pt-3">
                                            <div class="mb-3">
                                                <textarea class="form-control rounded-3" id="patientNotes" name="patient_notes" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Validation Error -->
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 mx-4 mt-3 border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">Booking Error</h6>
                                        <p class="small mb-0">{{ $errors->first() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer bg-gray-50 border-0 px-4 pb-4 pt-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium"
                            data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-medium shadow-sm"
                            id="confirmBookingBtn" disabled>
                            <span id="submitText"><i class="fas fa-calendar-check me-2"></i> Confirm
                                Appointment</span>
                            <span id="submitLoading" style="display: none;">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                <!-- Modal Header -->
                <div class="modal-header border-0 py-4"
                    style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                    <h5 class="modal-title text-white fw-semibold">Review Appointment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body bg-gray-50 px-4 pt-4">
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="mb-0 fw-semibold"><i class="fas fa-receipt me-2 text-primary"></i>Appointment
                                Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="text-muted">Doctor:</span></p>
                                    <p class="fw-semibold" id="reviewDoctorName">Loading...</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="text-muted">Date:</span></p>
                                    <p class="fw-semibold" id="reviewDate">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="text-muted">Time:</span></p>
                                    <p class="fw-semibold" id="reviewTime">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="text-muted">Fee:</span></p>
                                    <p class="fw-semibold" id="reviewFee">$100</p>
                                </div>
                                <div class="col-12">
                                    <p class="mb-1"><span class="text-muted">Notes:</span></p>
                                    <p class="fw-semibold" id="reviewNotes">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="mb-3 fw-semibold"><i class="fas fa-credit-card me-2 text-primary"></i>Payment
                            Method</h6>
                        <div class="mb-3">
                            <label class="form-label">Card Number</label>
                            <div id="card-number-element" class="form-control p-3 rounded-3 shadow-sm border"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expiry Date</label>
                            <div id="card-expiry-element" class="form-control p-3 rounded-3 shadow-sm border"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CVC</label>
                            <div id="card-cvc-element" class="form-control p-3 rounded-3 shadow-sm border"></div>
                        </div>
                        <div id="card-errors" class="text-danger small mt-2" role="alert"></div>


                        <!-- Payment security badges -->
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <!-- Stripe -->
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/stripe.svg" width="40"
                                alt="Stripe" title="Stripe">
                            <!-- Visa -->
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/visa.svg" width="40"
                                alt="Visa" title="Visa">
                            <!-- Mastercard -->
                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/mastercard.svg"
                                width="40" alt="Mastercard" title="Mastercard">

                        </div>
                    </div>
                    <div class="alert alert-warning border-0 rounded-3 d-flex align-items-center">
                        <i class="fas fa-clock me-3 fs-4"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">Time remaining</h6>
                            <p class="mb-0">
                                <span id="paymentTimer" class="fw-bold">29:59</span> to complete payment
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-gray-50 border-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2"
                        data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-2"></i> Back to booking
                    </button>
                    <button id="payNowBtn" class="btn btn-success rounded-pill px-4 py-2 shadow-sm"
                        data-appointment-id="">
                        <i class="fas fa-lock me-2"></i> Pay <span id="paymentAmount">$100</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Model --}}
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content text-center border-0 rounded-4 shadow-lg">
                <div class="modal-body py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold mb-2">Payment Successful!</h5>
                    <p class="text-muted">Appointment is confirmed. You’ll receive an email shortly.</p>
                    <button class="btn btn-success rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Testimonials -->
    <section id="about" class="py-5 my-5">
        <div class="container">
            <h2 class="section-title text-center">What Our Patients Say</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Patient"
                                class="testimonial-img me-3">
                            <div>
                                <h5 class="mb-0">Lisa Thompson</h5>
                                <small class="text-muted">Heart Patient</small>
                            </div>
                        </div>
                        <p>"MoHospital connected me with the perfect cardiologist. The online booking system saved
                            me
                            hours of waiting time. Highly recommended!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Patient"
                                class="testimonial-img me-3">
                            <div>
                                <h5 class="mb-0">Michael Brown</h5>
                                <small class="text-muted">Diabetes Patient</small>
                            </div>
                        </div>
                        <p>"The pharmacy service is a game-changer. My medications arrive on time every month
                            without
                            fail. Excellent customer support too."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Patient"
                                class="testimonial-img me-3">
                            <div>
                                <h5 class="mb-0">Sarah Wilson</h5>
                                <small class="text-muted">Pediatric Care</small>
                            </div>
                        </div>
                        <p>"Finding a good pediatrician was so easy with MoHospital. The doctor was patient with my
                            child and very knowledgeable. 5 stars!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <hr class="mt-5 mb-4" style="border-color: rgba(255,255,255,0.1);">
        <div class="text-center">
            <p class="mb-0">&copy; 2025 MoHospital. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.boxShadow = 'none';
            }
        });


        // booking model
        document.addEventListener("DOMContentLoaded", function() {
            const dateScrollWrapper = document.querySelector('.date-scroll-wrapper');
            let currentDoctorId = null;
            let availableDates = [];
            let slotsByDate = {};
            let currentScrollPosition = 0;
            const dateItemWidth = 120;

            document.querySelectorAll('[data-bs-target="#bookModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    currentDoctorId = this.getAttribute('data-doctor-id');
                    document.getElementById('modalDoctorId').value = currentDoctorId;
                    fetchAvailableDates(currentDoctorId);
                });
            });

            function fetchAvailableDates(doctorId) {
                fetch(`/get-available-dates/${doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        availableDates = data.dates || [];
                        slotsByDate = data.slots || {};
                        renderDateItems();
                    })
                    .catch(err => console.error('Fetch error:', err));
            }

            function renderDateItems() {
                dateScrollWrapper.innerHTML = '';
                availableDates.forEach(date => {
                    const slots = slotsByDate[date] || [];
                    const bookedCount = slots.filter(s => s.status === 1).length;
                    let statusClass = 'btn-success';

                    if (bookedCount === slots.length) {
                        statusClass = 'btn-danger';
                    } else if (bookedCount > 0) {
                        statusClass = 'btn-warning';
                    }

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `btn ${statusClass} btn-sm mx-1 rounded-pill date-item`;
                    btn.textContent = new Date(date).toDateString();
                    btn.setAttribute('data-date', date);
                    btn.addEventListener('click', () => {
                        document.getElementById('selectedDate').value = date;
                        highlightSelectedDate(btn);
                        renderTimeSlots(slotsByDate[date], date);
                    });

                    dateScrollWrapper.appendChild(btn);
                });
            }

            function highlightSelectedDate(selectedBtn) {
                document.querySelectorAll('.date-item').forEach(btn => {
                    btn.classList.remove('active', 'btn-outline-dark');
                });
                selectedBtn.classList.add('active', 'btn-outline-dark');
            }

            function renderTimeSlots(slots, date) {
                const timeWrapper = document.querySelector('.time-slots-wrapper');
                timeWrapper.innerHTML = '';

                if (!slots || slots.length === 0) {
                    timeWrapper.innerHTML =
                        `<span class="text-muted">No slots available for ${new Date(date).toDateString()}.</span>`;
                    return;
                }

                slots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button'; // Prevent accidental form submission
                    btn.className =
                        `btn btn-sm ${slot.status === 1 ? 'btn-secondary disabled' : 'btn-outline-primary'} rounded-pill`;
                    btn.textContent = `${slot.start_time} - ${slot.end_time}`;
                    btn.setAttribute('data-slot-id', slot.id);

                    if (slot.status !== 1) {
                        btn.addEventListener('click', () => {
                            console.log('Slot selected:', slot.id);
                            document.getElementById('selectedTimeSlot').value = slot.id;
                            document.getElementById('selectedStartTime').value = slot.start_time;
                            document.getElementById('selectedEndTime').value = slot.end_time;

                            document.querySelectorAll('.time-slots-wrapper button').forEach(b => b
                                .classList.remove('active'));
                            btn.classList.add('active');
                            document.getElementById('confirmBookingBtn').disabled = false;
                        });
                    }

                    timeWrapper.appendChild(btn);
                });
            }

            // Scroll Buttons
            document.querySelector('.scroll-left').addEventListener('click', () => {
                currentScrollPosition -= dateItemWidth * 2;
                dateScrollWrapper.scrollTo({
                    left: currentScrollPosition,
                    behavior: 'smooth'
                });
            });

            document.querySelector('.scroll-right').addEventListener('click', () => {
                currentScrollPosition += dateItemWidth * 2;
                dateScrollWrapper.scrollTo({
                    left: currentScrollPosition,
                    behavior: 'smooth'
                });
            });

        });

        // Payment model
        document.addEventListener('DOMContentLoaded', function() {
            let timerDuration = 30 * 60; // 30 minutes in seconds
            const timerDisplay = document.getElementById('paymentTimer');

            const countdown = setInterval(() => {
                const minutes = Math.floor(timerDuration / 60);
                const seconds = timerDuration % 60;

                timerDisplay.textContent =
                    `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                if (timerDuration <= 0) {
                    clearInterval(countdown);
                    timerDisplay.textContent = '00:00';
                    alert('Payment time expired!');
                    // Optionally disable payment button or close modal
                    document.getElementById('payNowBtn').disabled = true;
                }

                timerDuration--;
            }, 1000);
            // Handle slot selection
            document.querySelectorAll('.slot-btn').forEach(button => {
                button.addEventListener('click', () => {
                    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove(
                        'selected'));
                    button.classList.add('selected');

                    document.getElementById('selectedTimeSlot').value = button.dataset.slotId;
                    document.getElementById('selectedStartTime').value = button.dataset.startTime;
                    document.getElementById('selectedEndTime').value = button.dataset.endTime;

                    document.getElementById('confirmBookingBtn').disabled = false;
                });
            });

            // Intercept form submit and show payment modal
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const selectedSlotId = document.getElementById('selectedTimeSlot').value;
                const notes = document.getElementById('patientNotes').value || '-';
                const doctorName = document.getElementById('modalDoctorName').textContent.trim();
                const date = document.getElementById('selectedDate').value;
                const startTime = document.getElementById('selectedStartTime').value;
                const endTime = document.getElementById('selectedEndTime').value;
                const time = `${startTime} - ${endTime}`;

                // Populate preview in payment modal
                document.getElementById('reviewDoctorName').textContent = doctorName;
                document.getElementById('reviewDate').textContent = date;
                document.getElementById('reviewTime').textContent = time;
                document.getElementById('reviewNotes').textContent = notes;
                document.getElementById('reviewFee').textContent = '$100';

                // Step 1: Create temporary appointment
                fetch('/appointment/prepare', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            slot_id: selectedSlotId,
                            notes: notes
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const appointmentId = data.appointment_id;

                        // Step 2: Store appointmentId for Stripe payment
                        document.getElementById('payNowBtn').dataset.appointmentId = appointmentId;

                        // Step 3: Show payment modal
                        const paymentModal = new bootstrap.Modal(document.getElementById(
                            'paymentModal'), {
                            backdrop: false
                        });
                        paymentModal.show();

                        // Step 4: Hide booking modal
                        bootstrap.Modal.getInstance(document.getElementById('bookModal')).hide();
                    })
                    .catch(error => {
                        console.error("Failed to prepare appointment:", error);
                        alert("Failed to prepare appointment. Please try again.");
                    });
            });

            // Reopen booking modal if payment modal closed
            document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function() {
                new bootstrap.Modal(document.getElementById('bookModal')).show();
            });
            // this is DOMContentLoaded



            // Handle "Pay Now" click
            let stripe = Stripe("{{ config('services.stripe.key') }}");
            let elements = stripe.elements();

            // Create individual elements
            let cardNumber = elements.create('cardNumber');
            let cardExpiry = elements.create('cardExpiry');
            let cardCvc = elements.create('cardCvc');

            // Mount them into the DOM
            cardNumber.mount('#card-number-element');
            cardExpiry.mount('#card-expiry-element');
            cardCvc.mount('#card-cvc-element');

            document.getElementById('payNowBtn').addEventListener('click', function() {
                // Fetch client secret from server
                const appointmentId = document.getElementById('payNowBtn').dataset.appointmentId;

                Swal.fire({
                    title: 'Processing Payment',
                    text: 'Please wait while we confirm your booking...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('/payment/create-intent', {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        stripe.confirmCardPayment(data.client_secret, {
                            payment_method: {
                                card: cardNumber
                            }
                        }).then(result => {
                            if (result.error) {
                                document.getElementById('card-errors').textContent = result
                                    .error.message;
                                Swal.close();
                            } else {
                                // Payment succeeded
                                fetch('/payment/success', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        },
                                        body: JSON.stringify({
                                            appointment_id: data.appointment_id,
                                            payment_intent_id: result.paymentIntent
                                                .id
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(response => {
                                        if (response.success) {
                                            $('#paymentModal').modal('hide');
                                            $('#bookModal').modal('hide');

                                            Swal.fire({
                                                title: 'Appointment Booked!',
                                                text: 'Your appointment has been successfully confirmed.',
                                                icon: 'success',
                                                confirmButtonText: 'Okay',
                                                timer: 3000,
                                                timerProgressBar: true
                                            }).then(() => {
                                                // Optional redirect
                                                window.location.href =
                                                    '/';
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Payment Failed',
                                                text: response.message ||
                                                    'There was an issue verifying your payment.',
                                                icon: 'error',
                                                confirmButtonText: 'Try Again'
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        Swal.fire({
                                            title: 'Oops!',
                                            text: 'Something went wrong while booking the appointment.',
                                            icon: 'error',
                                            confirmButtonText: 'Close'
                                        });
                                    });

                            }
                        });
                    });
            });


        });
    </script>
</body>

</html>
