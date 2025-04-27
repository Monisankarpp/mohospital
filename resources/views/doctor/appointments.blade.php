@extends('layouts.doctor-dashboard')

@section('title', 'My Appointments')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container py-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>My Appointments
                </h2>
            </div>

            @if ($appointments->count())
                <div class="card border-0"
                    style="border-radius: 16px; background: #f9fbfd; box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle mb-0">
                                <thead class="bg-light text-muted border-bottom">
                                    <tr>
                                        <th scope="col" class="fw-semibold">Patient</th>
                                        <th scope="col" class="fw-semibold">Date</th>
                                        <th scope="col" class="fw-semibold">Time</th>
                                        <th scope="col" class="fw-semibold">Status</th>
                                        <th scope="col" class="fw-semibold">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr style="background: white; border-radius: 8px;">
                                            <td>
                                                <div class="fw-semibold text-dark">{{ $appointment->patient->name }}</div>
                                                <small class="text-muted">{{ $appointment->patient->email }}</small>
                                            </td>
                                            <td class="text-dark">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('F j, Y') }}
                                            </td>
                                            <td class="text-dark">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $appointment->status == 'accepted'
                                                        ? 'success'
                                                        : ($appointment->status == 'rejected'
                                                            ? 'danger'
                                                            : ($appointment->status == 'rescheduled'
                                                                ? 'warning'
                                                                : 'secondary')) }} px-3 py-2 text-capitalize">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td class="text-capitalize text-dark">{{ $appointment->type ?? 'General' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $appointments->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-4 rounded-4 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>No appointments found.
                </div>
            @endif
        </div>
    </div>
@endsection
