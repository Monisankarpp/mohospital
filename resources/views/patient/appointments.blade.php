@extends('layouts.base')
@section('title', 'My Appointments')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5">
        <div
            class="p-4 rounded-4 bg-light shadow-sm border-start border-4 border-primary d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 mt-4">
            <div class="mb-3 mb-md-0">
                <h2 class="h4 fw-bold text-primary mb-3 d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-3 text-primary fs-4"></i>
                    My Appointments
                </h2>
                <p class="text-muted mb-0">View and manage your upcoming appointments with ease</p>
            </div>

            <div class="text-md-end">
                <div class="text-muted small">Last Login</div>
                <div class="fw-semibold text-dark">{{ now()->format('M j, Y h:i A') }}</div>
            </div>
        </div>

        <div class="card mb-4 border-0"
            style="border-radius: 20px; background: linear-gradient(145deg, #b7c1f22d, #63a8eeba); box-shadow: 0 6px 20px rgba(100, 149, 237, 0.15);">
            <div class="card-header bg-primary bg-opacity-10 border-0 pt-4 pb-3 px-4 px-lg-5 rounded-top-4">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-3 shadow-sm flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fas fa-calendar-check fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 text-dark fw-bold" style="font-size: 1.25rem;">
                                Upcoming Appointments
                            </h5>
                            <p class="text-muted small mb-0">
                                Review your scheduled consultations.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="sticky-top shadow-sm" style="top: -1px; /* Lifts it slightly for shadow */
                                        background: linear-gradient(145deg, #f1f3ff, #e6e9ff);
                                        border-bottom: 2px solid rgba(0, 0, 0, 0.05);">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">
                                    Doctor
                                </th>
                                <th class="py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">
                                    Specialty
                                </th>
                                <th class="py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">
                                    Date & Time
                                </th>
                                <th class="py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">
                                    Status
                                </th>
                                <th class="pe-4 py-3 text-end text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">
                                    Consultation Fee
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider"> {{-- Adds a slightly more prominent divider between thead and tbody --}}
                            @forelse ($appointments->where('status', '!=', 'completed') as $appointment)
                                <tr class="align-middle" style="transition: background-color 0.2s ease-in-out;">
                                    {{-- Doctor Info --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                                    style="background-color: rgba(var(--bs-primary-rgb), 0.1); color: rgb(var(--bs-primary-rgb));">
                                                    {{-- Using initials as a common and clean fallback --}}
                                                    <span class="fw-bold">{{ strtoupper(substr($appointment->slot->doctor->user->name, 0, 1)) }}</span>
                                                    {{-- Or keep your icon: <i class="fas fa-user-md fs-6"></i> --}}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-semibold text-dark">
                                                    Dr. {{ $appointment->slot->doctor->user->name }}
                                                </h6>
                                                <small class="text-muted" style="font-size: 0.85rem;">
                                                    {{ $appointment->slot->doctor->specialization }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                        
                                    {{-- Specialty Badge (Consider if redundant with Doctor Info) --}}
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary-emphasis fw-medium rounded-pill px-3 py-2" style="font-size: 0.8rem;">
                                            {{ $appointment->slot->doctor->specialization }}
                                        </span>
                                    </td>
                        
                                    {{-- Date & Time --}}
                                    <td class="py-3">
                                        <div>
                                            <div class="fw-medium text-dark-emphasis" style="font-size: 0.9rem;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M, Y') }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.85rem;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }} -
                                                {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                        
                                    {{-- Status Badge --}}
                                    <td class="py-3">
                                        @php
                                            $status = strtolower($appointment->status);
                                            $statusConfig = [
                                                'pending'     => ['class' => 'warning',  'icon' => 'fa-clock',           'label' => 'Pending'],
                                                'rescheduled' => ['class' => 'danger',   'icon' => 'fa-calendar-times',  'label' => 'Rescheduled'], // fa-times-circle is also good
                                                'accepted'    => ['class' => 'info',     'icon' => 'fa-calendar-check',  'label' => 'Accepted'], // fa-sync-alt can imply processing
                                                'confirmed'   => ['class' => 'success',  'icon' => 'fa-check-circle',    'label' => 'Confirmed'],
                                                // Add other statuses as needed
                                                'default'     => ['class' => 'secondary','icon' => 'fa-question-circle', 'label' => ucfirst($status)],
                                            ];
                                            $current = $statusConfig[$status] ?? $statusConfig['default'];
                                        @endphp
                                        <span class="badge bg-{{ $current['class'] }}-subtle text-{{ $current['class'] }}-emphasis rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center" style="font-size: 0.8rem;">
                                            <i class="fas {{ $current['icon'] }} me-2" style="font-size: 0.9em;"></i> {{ $current['label'] }}
                                        </span>
                                    </td>
                        
                                    {{-- Consultation Fee --}}
                                    <td class="pe-4 py-3 text-end">
                                        <span class="fw-semibold text-success px-3 py-2 rounded-pill" style="font-size: 0.9rem; background-color: rgba(var(--bs-success-rgb), 0.1);">
                                            {{-- Assuming $appointment->consultation_fee exists or similar --}}
                                            ${{ number_format($appointment->consultation_fee ?? 100, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3 text-light-emphasis"></i>
                                            <h6 class="mb-1">No Upcoming Appointments</h6>
                                            <p class="small">Check back later or schedule a new consultation.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4 ps-lg-5">
        <div class="card mb-4 border-0"
            style="border-radius: 16px; background: linear-gradient(145deg, #ffffff, #0da5597e); box-shadow: 0 6px 20px rgba(39, 174, 96, 0.15);">
            <div class="card-header bg-success bg-opacity-10 border-0 pt-4 pb-3 px-4 px-lg-5 rounded-top-3">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <div class="bg-success text-white d-flex align-items-center justify-content-center rounded-circle me-3 shadow-sm flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fas fa-check-circle fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 text-dark fw-bold" style="font-size: 1.25rem;">
                                Completed Appointments
                            </h5>
                            <p class="text-muted small mb-0">
                                Consultations you have successfully completed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="sticky-top shadow-sm" style="top: -1px; background: linear-gradient(145deg, #eafaf1, #dff5e7); border-bottom: 2px solid rgba(0,0,0,0.05);">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">Doctor</th>
                                <th class="py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">Specialty</th>
                                <th class="py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">Date & Time</th>
                                <th class="py-3 text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">Status</th>
                                <th class="pe-4 py-3 text-end text-uppercase text-dark"
                                    style="font-size: 0.88rem; letter-spacing: 0.05em; font-weight: 600;">Consultation Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $completedAppointments = $appointments->where('status', 'completed');
                            @endphp
    
                            @forelse ($completedAppointments as $appointment)
                                <tr class="align-middle" style="transition: background-color 0.2s ease-in-out;">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="background-color: rgba(var(--bs-success-rgb), 0.1); color: rgb(var(--bs-success-rgb));">
                                                <span class="fw-bold">
                                                    {{ strtoupper(substr($appointment->slot->doctor->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark">
                                                    Dr. {{ $appointment->slot->doctor->user->name }}
                                                </h6>
                                                <small class="text-muted" style="font-size: 0.85rem;">
                                                    {{ $appointment->slot->doctor->specialization }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
    
                                    <td class="py-3">
                                        <span class="badge bg-success bg-opacity-10 text-success-emphasis fw-medium rounded-pill px-3 py-2" style="font-size: 0.8rem;">
                                            {{ $appointment->slot->doctor->specialization }}
                                        </span>
                                    </td>
    
                                    <td class="py-3">
                                        <div>
                                            <div class="fw-medium text-dark-emphasis" style="font-size: 0.9rem;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M, Y') }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.85rem;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }} -
                                                {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
    
                                    <td class="py-3">
                                        <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center" style="font-size: 0.8rem;">
                                            <i class="fas fa-check-circle me-2" style="font-size: 0.9em;"></i> Completed
                                        </span>
                                    </td>
    
                                    <td class="pe-4 py-3 text-end">
                                        <span class="fw-semibold text-success px-3 py-2 rounded-pill" style="font-size: 0.9rem; background-color: rgba(var(--bs-success-rgb), 0.1);">
                                            ${{ number_format($appointment->consultation_fee ?? 100, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3 text-light-emphasis"></i>
                                            <h6 class="mb-1">No Completed Appointments</h6>
                                            <p class="small">Check back after you’ve had your consultations.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

@endsection
