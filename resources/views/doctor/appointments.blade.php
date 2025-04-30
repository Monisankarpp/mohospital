@extends('layouts.doctor-dashboard')

@section('title', 'My Appointments')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: #2c3e50;">
                    <i class="fas fa-calendar-alt me-2" style="color: #3498db;"></i>My Appointments
                </h2>
                <p class="mb-0" style="color: #7f8c8d;">View and manage your upcoming patient appointments</p>
            </div>
        </div>

        @if ($appointments->count())
            <div class="card border-0" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold" style="color: #2c3e50;">
                            <i class="fas fa-list-ul me-2" style="color: #3498db;"></i>Appointment List
                        </h5>
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search" style="color: #95a5a6;"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search appointments..."
                                style="color: #34495e;">
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #f8f9fa; color: #7f8c8d;">
                                <tr>
                                    <th scope="col" class="fw-semibold ps-4">Patient</th>
                                    <th scope="col" class="fw-semibold">Date & Time</th>
                                    <th scope="col" class="fw-semibold">Status</th>
                                    <th scope="col" class="fw-semibold">Type</th>
                                    <th scope="col" class="fw-semibold pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr style="border-bottom: 1px solid #ecf0f1;">
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px; background-color: #e3f2fd; color: #3498db;">
                                                    {{ substr($appointment->patient->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold" style="color: #2c3e50;">
                                                        {{ $appointment->patient->name }}</div>
                                                    <small
                                                        style="color: #95a5a6;">{{ $appointment->patient->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-medium" style="color: #2c3e50;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('M j, Y') }}
                                            </div>
                                            <small style="color: #95a5a6;">
                                                {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge rounded-pill px-3 py-2 text-capitalize"
                                                style="{{ $appointment->status == 'accepted'
                                                    ? 'background-color: #e8f5e9; color: #2e7d32;'
                                                    : ($appointment->status == 'rejected'
                                                        ? 'background-color: #ffebee; color: #c62828;'
                                                        : ($appointment->status == 'rescheduled'
                                                            ? 'background-color: #fff8e1; color: #f57f17;'
                                                            : 'background-color: #eceff1; color: #546e7a;')) }}">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-capitalize">
                                            <span class="badge rounded-pill px-3 py-1"
                                                style="background-color: #e3f2fd; color: #1565c0;">
                                                {{ $appointment->type ?? 'General' }}
                                            </span>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3 dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#" style="color: #2c3e50;">
                                                            <i class="fas fa-eye me-2" style="color: #7f8c8d;"></i>View
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" style="color: #2c3e50;">
                                                            <i class="fas fa-edit me-2"
                                                                style="color: #7f8c8d;"></i>Reschedule
                                                        </a>
                                                    </li>
                                                    {{-- <li>
                                                            <a class="dropdown-item" href="#" style="color: #e74c3c;">
                                                                <i class="fas fa-times me-2"></i>Cancel
                                                            </a>
                                                        </li> --}}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white border-0 py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="color: #7f8c8d;">
                                Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of
                                {{ $appointments->total() }} entries
                            </div>
                            <div>
                                {{ $appointments->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card border-0" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-calendar-times" style="font-size: 3rem; color: #bdc3c7;"></i>
                    </div>
                    <h5 class="fw-semibold mb-2" style="color: #2c3e50;">No Appointments Found</h5>
                    <p class="mb-4" style="color: #7f8c8d;">You don't have any upcoming appointments scheduled yet.
                    </p>
                    <button class="btn btn-primary rounded-pill px-4"
                        style="background-color: #3498db; border-color: #3498db;">
                        <i class="fas fa-plus me-1"></i> Create Availability
                    </button>
                </div>
            </div>
        @endif
    </div>
@endsection
