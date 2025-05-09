@extends('layouts.base')
@section('title', 'Prescriptions')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5">
        <!-- Header -->
        <div
            class="p-4 rounded-4 bg-light shadow-sm border-start border-4 border-primary d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 mt-4">
            <div class="mb-3 mb-md-0">
                <h3 class="h4 fw-bold text-primary mb-3 d-flex align-items-center">
                    <i class="fas fa-prescription-bottle-alt me-3 text-primary fs-4"></i>
                    My Prescriptions
                </h3>
                <p class="text-muted mb-0">View all your past and active medication records here with ease</p>
            </div>

            <div class="text-md-end">
                <div class="text-muted small">Last Login</div>
                <div class="fw-semibold text-dark">{{ now()->format('M j, Y h:i A') }}</div>
            </div>
        </div>


       <!-- Prescription History Card -->
        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-prescription-bottle-alt me-3 text-primary fs-4"></i>
                    <h5 class="mb-0 text-primary fw-bold border-start border-primary border-4 ps-3 py-1">
                        Prescription History
                    </h5>
                </div>
                @if($prescriptions->total() > 0) {{-- Conditionally show badge --}}
                <span class="badge bg-primary-subtle text-primary-emphasis fw-semibold px-3 py-2 rounded-pill">
                    Total: {{ $prescriptions->total() }}
                </span>
                @endif
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted text-uppercase small sticky-top" style="z-index: 1; top: 0;">
                            <tr class="border-bottom fw-semibold">
                                <th class="ps-4 py-3">Doctor</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Medications</th>
                                <th class="py-3">Status</th>
                                <th class="pe-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prescriptions as $prescription)
                                <tr class="border-bottom prescription-row">
                                    <!-- Doctor Info -->
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex justify-content-center align-items-center me-3"
                                                style="width: 42px; height: 42px;">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $prescription->doctor->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">Main Hospital</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td class="py-3">
                                        <div class="fw-medium">
                                            {{ \Carbon\Carbon::parse($prescription->date)->format('M d, Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($prescription->date)->format('h:i A') }}
                                        </small>
                                    </td>

                                    <!-- Medications -->
                                    <td class="py-3">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                            <i class="fas fa-pills me-1"></i>
                                            {{ $prescription->medications }} Meds
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i> Active
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 view-invoice-btn"
                                                data-url="{{ route('invoices.show', $prescription->id) }}">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-success rounded-pill px-3 download-invoice-btn"
                                                data-url="{{ route('generate.invoice', $prescription->id) }}">
                                                <i class="fas fa-download me-1"></i> PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-notes-medical fa-2x mb-3 text-secondary"></i><br>
                                        No prescriptions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing <strong>{{ $prescriptions->count() }}</strong> of <strong>{{ $prescriptions->total() }}</strong> prescriptions
                </div>
                <div>
                    {{ $prescriptions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>


        <!-- Invoice Modal -->
        <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="invoiceModalLabel">Invoice Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="invoiceModalBody">
                        <div class="text-center text-muted">Loading invoice...</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll('.view-invoice-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const url = btn.dataset.url;
                const modalBody = document.getElementById('invoiceModalBody');
                const modal = new bootstrap.Modal(document.getElementById('invoiceModal'));

                // Show loading state
                modalBody.innerHTML =
                    '<div class="text-center text-muted py-5"><i class="fas fa-spinner fa-spin me-2"></i>Loading invoice...</div>';
                modal.show();

                try {
                    const response = await fetch(url);
                    const html = await response.text();
                    modalBody.innerHTML = html;
                } catch (error) {
                    modalBody.innerHTML =
                        '<div class="text-danger text-center py-4">Failed to load invoice. Please try again later.</div>';
                }
            });
        });

        document.querySelectorAll('.download-invoice-btn').forEach(button => {
            button.addEventListener('click', () => {
                const url = button.dataset.url;

                Swal.fire({
                    title: 'Generating PDF...',
                    text: 'Please wait while we prepare your invoice.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    showConfirmButton: false
                });

                setTimeout(() => {
                    const link = document.createElement('a');
                    link.href = url;
                    link.target = '_blank';
                    link.click();

                    Swal.close();
                }, 2000);
            });
        });
    </script>

@endsection
