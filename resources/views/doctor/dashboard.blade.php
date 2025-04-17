@extends('layouts.doctor-dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold text-primary mb-1">
                    <i class="fas fa-user-md me-2"></i> Doctor Dashboard
                </h2>
                <p class="text-muted mb-0">Welcome back, Dr. {{ auth()->user()->name }}</p>
            </div>
            <div class="text-end">
                <small class="text-muted d-block">Last login</small>
                <span class="fw-semibold">{{ now()->format('M j, Y h:i A') }}</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <!-- Upcoming Appointments Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fa-solid fa-calendar text-primary fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">5</h3>
                                <small class="text-muted">Upcoming Appointments</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="" class="btn btn-sm btn-outline-primary rounded-pill">
                                View All <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescriptions Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fa-solid fa-file-medical text-success fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">3</h3>
                                <small class="text-muted">Active Prescriptions</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="" class="btn btn-sm btn-outline-success rounded-pill">
                                View All <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fa-solid fa-sack-dollar text-warning fa-xl"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold">2</h3>
                                <small class="text-muted">Pending Payments</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="" class="btn btn-sm btn-outline-warning rounded-pill">
                                View All <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule - USA Client Grade UI -->
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-header bg-white border-0 py-4 px-4 rounded-top-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0 fw-bold text-slate-700">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>Today's Schedule
                    </h5>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <a href="{{ route('doctor.slots.create') }}"
                            class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                            <i class="fas fa-plus-circle me-1"></i> Add Availability
                        </a>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary">Day</button>
                            <button class="btn btn-sm btn-outline-primary">Week</button>
                            <button class="btn btn-sm btn-outline-primary">Month</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table align-middle table-borderless mb-0">
                        <thead class="bg-light text-muted sticky-top" style="top: -1px;">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-bold">Time</th>
                                <th class="text-uppercase small fw-bold">Patient</th>
                                <th class="text-uppercase small fw-bold">Type</th>
                                <th class="text-uppercase small fw-bold">Status</th>
                                <th class="pe-4 text-end text-uppercase small fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-top border-light">
                                <td class="ps-4 py-3 text-dark">09:00 AM</td>
                                <td class="py-3">
                                    <div>
                                        <h6 class="mb-1 fw-semibold text-dark">John Smith</h6>
                                        <small class="text-muted">ID: P10045</small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-soft-primary text-primary rounded-pill px-3 py-1">Consultation</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-soft-success text-success rounded-pill px-3 py-1">Confirmed</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 hover-scale">
                                        <i class="fas fa-play me-1"></i> Start
                                    </button>
                                </td>
                            </tr>

                            <!-- Example Additional Row -->
                            <tr class="border-top border-light">
                                <td class="ps-4 py-3 text-dark">10:30 AM</td>
                                <td class="py-3">
                                    <div>
                                        <h6 class="mb-1 fw-semibold text-dark">Emily Davis</h6>
                                        <small class="text-muted">ID: P10078</small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-soft-info text-info rounded-pill px-3 py-1">Follow-up</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-soft-warning text-warning rounded-pill px-3 py-1">Pending</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 hover-scale">
                                        <i class="fas fa-play me-1"></i> Start
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Recent Patients -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-4 px-4 rounded-top-4">
                <h5 class="mb-0 fw-bold text-slate-700">
                    <i class="fas fa-user-injured me-2 text-primary"></i>Recent Patients
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
                                <th class="pe-4 text-end text-uppercase small fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-top border-light">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded-circle shadow-sm me-3"
                                            width="40" height="40">
                                        <div>
                                            <h6 class="mb-1 fw-semibold text-dark">Sarah Johnson</h6>
                                            <small class="text-muted">35 years</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted">2 days ago</td>
                                <td class="py-3">
                                    <span
                                        class="badge bg-soft-danger text-danger rounded-pill px-3 py-1">Hypertension</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2 hover-scale">
                                        <i class="fas fa-file-medical me-1"></i>Records
                                    </button>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 hover-scale">
                                        <i class="fas fa-comment-medical me-1"></i>Message
                                    </button>
                                </td>
                            </tr>

                            <!-- Add more patient rows below this -->
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-0 text-end py-3 px-4">
                    <a href="#" class="btn btn-primary rounded-pill px-4 shadow-sm hover-scale">
                        View All Patients
                    </a>
                </div>
            </div>
        </div>


    </div>
@endsection

<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-soft-success {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-soft-info {
        background-color: rgba(13, 202, 240, 0.1);
    }

    .bg-soft-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .hover-scale:hover {
        transform: scale(1.03);
        transition: all 0.2s ease-in-out;
    }
</style>
