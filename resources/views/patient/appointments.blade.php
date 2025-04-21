@extends('layouts.patient-dashboard')
@section('title', 'My Appointments')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-light mb-1 text-primary">
                    <i class="fas fa-calendar-check me-2"></i> My Appointments
                </h2>
                <p class="text-muted small">Upcoming and past consultation schedules</p>
            </div>
        </div>

        <!-- Appointment Table -->
        <div class="card border-0 shadow-xs overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-history me-2"></i> Appointment History
                    </h5>
                </div>
            </div>

            <div class="card-body px-0 pt-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top bg-white" style="top: -1px; z-index: 10;">
                            <tr class="border-bottom">
                                <th class="ps-4 py-3 text-muted small text-uppercase fw-semibold">Doctor</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Date</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Time</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Status</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase fw-semibold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-bottom hover-highlight">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md bg-soft-info text-info rounded-circle me-3">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $appointment->slot->doctor->user->name }}
                                                </h6>
                                                <small
                                                    class="text-muted">{{ $appointment->doctor->specialty ?? 'General' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="d-block fw-medium">
                                            {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-soft-secondary text-secondary rounded-pill px-3 py-1">
                                            <i class="far fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                        </span>
                                    </td>

                                    <td class="py-3">
                                        @php
                                            $statusColor = match ($appointment->status) {
                                                'confirmed' => 'success',
                                                'pending' => 'warning',
                                                'cancelled' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span
                                            class="badge bg-soft-{{ $statusColor }} text-{{ $statusColor }} rounded-pill px-3 py-1">
                                            <i class="fas fa-circle me-1"></i> {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-primary view-appointment-btn"
                                                data-id="{{ $appointment->id }}">
                                                <i class="fas fa-eye"></i> View
                                            </button>

                                            @if ($appointment->status == 'pending')
                                                <form method="POST"
                                                    action="{{ route('appointments.cancel', $appointment->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3 action-btn">
                                                        <i class="fas fa-times me-1"></i> Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing <span class="fw-semibold"></span> of <span class="fw-semibold"></span> appointments
                    </div>
                    <div class="card-footer bg-white border-0 py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing <span class="fw-semibold">{{ $appointments->count() }}</span> of <span
                                    class="fw-semibold">{{ $appointments->total() }}</span> appointments
                            </div>
                            <div>
                                {{ $appointments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Appointment Details Modal -->
    <div class="modal fade" id="appointmentModal{{ $appointment->id }}" tabindex="-1"
        aria-labelledby="appointmentModalLabel{{ $appointment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="appointmentModalLabel{{ $appointment->id }}">
                        <i class="fas fa-info-circle me-2"></i> Appointment Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Doctor:</strong> {{ $appointment->slot->doctor->user->name ?? 'N/A' }}</p>
                    <p><strong>Specialization:</strong> {{ $appointment->slot->doctor->specialization ?? 'N/A' }}</p>
                    <p><strong>Hospital:</strong> {{ $appointment->slot->hospital->name ?? 'Mo-Hospital' }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                    <p><strong>Status:</strong>
                        <span
                            class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </p>

                    @if ($appointment->prescription)
                        <hr>
                        <h6 class="text-primary">Prescription Info</h6>
                        <p><strong>Diagnosis:</strong> {{ $appointment->prescription->diagnosis }}</p>
                        <p><strong>Notes:</strong> {{ $appointment->prescription->notes }}</p>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
