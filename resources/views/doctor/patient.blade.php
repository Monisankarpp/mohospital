@extends('layouts.base')

@section('title', 'My Patients')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5">
        <div
            class="p-4 rounded-4 bg-light shadow-sm border-start border-4 border-primary d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 mt-4">
            <div class="mb-3 mb-md-0">
                <h2 class="h4 fw-bold text-primary mb-3 d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-3 text-primary fs-4"></i>
                    My  Patient Details
                </h2>
                <p class="text-muted mb-0">Review patient history, appointments, and prescribed treatments</p>
            </div>

            <div class="text-md-end">
                <div class="text-muted small">Last Login</div>
                <div class="fw-semibold text-dark">{{ now()->format('M j, Y h:i A') }}</div>
            </div>
        </div>
        <div class="card border-0 shadow rounded-3 overflow-hidden">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-user-injured me-2"></i>All Patients
                    </h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchInput"
                            placeholder="Search patients...">
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="patientsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-bold text-muted">Patient</th>
                                <th class="text-uppercase small fw-bold text-muted">Last Visit</th>
                                <th class="text-uppercase small fw-bold text-muted">Condition</th>
                                <th class="text-uppercase small fw-bold text-muted">Consultation</th>
                                <th class="pe-4 text-end text-uppercase small fw-bold text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPatients as $appointment)
                                <tr class="patient-row" data-patient="{{ strtolower($appointment->name) }}"
                                    data-date="{{ $appointment->created_at->format('M d, Y') }}">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-info bg-opacity-10 text-info rounded-circle">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ $appointment->name }}</h6>
                                                <small class="text-muted">{{ rand(15, 80) }} years • ID:
                                                    {{ $appointment->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted">{{ $appointment->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                            Fever
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                            $100
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('doctor.message.patient', ['patient_id' => $appointment->id]) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-comment-medical me-1"></i>Message
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="py-5">
                                            <i class="fas fa-user-slash text-muted" style="font-size: 2rem;"></i>
                                            <h5 class="mt-3 text-muted">No patients found</h5>
                                            <p class="text-muted">You don't have any patients yet</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $recentPatients->firstItem() ?? 0 }} to {{ $recentPatients->lastItem() ?? 0 }} of
                        {{ $recentPatients->total() ?? 0 }} entries
                    </div>
                    <div>
                        {{ $recentPatients->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('.patient-row');

            rows.forEach(row => {
                const patientName = row.getAttribute('data-patient');
                const lastVisitDate = row.getAttribute('data-date');

                if (patientName.includes(query) || lastVisitDate.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
