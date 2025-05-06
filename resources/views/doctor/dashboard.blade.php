@extends('layouts.doctor-dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold text-primary mb-1">
                    <i class="fas fa-user-md me-2"></i> Doctor Dashboard
                </h2>
                <p class="text-muted mb-0">Welcome back, Dr. {{ auth()->user()->name }}</p>
            </div>
            <div class="text-end">
                <small class="text-muted d-block">Last login</small>
                <span class="fw-semibold">{{ now()->format('M j, Y h:i A') }}</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <!-- Upcoming Appointments Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fa-solid fa-calendar text-primary fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">{{ $upcomingAppointmentsCount }}</h3>
                                <small class="text-muted">Upcoming Appointments</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('doctor.appointments') }}"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                View All <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescriptions Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fa-solid fa-file-medical text-success fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">{{ $totalPatientsCount }}</h3>
                                <small class="text-muted">Total Patients</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('doctor.my-patients') }}" class="btn btn-sm btn-outline-success rounded-pill">
                                View All <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fa-solid fa-sack-dollar text-warning fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">{{ $totalAvailableSlots }}</h3>
                                <small class="text-muted">Total Available Slots</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('doctor.slots.index') }}" class="btn btn-sm btn-outline-warning rounded-pill">
                                View All <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-header bg-white border-0 py-4 px-4 rounded-top-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0 fw-bold text-slate-700">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>Today's Schedule
                    </h5>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <a href="{{ route('doctor.slots.index') }}"
                            class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                            View All
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table align-middle table-borderless mb-0">
                        <thead class="bg-light text-muted sticky-top" style="top: -1px;">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-bold">Time</th>
                                <th class="text-uppercase small fw-bold">Patient</th>
                                <th class="text-uppercase small fw-bold">Type</th>
                                <th class="text-uppercase small fw-bold">Status</th>
                                <th class="pe-4 text-end text-uppercase small fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointmentsToday as $appointment)
                                <tr class="border-top border-light">
                                    <td class="ps-4 py-3 text-dark">
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <h6 class="mb-1 fw-semibold text-dark">{{ $appointment->patient->name }}</h6>
                                            <small class="text-muted">ID: {{ $appointment->patient->id }}</small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                                            Consultation
                                        </span>

                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge rounded-pill px-3 py-1
                                                {{ $appointment->status === 'completed'
                                                    ? 'bg-success bg-opacity-10 text-success'
                                                    : ($appointment->status === 'accepted'
                                                        ? 'bg-warning bg-opacity-10 text-warning'
                                                        : ($appointment->status === 'rescheduled'
                                                            ? 'bg-danger bg-opacity-10 text-danger'
                                                            : 'bg-secondary text-white')) }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <button
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 hover-scale btn-start-appointment"
                                            data-id="{{ $appointment->id }}" data-status="{{ $appointment->status }}">
                                            <i class="fas fa-play me-1"></i> Start
                                        </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-2"></i>No appointments scheduled for today.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-4 px-4 rounded-top-4">
                <h5 class="mb-0 fw-bold text-slate-700">
                    <i class="fas fa-user-injured me-2 text-primary"></i>Recent Patient
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table align-middle mb-0 table-borderless">
                        <thead class="bg-light text-muted sticky-top" style="top: 0; z-index: 1;">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-bold">Patient</th>
                                <th class="text-uppercase small fw-bold">Last Visit</th>
                                <th class="text-uppercase small fw-bold">Condition</th>
                                <th class="text-uppercase small fw-bold">Consultation Fee</th>
                                <th class="pe-4 text-end text-uppercase small fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPatients as $appointment)
                                <tr class="border-top border-light">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-center align-items-center rounded-circle bg-light shadow-sm me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-secondary" style="font-size: 18px;"></i>
                                            </div>

                                            <div>
                                                <h6 class="mb-1 fw-semibold text-dark">{{ $appointment->patient->name }}
                                                </h6>
                                                <small class="text-muted">{{ rand(15, 80) }}
                                                    years</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-muted">{{ $appointment->created_at->diffForHumans() }}</td>
                                    <td class="py-3">
                                        <span class="bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                            Fever
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                            $ 100
                                        </span>
                                    </td>

                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('doctor.message.patient', ['patient_id' => $appointment->patient->id]) }}"
                                            class="btn btn-sm btn-outline-success rounded-pill px-3 hover-scale">
                                            <i class="fas fa-comment-medical me-1"></i>Message
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent patients found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="card-footer bg-white border-0 text-end py-3 px-4">
                    <a href="{{ route('doctor.my-patients') }}"
                        class="btn btn-primary rounded-pill px-4 shadow-sm hover-scale">
                        View All Patients
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
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
                            confirmButton: 'btn btn-secondary rounded-pill px-4'
                        },
                        buttonsStyling: false
                    });
                    return;
                }

                Swal.fire({
                    title: 'Complete Appointment?',
                    text: 'Do you want to mark this appointment as completed and send the prescription?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, complete it',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return fetch(`/doctor/appointments/${appointmentId}/complete`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({})
                            })
                            .then(res => {
                                if (!res.ok) throw new Error(res.statusText);
                                return res.json();
                            })
                            .then(data => {
                                if (!data.success) throw new Error(data.message ||
                                    'Completion failed');
                                return data;
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Request failed: ${error}`);
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then(result => {
                    if (result.isConfirmed) {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Completed!',
                                text: 'Appointment marked as completed and email sent.',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            }).then(() => location.reload());
                        }, 300);
                    }
                });
            });
        });
    </script>


@endsection
