@extends('layouts.patient-dashboard')
@section('title', 'Payments')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-light mb-1 text-primary">
                    <i class="fas fa-prescription-bottle-alt me-2"></i> My Payments
                </h2>
                <p class="text-muted small">Track your medical payment transactions</p>
            </div>
        </div>



        <!-- Prescriptions Table -->
        <div class="card border-0 shadow-xs overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-history me-2"></i> Payment History
                    </h5>
                    <div class="input-group input-group-sm rounded-pill" style="width: 250px;">
                    </div>
                </div>
            </div>

            <div class="card-body px-0 pt-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top bg-white" style="top: -1px; z-index: 10;">
                            <tr class="border-bottom">
                                <th class="ps-4 py-3 text-muted small text-uppercase fw-semibold">Transaction ID</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Date</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Service</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Method</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Amount</th>
                                <th class="py-3 text-muted small text-uppercase fw-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing <span class="fw-semibold">1</span> to <span class="fw-semibold">4</span> of <span
                            class="fw-semibold">12</span> prescriptions
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link rounded-circle" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link rounded-circle" href="#">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Color Palette */
        :root {
            --primary: #5e72e4;
            --teal: #11cdef;
            --lilac: #8965e0;
            --amber: #fb6340;
            --mint: #2dce89;
            --blue: #2b6cb0;

            --soft-teal: rgba(17, 205, 239, 0.1);
            --soft-lilac: rgba(137, 101, 224, 0.1);
            --soft-amber: rgba(251, 99, 64, 0.1);
            --soft-mint: rgba(45, 206, 137, 0.1);
            --soft-blue: rgba(43, 108, 176, 0.1);
            --soft-lavender: rgba(159, 122, 234, 0.1);
            --soft-peach: rgba(250, 140, 101, 0.1);
        }

        .bg-soft-teal {
            background-color: var(--soft-teal);
        }

        .bg-soft-lilac {
            background-color: var(--soft-lilac);
        }

        .bg-soft-amber {
            background-color: var(--soft-amber);
        }

        .bg-soft-mint {
            background-color: var(--soft-mint);
        }

        .bg-soft-blue {
            background-color: var(--soft-blue);
        }

        .bg-soft-lavender {
            background-color: var(--soft-lavender);
        }

        .bg-soft-peach {
            background-color: var(--soft-peach);
        }

        .text-teal {
            color: var(--teal);
        }

        .text-lilac {
            color: var(--lilac);
        }

        .text-amber {
            color: var(--amber);
        }

        /* Custom Elements */
        .stat-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hover-highlight:hover {
            background-color: rgba(94, 114, 228, 0.03) !important;
        }

        .action-btn {
            transition: all 0.2s;
            border-width: 1.5px;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .shadow-xs {
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
        }

        /* Custom Scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endpush

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Prescriptions dashboard loaded');

            document.querySelectorAll('.hover-highlight').forEach(row => {
                row.addEventListener('click', function() {
                    console.log('Prescription clicked');
                });
            });
        });
    </script>
@endsection
