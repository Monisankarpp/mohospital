@extends('layouts.doctor-dashboard')

@section('title', 'My Appointments')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container py-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold text-slate-700">
                        <i class="fas fa-user-injured me-2 text-primary"></i>All Patients
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
                                            <span class="bg-soft-danger text-danger rounded-pill px-3 py-1">
                                                Fever
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span class="bg-soft-danger text-success rounded-pill px-3 py-1">
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
                                        <td colspan="4" class="text-center text-muted py-4">No recent patients found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
