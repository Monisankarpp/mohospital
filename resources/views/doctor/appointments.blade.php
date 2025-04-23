@extends('layouts.doctor-dashboard')

@section('title', 'Appointment Details')

@section('content')
    <div class="container-fluid py-5 px-4" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Patient Appointment Details</h2>
                <a href="{{ route('doctor.schedule.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Back to Appointments
                </a>
            </div>

            <!-- Details Card -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-light py-3">
                    {{-- <h5 class="mb-0 fw-semibold text-dark">
                        Appointment on {{ $appointment->date->format('l, M d, Y') }}
                    </h5> --}}
                </div>

                <div class="card-body">
                    <div class="row g-4">

                        <!-- Patient Info -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 h-100">
                                {{-- <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-2"></i>Patient Info</h6>
                                    <p class="mb-2"><strong>Name:</strong> {{ $appointment->patient->name }}</p>
                                    <p class="mb-2"><strong>Email:</strong> {{ $appointment->patient->email }}</p>
                                    <p class="mb-2"><strong>Phone:</strong> {{ $appointment->patient->phone }}</p>
                                    <p class="mb-0"><strong>Age:</strong> {{ $appointment->patient->age }} years</p>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Appointment Info -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 h-100">
                                {{-- <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3"><i
                                            class="fas fa-calendar-check me-2"></i>Appointment Info</h6>
                                    <p class="mb-2"><strong>Date:</strong> {{ $appointment->date->format('M d, Y') }}</p>
                                    <p class="mb-2"><strong>Time:</strong> {{ $appointment->start_time }} -
                                        {{ $appointment->end_time }}</p>
                                    <p class="mb-2"><strong>Status:</strong>
                                        <span
                                            class="badge bg-{{ $appointment->status === 'Confirmed' ? 'success' : ($appointment->status === 'Pending' ? 'warning' : 'secondary') }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </p>
                                    <p class="mb-0"><strong>Booked On:</strong>
                                        {{ $appointment->created_at->format('M d, Y h:i A') }}</p>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Notes / Reason -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-notes-medical me-2"></i>Patient
                                        Notes / Reason</h6>
                                    {{-- <p class="mb-0 text-muted">
                                        {{ $appointment->notes ?? 'No additional notes provided.' }}
                                    </p> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-12 text-end mt-3">
                            {{-- <a href="{{ route('doctor.schedule.index') }}"
                                class="btn btn-outline-secondary rounded-pill me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                            <a href="{{ route('doctor.appointments.edit', $appointment->id) }}"
                                class="btn btn-primary rounded-pill">
                                <i class="fas fa-edit me-1"></i> Edit Appointment
                            </a> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
