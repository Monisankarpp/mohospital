@extends('layouts.patient-dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5"
        style="margin-left: 250px; max-width: calc(100% - 250px); background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%); min-height: 100vh;">

        <!-- Welcome Header with Glassmorphism -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0"
                    style="
                    border-radius: 16px; 
                    background: rgba(255, 255, 255, 0.65);
                    backdrop-filter: blur(12px);
                    -webkit-backdrop-filter: blur(12px);
                    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
                    border: 1px solid rgba(255, 255, 255, 0.18);
                ">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1" style="color: #2c3e50; font-weight: 600;">Welcome Back,
                                    {{ Auth::user()->name }}!</h2>
                                <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                                    <i class="fas fa-calendar-day me-1 text-primary"></i>
                                    Today is {{ now()->format('l, F j, Y') }}
                                </p>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px; background: rgba(52, 152, 219, 0.2); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                                <i class="fas fa-user-md" style="color: #3498db; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards with Glassmorphism -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 h-100"
                    style="
                    border-radius: 16px; 
                    background: rgba(255, 255, 255, 0.6);
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                ">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px; background: rgba(41, 128, 185, 0.15); backdrop-filter: blur(5px);">
                                <i class="fas fa-calendar-check" style="color: #2980b9; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size: 0.85rem;">Upcoming Appointments</h6>
                                <h3 class="mb-0" style="color: #2c3e50; font-weight: 700;">{{ count($appointments) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 h-100"
                    style="
                    border-radius: 16px; 
                    background: rgba(255, 255, 255, 0.6);
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                ">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px; background: rgba(39, 174, 96, 0.15); backdrop-filter: blur(5px);">
                                <i class="fas fa-prescription-bottle-alt" style="color: #27ae60; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size: 0.85rem;">Active Prescriptions</h6>
                                <h3 class="mb-0" style="color: #2c3e50; font-weight: 700;">
                                    {{ $latestPrescription ? 1 : 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 h-100"
                    style="
                    border-radius: 16px; 
                    background: rgba(255, 255, 255, 0.6);
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                ">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px; background: rgba(155, 89, 182, 0.15); backdrop-filter: blur(5px);">
                                <i class="fas fa-comment-medical" style="color: #9b59b6; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size: 0.85rem;">Recent Messages</h6>
                                <h3 class="mb-0" style="color: #2c3e50; font-weight: 700;">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Section with Glassmorphism -->
        <div class="card mb-4 border-0"
            style="
            border-radius: 16px; 
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
        ">
            <div class="card-header bg-transparent border-0 pt-4 pb-3 d-flex justify-content-between align-items-center"
                style="background: rgba(255,255,255,0.3);">
                <div>
                    <h5 class="mb-1" style="font-weight: 600; color: #34495e;">
                        <i class="fas fa-calendar-check me-2" style="color: #3498db;"></i> Upcoming Appointments
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                        Your scheduled consultations with healthcare providers
                    </p>
                </div>
                <a href="{{ route('patient.appointments.book') }}" class="btn btn-sm rounded-pill px-3"
                    style="
                    background: rgba(52, 152, 219, 0.1);
                    backdrop-filter: blur(5px);
                    color: #3498db;
                    border: 1px solid rgba(52, 152, 219, 0.2);
                ">
                    <i class="fas fa-plus me-1"></i> Book New
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="sticky-top"
                            style="
                            top: -1px; 
                            background: rgba(248, 250, 252, 0.8);
                            backdrop-filter: blur(10px);
                            -webkit-backdrop-filter: blur(10px);
                        ">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Doctor</th>
                                <th class="py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Specialty</th>
                                <th class="py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Date & Time</th>
                                <th class="py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Status</th>
                                <th class="pe-4 py-3 text-end text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appointment)
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 42px; height: 42px; background: rgba(52, 152, 219, 0.15); backdrop-filter: blur(5px);">
                                                    <i class="fas fa-user-md" style="color: #3498db;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0" style="font-weight: 600;">Dr.
                                                    {{ $appointment->slot->doctor->user->name }}</h6>
                                                <small class="text-muted"
                                                    style="font-size: 0.8rem;">{{ $appointment->slot->doctor->specialization }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill py-2 px-3"
                                            style="
                                            background: rgba(52, 152, 219, 0.1);
                                            backdrop-filter: blur(5px);
                                            color: #3498db; 
                                            font-weight: 500;
                                            border: 1px solid rgba(52, 152, 219, 0.1);
                                        ">
                                            {{ $appointment->slot->doctor->specialization }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <div style="font-weight: 500;">
                                                {{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</div>
                                            <small class="text-muted" style="font-size: 0.85rem;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $statusColors = [
                                                'accepted' => ['#27ae60', 'rgba(39, 174, 96, 0.1)', 'fa-check-circle'],
                                                'pending' => ['#f39c12', 'rgba(243, 156, 18, 0.1)', 'fa-clock'],
                                                'rejected' => ['#e74c3c', 'rgba(231, 76, 60, 0.1)', 'fa-times-circle'],
                                                'rescheduled' => ['#3498db', 'rgba(52, 152, 219, 0.1)', 'fa-sync-alt'],
                                            ];

                                            $status = strtolower($appointment->status);
                                            $color = $statusColors[$status][0] ?? '#95a5a6';
                                            $bg = $statusColors[$status][1] ?? 'rgba(0,0,0,0.05)';
                                            $icon = $statusColors[$status][2] ?? 'fa-question-circle';
                                        @endphp
                                        <span class="badge rounded-pill py-2 px-3"
                                            style="
                                            background: {{ $bg }};
                                            color: {{ $color }}; 
                                            font-weight: 500;
                                            backdrop-filter: blur(5px);
                                            border: 1px solid rgba(255,255,255,0.2);
                                        ">
                                            <i class="fas {{ $icon }} me-1"></i> {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end">
                                            <!-- View Button -->
                                            <button class="btn btn-sm rounded-pill px-3 me-2" data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $appointment->id }}"
                                                style="background: rgba(108, 117, 125, 0.1); backdrop-filter: blur(5px); color: #6c757d; border: 1px solid rgba(108, 117, 125, 0.1);">
                                                <i class="fas fa-eye fa-xs"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            @php
                                                $canEdit = \Carbon\Carbon::now()
                                                    ->addHours(24)
                                                    ->lt(
                                                        \Carbon\Carbon::parse(
                                                            $appointment->date . ' ' . $appointment->slot->start_time,
                                                        ),
                                                    );
                                            @endphp
                                            @if ($canEdit)
                                                <button class="btn btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $appointment->id }}"
                                                    style="background: rgba(52, 152, 219, 0.1); backdrop-filter: blur(5px); color: #3498db; border: 1px solid rgba(52, 152, 219, 0.1);">
                                                    <i class="fas fa-edit fa-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4"
                                        style="
                                        background: rgba(255,255,255,0.5);
                                        backdrop-filter: blur(5px);
                                    ">
                                        <i class="fas fa-calendar-times fa-2x mb-3" style="color: #bdc3c7;"></i>
                                        <p class="mb-0 text-muted">No upcoming appointments scheduled</p>
                                        <a href="{{ route('patient.appointments.book') }}"
                                            class="btn btn-sm mt-2 rounded-pill"
                                            style="
                                            background: rgba(52, 152, 219, 0.1);
                                            backdrop-filter: blur(5px);
                                            color: #3498db;
                                            border: 1px solid rgba(52, 152, 219, 0.2);
                                        ">
                                            Book an Appointment
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @foreach ($appointments as $appointment)
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $appointment->id }}" tabindex="-1"
                            aria-labelledby="viewModalLabel{{ $appointment->id }}" aria-hidden="true"
                            style="z-index: 1060;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                                    <div class="modal-header position-relative"
                                        style="background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); color: white; border-bottom: none;">
                                        <div class="w-100 text-center">
                                            <div class="rounded-circle bg-white p-3 d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 60px; height: 60px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                                <i class="fas fa-calendar-check text-primary"
                                                    style="font-size: 1.5rem;"></i>
                                            </div>
                                            <h5 class="modal-title w-100" id="viewModalLabel{{ $appointment->id }}"
                                                style="font-weight: 600;">Appointment Details</h5>
                                        </div>
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                            data-bs-dismiss="modal" aria-label="Close"
                                            style="filter: invert(1);"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="d-flex align-items-start mb-4">
                                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                                <i class="fas fa-user-md text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1" style="font-weight: 600;">Dr.
                                                    {{ $appointment->slot->doctor->user->name }}</h6>
                                                <p class="mb-0 text-muted">
                                                    {{ $appointment->slot->doctor->specialization }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="p-3 bg-light rounded"
                                                    style="background-color: #f8f9fa !important;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                                                            <i class="fas fa-calendar-day text-info"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Date</small>
                                                            <p class="mb-0" style="font-weight: 500;">
                                                                {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-light rounded"
                                                    style="background-color: #f8f9fa !important;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                                                            <i class="fas fa-clock text-success"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Time</small>
                                                            <p class="mb-0" style="font-weight: 500;">
                                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">Appointment Status</small>
                                                @php
                                                    $statusColors = [
                                                        'accepted' => ['success', 'fa-check-circle'],
                                                        'pending' => ['warning', 'fa-clock'],
                                                        'rejected' => ['danger', 'fa-times-circle'],
                                                        'rescheduled' => ['info', 'fa-sync-alt'],
                                                    ];
                                                    $status = strtolower($appointment->status);
                                                    $config = $statusColors[$status] ?? [
                                                        'secondary',
                                                        'fa-question-circle',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-light text-{{ $config[0] }} border border-{{ $config[0] }} rounded-pill py-1 px-3">
                                                    <i class="fas {{ $config[1] }} me-1"></i> {{ ucfirst($status) }}
                                                </span>
                                            </div>

                                            @if ($appointment->notes)
                                                <div class="mt-3">
                                                    <small class="text-muted">Doctor's Notes</small>
                                                    <div class="p-3 bg-light rounded mt-1"
                                                        style="background-color: #f8f9fa !important; font-size: 0.9rem;">
                                                        {{ $appointment->notes }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary rounded-pill px-4">
                                            <i class="fas fa-calendar-plus me-2"></i> Add to Calendar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal (only if can edit) -->
                        @php
                            $canEdit = \Carbon\Carbon::now()
                                ->addHours(24)
                                ->lt(\Carbon\Carbon::parse($appointment->date . ' ' . $appointment->slot->start_time));
                        @endphp
                        @if ($canEdit)
                            <div class="modal fade" id="editModal{{ $appointment->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $appointment->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 16px; border: none;">
                                        <div class="modal-header position-relative"
                                            style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border-bottom: none;">
                                            <div class="w-100 text-center">
                                                <div class="rounded-circle bg-white p-3 d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 60px; height: 60px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                                    <i class="fas fa-edit text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <h5 class="modal-title w-100" id="editModalLabel{{ $appointment->id }}"
                                                    style="font-weight: 600;">Reschedule Appointment</h5>
                                            </div>
                                            <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                                data-bs-dismiss="modal" aria-label="Close"
                                                style="filter: invert(1);"></button>
                                        </div>
                                        <form action="{{ route('patient.appointments.update', $appointment->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="mb-4">
                                                    <div class="d-flex align-items-start">
                                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                                            <i class="fas fa-user-md text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1" style="font-weight: 600;">Dr.
                                                                {{ $appointment->slot->doctor->user->name }}</h6>
                                                            <p class="mb-0 text-muted">
                                                                {{ $appointment->slot->doctor->specialization }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Select New Date</label>
                                                    <input type="date" name="date"
                                                        class="form-control rounded-pill"
                                                        value="{{ $appointment->date }}" required
                                                        style="padding: 0.75rem 1rem; border-color: #e2e8f0;">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Select Time Slot</label>
                                                    <select name="slot_id" class="form-select rounded-pill" required
                                                        style="padding: 0.75rem 1rem; border-color: #e2e8f0;">
                                                        @foreach ($availableSlots as $slot)
                                                            <option value="{{ $slot->id }}"
                                                                {{ $appointment->slot_id == $slot->id ? 'selected' : '' }}>
                                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="alert alert-warning mt-4" style="border-radius: 12px;">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-exclamation-triangle me-3"></i>
                                                        <small>Please note that rescheduling within 24 hours of your
                                                            appointment may be subject to cancellation fees.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                    <i class="fas fa-save me-2"></i> Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            @if (count($appointments) > 0)
                <div class="card-footer bg-transparent border-0 text-center py-3"
                    style="background: rgba(255,255,255,0.3);">
                    <a href="{{ route('patient.appointments.book') }}" class="text-decoration-none"
                        style="
                        color: #3498db; 
                        font-weight: 500; 
                        transition: all 0.2s ease;
                    ">
                        View All Appointments <i class="fas fa-chevron-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Prescriptions with Glassmorphism -->
        @if ($latestPrescription)
            <div class="card border-0"
                style="
                border-radius: 16px; 
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.2);
            ">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center p-4 pb-0"
                    style="background: rgba(255,255,255,0.3);">
                    <div>
                        <span class="badge rounded-pill px-3 py-2 mb-2"
                            style="
                            background: rgba(46, 204, 113, 0.1);
                            backdrop-filter: blur(5px);
                            color: #2ecc71; 
                            font-size: 12px; 
                            font-weight: 500;
                            border: 1px solid rgba(46, 204, 113, 0.1);
                        ">
                            <i class="fas fa-prescription-bottle-alt me-2"></i>ACTIVE PRESCRIPTION
                        </span>
                        <h3 class="mb-0" style="color: #2c3e50; font-weight: 600;">Current Medication Plan</h3>
                    </div>
                    <a href="{{ route('patient.prescriptions') }}" class="btn btn-sm rounded-pill px-4 py-2"
                        style="
                        background: rgba(46, 204, 113, 0.1);
                        backdrop-filter: blur(5px);
                        color: #2ecc71;
                        border: 1px solid rgba(46, 204, 113, 0.2);
                        box-shadow: 0 4px 12px rgba(46, 204, 113, 0.1);
                    ">
                        <i class="fas fa-list-ul me-2"></i>View All Prescriptions
                    </a>
                </div>

                <div class="card-body p-4 pt-2">
                    <!-- Doctor Info Section -->
                    <div class="d-flex align-items-center mb-4 p-3"
                        style="
                        background: rgba(255, 255, 255, 0.7);
                        backdrop-filter: blur(8px);
                        border-radius: 12px; 
                        box-shadow: 0 2px 12px rgba(0,0,0,0.03);
                        border: 1px solid rgba(255, 255, 255, 0.2);
                    ">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 48px; height: 48px; background: rgba(52, 152, 219, 0.15); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-user-md" style="font-size: 18px; color: #3498db;"></i>
                        </div>
                        <div>
                            <h5 class="mb-1" style="color: #2c3e50; font-weight: 600;">Dr.
                                {{ $latestPrescription->doctor->user->name }}</h5>
                            <p class="mb-1" style="color: #7f8c8d; font-size: 14px;">
                                {{ $latestPrescription->doctor->specialization }}</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2" style="color: #95a5a6; font-size: 12px;"></i>
                                <span style="color: #34495e; font-size: 13px; font-weight: 500;">Last Updated:
                                    {{ \Carbon\Carbon::parse($latestPrescription->updated_at)->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Medications List -->
                    <div class="mb-4">
                        <h6 class="mb-3" style="color: #34495e; font-weight: 600; font-size: 15px;">
                            <i class="fas fa-pills me-2" style="color: #3498db;"></i>PRESCRIBED MEDICATIONS
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 d-flex align-items-center"
                                    style="
                                    background: rgba(255, 255, 255, 0.7);
                                    backdrop-filter: blur(8px);
                                    border-radius: 10px; 
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
                                    border: 1px solid rgba(255, 255, 255, 0.2);
                                ">
                                    <div class="me-3"
                                        style="
                                        width: 36px; 
                                        height: 36px; 
                                        background: rgba(46, 204, 113, 0.15);
                                        backdrop-filter: blur(5px);
                                        border-radius: 8px; 
                                        display: flex; 
                                        align-items: center; 
                                        justify-content: center;
                                        border: 1px solid rgba(255, 255, 255, 0.2);
                                    ">
                                        <i class="fa-solid fa-pills" style="color: #2ecc71;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0" style="color: #2c3e50; font-size: 14px; font-weight: 600;">
                                            Paracetamol </h6>
                                        <p class="mb-0" style="color: #7f8c8d; font-size: 13px;">
                                            2 Tablet · 6 Hours · 2 Days</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 d-flex align-items-center"
                                    style="
                                    background: rgba(255, 255, 255, 0.7);
                                    backdrop-filter: blur(8px);
                                    border-radius: 10px; 
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
                                    border: 1px solid rgba(255, 255, 255, 0.2);
                                ">
                                    <div class="me-3"
                                        style="
                                        width: 36px; 
                                        height: 36px; 
                                        background: rgba(46, 204, 113, 0.15);
                                        backdrop-filter: blur(5px);
                                        border-radius: 8px; 
                                        display: flex; 
                                        align-items: center; 
                                        justify-content: center;
                                        border: 1px solid rgba(255, 255, 255, 0.2);
                                    ">
                                        <i class="fa-solid fa-pills" style="color: #2ecc71;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0" style="color: #2c3e50; font-size: 14px; font-weight: 600;">
                                            Simethicone </h6>
                                        <p class="mb-0" style="color: #7f8c8d; font-size: 13px;">
                                            2 Tablet · 12 Hours · 5 Days</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <div>
                            <i class="fas fa-info-circle me-2" style="color: #95a5a6;"></i>
                            <span style="color: #7f8c8d; font-size: 13px;">Valid until:
                                <strong style="color: #34495e;">
                                    {{ \Carbon\Carbon::parse($latestPrescription->valid_until)->format('M d, Y') }}
                                </strong></span>
                        </div>
                        {{-- <button class="btn btn-sm rounded-pill px-3"
                            style="
                            background: rgba(46, 204, 113, 0.1);
                            backdrop-filter: blur(5px);
                            color: #2ecc71;
                            border: 1px solid rgba(46, 204, 113, 0.2);
                        ">
                            <i class="fas fa-download me-1"></i> Download
                        </button> --}}
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
