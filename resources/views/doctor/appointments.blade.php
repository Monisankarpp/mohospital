@extends('layouts.doctor-dashboard')

@section('title', 'My Appointments')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container pt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>My Appointments
                </h2>
            </div>

            @if ($appointments->count())
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Patient</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $appointment->patient->name }}</div>
                                                <small class="text-muted">{{ $appointment->patient->email }}</small>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('F j, Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $appointment->status == 'accepted'
                                                        ? 'success'
                                                        : ($appointment->status == 'rejected'
                                                            ? 'danger'
                                                            : ($appointment->status == 'rescheduled'
                                                                ? 'warning'
                                                                : 'secondary')) }} text-capitalize">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($appointment->type ?? 'general') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>No appointments found.
                </div>
            @endif
        </div>
    </div>
@endsection
