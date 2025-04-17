@extends('layouts.patient-dashboard')
@section('title', 'Prescriptions')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-light mb-1 text-primary">
                    <i class="fas fa-prescription-bottle-alt me-2"></i> My Prescriptions
                </h2>
                <p class="text-muted small">Your current and past medication records</p>
            </div>
        </div>

        <!-- Prescriptions Table -->
        <div class="card border-0 shadow-xs overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-history me-2"></i> Prescription History
                    </h5>
                </div>
            </div>

            <div class="card-body px-0 pt-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top bg-white" style="top: -1px; z-index: 10;">
                            <tr class="border-bottom">
                                <th class="ps-4 py-3 text-muted small text-uppercase fw-semibold">Prescribed By</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Date</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Medications</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Status</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase fw-semibold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prescriptions as $prescription)
                                <tr class="border-bottom hover-highlight">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md bg-soft-teal text-teal rounded-circle me-3">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $prescription->doctor_name }}</h6>
                                                <small class="text-muted">{{ $prescription->hospital_name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="d-block fw-medium">{{ \Carbon\Carbon::parse($prescription->date)->format('M d, Y') }}</span>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($prescription->date)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-1">
                                            <i class="fas fa-pills me-1"></i> {{ $prescription->medications }} Medications
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-soft-{{ $prescription->status == 'Active' ? 'success' : 'warning' }} text-{{ $prescription->status == 'Active' ? 'success' : 'warning' }} rounded-pill px-3 py-1">
                                            <i
                                                class="fas fa-{{ $prescription->status == 'Active' ? 'check-circle' : 'clock' }} me-1"></i>
                                            {{ $prescription->status }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('invoices.show', $prescription->id) }}">
                                                <button
                                                    class="btn btn-sm btn-outline-primary rounded-pill me-2 px-3 action-btn">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </button>
                                            </a>

                                            <a href="{{ route('generate.invoice', $prescription->id) }}"
                                                class="btn btn-sm btn-outline-success rounded-pill px-3 action-btn"
                                                target="_blank">
                                                <i class="fas fa-download me-1"></i> PDF
                                            </a>
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
                        Showing <span class="fw-semibold">{{ count($prescriptions) }}</span> of <span
                            class="fw-semibold">{{ $prescriptions->count() }}</span> prescriptions
                    </div>
                    <!-- Pagination (if required) -->
                    <!-- Add pagination logic here if needed -->
                </div>
            </div>
        </div>
    </div>
@endsection
