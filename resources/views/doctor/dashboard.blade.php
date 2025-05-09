@extends('layouts.base')

@section('title', 'Doctor Dashboard')


@section('dashboard-content')
    <div class="container-fluid py-5 ps-lg-5">

        <!-- Welcome Header -->
        <div
            class="p-4 rounded-4 bg-light shadow-sm border-start border-4 border-primary d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5">

            <div class="mb-3 mb-md-0">
                <h2 class="h4 fw-bold text-primary mb-2 d-flex align-items-center">
                    <i class="fas fa-user-md me-3 text-primary fs-4"></i>
                    Doctor Dashboard
                </h2>
                <p class="text-muted mb-0">Welcome back, <strong class="text-primary">Dr. {{ auth()->user()->name }}</strong>
                </p>
            </div>

            <div class="text-md-end">
                <div class="text-muted small">Last Login</div>
                <div class="fw-semibold text-dark">{{ now()->format('M j, Y h:i A') }}</div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <!-- Upcoming Appointments Card -->
            <div class="col-md-6 col-xl-4">
                <div class="card bg-light shadow-lg rounded-4 h-100 border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary bg-opacity-10 me-3 p-3">
                                <i class="fa-solid fa-calendar-check text-primary fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bolder text-dark">{{ $upcomingAppointmentsCount }}</h3>
                                <small class="text-muted fw-medium">Upcoming Appointments</small>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('doctor.appointments') }}"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3 py-2 hover-scale">
                                View All <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Patients Card -->
            <div class="col-md-6 col-xl-4">
                <div class="card bg-light shadow-lg rounded-4 h-100 border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-success bg-opacity-10 me-3 p-3">
                                <i class="fa-solid fa-users text-success fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bolder text-dark">{{ $totalPatientsCount }}</h3>
                                <small class="text-muted fw-medium">Total Patients</small>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('doctor.my-patients') }}"
                                class="btn btn-sm btn-outline-success rounded-pill px-3 py-2 hover-scale">
                                View All <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Available Slots Card -->
            <div class="col-md-12 col-xl-4">
                <div class="card bg-light shadow-lg rounded-4 h-100 border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-warning bg-opacity-10 me-3 p-3">
                                <i class="fa-solid fa-clock text-warning fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bolder text-dark">{{ $totalAvailableSlots }}</h3>
                                <small class="text-muted fw-medium">Total Available Slots</small>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('doctor.slots.index') }}"
                                class="btn btn-sm btn-outline-warning rounded-pill px-3 py-2 hover-scale manage-slot-button">
                                Manage Slots <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Appointments Chart -->
        <div class="card glass-card mb-5">
            <div class="card-header glass-card-header pt-4 px-4 pb-0 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark-emphasis">
                            <i class="fas fa-chart-line me-2" style="color: #6d28d9;"></i>Appointment Activity
                        </h5>
                        <p class="small text-muted mb-0">Weekly appointment trends</p>
                    </div>
                    {{-- <div class="dropdown">
                        <button class="btn btn-sm bg-white rounded-pill px-3 py-2 dropdown-toggle shadow-sm" type="button"
                            id="chartPeriodDropdown" data-bs-toggle="dropdown"
                            style="background-color: rgba(255,255,255,0.8) !important; border: 1px solid rgba(0,0,0,0.05)">
                            <i class="far fa-calendar-alt me-2 text-primary"></i>This Week
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 glass-card py-2 mt-2"
                            style="min-width: 180px;">
                            <li><a class="dropdown-item rounded-lg px-3 py-2" href="#"><i
                                        class="far fa-clock me-2 text-muted"></i>This Week</a></li>
                            <li><a class="dropdown-item rounded-lg px-3 py-2" href="#"><i
                                        class="far fa-calendar me-2 text-muted"></i>This Month</a></li>
                            <li><a class="dropdown-item rounded-lg px-3 py-2" href="#"><i
                                        class="far fa-calendar-alt me-2 text-muted"></i>This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>

            <div class="card-body p-4">
                <div class="position-relative" style="height: 320px;">
                    <canvas id="weeklyAppointmentsChart"></canvas>
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <div class="bg-white rounded-pill px-3 py-1 shadow-sm d-inline-flex align-items-center"
                            style="background: rgba(255,255,255,0.7); backdrop-filter: blur(5px);">
                            <div
                                style="width: 10px; height: 10px; background-color: #6d28d9; border-radius: 50%; margin-right: 8px;">
                            </div>
                            <small class="text-xs fw-medium text-dark-emphasis">Live Data</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Today's Schedule -->
        <div class="card bg-light shadow-lg rounded-4 mb-5 border-0">
            <div class="card-header glass-card-header py-4 px-4 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0 fw-bold text-dark-emphasis">
                        <i class="fas fa-calendar-day text-primary me-2"></i>Today's Schedule
                    </h5>
                    <a href="{{ route('doctor.slots.index') }}"
                        class="btn btn-sm btn-primary rounded-pill px-4 py-2 shadow-sm hover-scale">
                        View All Appointments
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table align-middle table-borderless mb-0 table-sticky-header">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Time</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Patient</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Type</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                                <th class="pe-4 py-3 text-end text-uppercase small fw-bold text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointmentsToday as $appointment)
                                <tr class="border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                                    <td class="ps-4 py-3">
                                        <span
                                            class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <h6 class="mb-0 fw-semibold text-dark-emphasis">
                                                {{ $appointment->patient->name }}</h6>
                                            <small class="text-muted">ID: {{ $appointment->patient->id }}</small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary fw-medium rounded-pill px-3 py-2">
                                            Consultation
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge fw-medium rounded-pill px-3 py-2
                                            {{ $appointment->status === 'completed'
                                                ? 'bg-success bg-opacity-10 text-success'
                                                : ($appointment->status === 'accepted'
                                                    ? 'bg-warning bg-opacity-10 text-warning'
                                                    : ($appointment->status === 'rescheduled'
                                                        ? 'bg-info bg-opacity-10 text-info'
                                                        : 'bg-secondary bg-opacity-10 text-secondary-emphasis')) }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <button
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 hover-scale btn-start-appointment"
                                            data-id="{{ $appointment->id }}" data-status="{{ $appointment->status }}">
                                            <i class="fas fa-play me-1"></i> Start
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-info-circle fa-2x mb-2 d-block text-primary"></i>
                                        No appointments scheduled for today.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="card glass-card">
            <div class="card-header glass-card-header py-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark-emphasis">
                        <i class="fas fa-user-clock me-2 text-primary"></i>Recent Patients
                    </h5>
                    <a href="{{ route('doctor.my-patients') }}"
                        class="btn btn-sm btn-outline-primary rounded-pill px-4 py-2 shadow-sm hover-scale">
                        View All Patients
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table align-middle mb-0 table-borderless table-sticky-header">
                        <thead>
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Patient</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Last Visit</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Condition</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Consultation Fee</th>
                                <th class="pe-4 py-3 text-end text-uppercase small fw-bold text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPatients as $appointment)
                                <tr class="border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-center align-items-center rounded-circle bg-light me-3"
                                                style="width: 45px; height: 45px; background-color: rgba(0,0,0,0.05) !important;">
                                                <i class="fas fa-user text-primary" style="font-size: 20px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-emphasis">
                                                    {{ $appointment->patient->name }}</h6>
                                                <small class="text-muted">{{ rand(25, 60) }} years old</small>
                                                <!-- More realistic age -->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-muted fw-medium">{{ $appointment->created_at->diffForHumans() }}
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger fw-medium rounded-pill px-3 py-2">
                                            Fever <!-- Keep specific or make dynamic -->
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success fw-medium rounded-pill px-3 py-2">
                                            $100 <!-- Keep specific or make dynamic -->
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('doctor.message.patient', ['patient_id' => $appointment->patient->id]) }}"
                                            class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 hover-scale">
                                            <i class="fas fa-comment-medical me-1"></i>Message
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-users-slash fa-2x mb-2 d-block text-primary"></i>
                                        No recent patient activity.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($recentPatients->isNotEmpty())
                    <div class="card-footer glass-card-header text-center py-3 px-4 border-0">
                        <!-- Footer can be used for pagination or a general "View All" if not in header -->
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Ensure SweetAlert2 is included for the JS to work --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-start-appointment').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.dataset.id;
                    const appointmentStatus = this.dataset.status;

                    if (appointmentStatus === 'completed') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Already Completed',
                            text: 'This appointment has already been marked as completed.',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'glass-card', // Apply glass to Swal
                                confirmButton: 'btn btn-primary rounded-pill px-4 py-2'
                            },
                            buttonsStyling: false
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Complete Appointment?',
                        text: 'Mark this appointment as completed and send prescription?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, complete it!',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'glass-card', // Apply glass to Swal
                            confirmButton: 'btn btn-success rounded-pill px-4 py-2 me-2',
                            cancelButton: 'btn btn-outline-secondary rounded-pill px-4 py-2'
                        },
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch(
                                    `/doctor/appointments/${appointmentId}/complete`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({})
                                    })
                                .then(async res => {
                                    if (!res.ok) {
                                        const errorData = await res.json()
                                            .catch(() => ({
                                                message: res.statusText
                                            }));
                                        throw new Error(errorData.message || res
                                            .statusText);
                                    }
                                    return res.json();
                                })
                                .then(data => {
                                    if (!data.success) throw new Error(data
                                        .message || 'Completion failed');
                                    return data;
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        `Request failed: ${error.message}`);
                                });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then(result => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Completed!',
                                text: 'Appointment marked as completed and email sent.',
                                customClass: {
                                    popup: 'glass-card',
                                    confirmButton: 'btn btn-primary rounded-pill px-4 py-2'
                                },
                                buttonsStyling: false
                            }).then(() => location.reload());
                        }
                    });
                });
            });

            // Chart
            const chartCtx = document.getElementById('weeklyAppointmentsChart')?.getContext('2d');
            if (chartCtx) {
                const gradient = chartCtx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(109, 40, 217, 0.7)'); // Primary chart color
                gradient.addColorStop(1, 'rgba(109, 40, 217, 0.05)');

                const hoverGradient = chartCtx.createLinearGradient(0, 0, 0, 300);
                hoverGradient.addColorStop(0, 'rgba(109, 40, 217, 0.9)');
                hoverGradient.addColorStop(1, 'rgba(109, 40, 217, 0.2)');

                const chartDataLabels = {!! json_encode($chartData->pluck('day')) !!};
                const chartDataCounts = {!! json_encode($chartData->pluck('count')) !!};

                new Chart(chartCtx, {
                    type: 'bar',
                    data: {
                        labels: chartDataLabels,
                        datasets: [{
                            label: 'Appointments',
                            data: chartDataCounts,
                            backgroundColor: gradient,
                            borderColor: 'rgba(109, 40, 217, 1)',
                            borderWidth: 0, // Set to 0 if using gradient fill extensively
                            borderRadius: {
                                topLeft: 8,
                                topRight: 8,
                                bottomLeft: 0,
                                bottomRight: 0
                            },
                            hoverBackgroundColor: hoverGradient,
                            barThickness: 'flex',
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)', // Lighter grid lines
                                    lineWidth: 1,
                                },
                                ticks: {
                                    padding: 16,
                                    font: {
                                        family: 'Inter, sans-serif',
                                        size: 12
                                    },
                                    color: '#54545F' // Muted tick color
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: 'Inter, sans-serif',
                                        size: 12
                                    },
                                    color: '#54545F'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(15, 10, 50, 0.85)', // Darker tooltip for contrast
                                titleColor: '#e2e8f0',
                                bodyColor: '#e2e8f0',
                                titleFont: {
                                    family: 'Inter, sans-serif',
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    family: 'Inter, sans-serif',
                                    size: 12
                                },
                                padding: {
                                    top: 10,
                                    bottom: 10,
                                    left: 12,
                                    right: 12
                                },
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    title: () => null, // No title
                                    label: (context) =>
                                        `${context.parsed.y} appointment${context.parsed.y !== 1 ? 's' : ''}`
                                },
                                // Use external HTML tooltip if more customization is needed
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 600,
                            easing: 'easeOutCubic'
                        }
                    }
                });
            }
        });
    </script>
@endsection
