@extends('layouts.patient-dashboard')
@section('title', 'My Appointments')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="card mb-4 border-0"
            style="border-radius: 16px; background: linear-gradient(145deg, #ffffff, #f8f9fa); box-shadow: 0 6px 20px rgba(100, 149, 237, 0.15);">
            <div class="card-header bg-transparent border-0 pt-4 pb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-primary" style="font-weight: 600;">
                        <i class="fas fa-calendar-check me-2 text-primary"></i> Upcoming Appointments
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i> Your scheduled consultations
                    </p>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="sticky-top" style="top: -1px; background: linear-gradient(145deg, #f1f3ff, #e6e9ff);">
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
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Consultation Fee
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments->where('status', '!=', 'completed') as $appointment)
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 42px; height: 42px; background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(108, 92, 231, 0.2));">
                                                    <i class="fas fa-user-md" style="color: #6c5ce7;"></i>
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
                                            style="background: rgba(108, 92, 231, 0.1); color: #6c5ce7; font-weight: 500;">
                                            {{ $appointment->slot->doctor->specialization }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <div style="font-weight: 500;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M, Y') }}
                                            </div>
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
                                                'completed' => ['#27ae60', 'rgba(39, 174, 96, 0.1)', 'fa-check-circle'],
                                                'pending' => ['#f39c12', 'rgba(243, 156, 18, 0.1)', 'fa-clock'],
                                                'rescheduled' => [
                                                    '#e74c3c',
                                                    'rgba(231, 76, 60, 0.1)',
                                                    'fa-times-circle',
                                                ],
                                                'accepted' => ['#3498db', 'rgba(52, 152, 219, 0.1)', 'fa-sync-alt'],
                                            ];

                                            $status = strtolower($appointment->status); // just to be safe
                                            $color = $statusColors[$status][0] ?? '#ccc';
                                            $bg = $statusColors[$status][1] ?? 'rgba(0,0,0,0.05)';
                                            $icon = $statusColors[$status][2] ?? 'fa-question-circle';
                                        @endphp
                                        <span class="badge rounded-pill py-2 px-3"
                                            style="background: {{ $bg }}; color: {{ $color }}; font-weight: 500;">
                                            <i class="fas {{ $icon }} me-1"></i> {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="" class="btn btn-sm rounded-pill px-3 py-2"
                                            style="background: rgba(108, 92, 231, 0.1); color: #6c5ce7; border: none; font-weight: 500;">
                                            $ 100
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No upcoming appointments.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="card mb-4 border-0"
            style="border-radius: 16px; background: linear-gradient(145deg, #ffffff, #f8f9fa); box-shadow: 0 6px 20px rgba(39, 174, 96, 0.15);">
            <div class="card-header bg-transparent border-0 pt-4 pb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-success" style="font-weight: 600;">
                        <i class="fas fa-calendar-check me-2 text-success"></i> Completed Appointments
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                        <i class="fas fa-check-circle me-1"></i> Consultations you have successfully completed
                    </p>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="sticky-top" style="top: -1px; background: linear-gradient(145deg, #eafaf1, #dff5e7);">
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
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Consultation Fee
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $completedAppointments = $appointments->where('status', 'completed');
                            @endphp

                            @forelse ($completedAppointments as $appointment)
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 42px; height: 42px; background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(39, 174, 96, 0.2));">
                                                    <i class="fas fa-user-md" style="color: #27ae60;"></i>
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
                                            style="background: rgba(39, 174, 96, 0.1); color: #27ae60; font-weight: 500;">
                                            {{ $appointment->slot->doctor->specialization }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <div style="font-weight: 500;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M, Y') }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.85rem;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill py-2 px-3"
                                            style="background: rgba(39, 174, 96, 0.1); color: #27ae60; font-weight: 500;">
                                            <i class="fas fa-check-circle me-1"></i> Completed
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="text-success" style="font-weight: 600;">
                                            $ 100
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No completed appointments yet.
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
