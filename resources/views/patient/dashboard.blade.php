@extends('layouts.patient-dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5 " style="margin-left: 250px; max-width: calc(100% - 250px);">
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

        <!-- Upcoming Appointments Section -->
        <div class="card mb-4 border-0"
            style="
                border-radius: 16px;
                background: linear-gradient(145deg, #ffffff, #f8f9fa);
                box-shadow: 0 6px 20px rgba(100, 149, 237, 0.15);
                ">
            <div class="card-header bg-transparent border-0 pt-4 pb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-primary" style="font-weight: 600;">
                        <i class="fas fa-calendar-check me-2 text-primary"></i>
                        Upcoming Appointments
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i> Your scheduled consultations
                    </p>
                </div>
                <a href="#" class="btn rounded-pill px-4 py-2"
                    style="
                        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
                        color: white;
                        border: none;
                        font-weight: 500;
                        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
                        ">
                    <i class="fas fa-plus me-2"></i> New Appointment
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="sticky-top" style="top: -1px; background: linear-gradient(145deg, #f1f3ff, #e6e9ff);">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Doctor</th>
                                <th class="py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Specialty</th>
                                <th class="py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Date & Time</th>
                                <th class="py-3 text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Status</th>
                                <th class="pe-4 py-3 text-end text-uppercase text-muted"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Appointment 1 -->
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="
                                                    width: 42px;
                                                    height: 42px;
                                                    background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(108, 92, 231, 0.2));
                                                    ">
                                                <i class="fas fa-user-md" style="color: #6c5ce7;"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0" style="font-weight: 600;">Dr. Sarah Johnson</h6>
                                            <small class="text-muted" style="font-size: 0.8rem;">Cardiologist</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill py-2 px-3"
                                        style="
                                            background: rgba(108, 92, 231, 0.1);
                                            color: #6c5ce7;
                                            font-weight: 500;
                                            ">
                                        Cardiology
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="font-weight: 500;">15 Jun, 2023</div>
                                        <small class="text-muted" style="font-size: 0.85rem;">10:00 AM - 10:30 AM</small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill py-2 px-3"
                                        style="
                                            background: rgba(46, 213, 115, 0.1);
                                            color: #2ed573;
                                            font-weight: 500;
                                            ">
                                        <i class="fas fa-check-circle me-1"></i> Confirmed
                                    </span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm rounded-pill px-3 py-2"
                                        style="
                                            background: rgba(108, 92, 231, 0.1);
                                            color: #6c5ce7;
                                            border: none;
                                            font-weight: 500;
                                            ">
                                        Details <i class="fas fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Appointment 2 -->
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="
                                                    width: 42px;
                                                    height: 42px;
                                                    background: linear-gradient(135deg, rgba(253, 121, 168, 0.1), rgba(253, 121, 168, 0.2));
                                                    ">
                                                <i class="fas fa-user-md" style="color: #fd79a8;"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0" style="font-weight: 600;">Dr. Michael Chen</h6>
                                            <small class="text-muted" style="font-size: 0.8rem;">Neurologist</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill py-2 px-3"
                                        style="
                                            background: rgba(253, 121, 168, 0.1);
                                            color: #fd79a8;
                                            font-weight: 500;
                                            ">
                                        Neurology
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="font-weight: 500;">18 Jun, 2023</div>
                                        <small class="text-muted" style="font-size: 0.85rem;">02:30 PM - 03:00 PM</small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill py-2 px-3"
                                        style="
                                            background: rgba(255, 165, 2, 0.1);
                                            color: #ffa502;
                                            font-weight: 500;
                                            ">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm rounded-pill px-3 py-2"
                                        style="
                                            background: rgba(253, 121, 168, 0.1);
                                            color: #fd79a8;
                                            border: none;
                                            font-weight: 500;
                                            ">
                                        Details <i class="fas fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-transparent border-0 text-center py-3">
                <a href="#" class="text-decoration-none"
                    style="
                        color: #6c5ce7;
                        font-weight: 500;
                        transition: all 0.2s ease;
                        ">
                    View All Appointments <i class="fas fa-chevron-down ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Recent Prescriptions Table - Enhanced UI -->
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3 pb-2 px-4">
                <div>
                    <h5 class="mb-0 text-primary fw-semibold">
                        <i class="fa-solid fa-prescription-bottle-medical"></i> Recent Prescriptions
                    </h5>
                </div>
                <a href="#" class="btn btn-sm btn-primary rounded-pill px-4 hover-scale">
                    <i class="bi bi-list-ul me-1"></i>View All
                </a>
            </div>

            <div class="card-body px-0 pt-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top" style="top: -1px;">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase fw-semibold text-muted small">Doctor</th>
                                <th class="py-3 text-uppercase fw-semibold text-muted small">Date</th>
                                <th class="py-3 text-uppercase fw-semibold text-muted small">Medications</th>
                                <th class="pe-4 py-3 text-uppercase fw-semibold text-muted small text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Prescription Row 1 -->
                            <tr class="border-top-0 border-bottom">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-3"
                                            width="40" height="40" alt="Dr. Sarah Johnson">
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Dr. Sarah Johnson</h6>
                                            <small class="text-muted">Cardiology</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="text-dark">10 Jun, 2023</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-primary rounded-pill px-3 py-1">3 medications</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2 hover-scale">
                                        <i class="bi bi-eye me-1"></i>View
                                    </button>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 hover-scale">
                                        <i class="bi bi-download me-1"></i>Download
                                    </button>
                                </td>
                            </tr>

                            <!-- Prescription Row 2 -->
                            <tr class="border-bottom">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40/e3f2fd/1976d2"
                                            class="rounded-circle me-3" width="40" height="40"
                                            alt="Dr. Michael Chen">
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Dr. Michael Chen</h6>
                                            <small class="text-muted">Neurology</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="text-dark">5 Jun, 2023</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-primary rounded-pill px-3 py-1">2 medications</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2 hover-scale">
                                        <i class="bi bi-eye me-1"></i>View
                                    </button>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 hover-scale">
                                        <i class="bi bi-download me-1"></i>Download
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>
@endsection
