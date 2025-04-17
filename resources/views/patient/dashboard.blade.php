@extends('layouts.patient-dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5 " style="margin-left: 250px; max-width: calc(100% - 250px);">

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
        <div class="card border-0"
            style="border-radius: 16px; background: linear-gradient(135deg, #f8fbfe 0%, #f0f7ff 100%); box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);">
            <!-- Card Header with View All Button -->
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center p-4 pb-0">
                <div>
                    <span class="badge rounded-pill px-3 py-2 mb-2"
                        style="background: rgba(25, 118, 210, 0.1); color: #1976d2; font-size: 12px;">
                        <i class="fas fa-prescription-bottle-alt me-2"></i>ACTIVE PRESCRIPTION
                    </span>
                    <h3 class="mb-0" style="color: #2d3748; font-weight: 600;">Current Medication Plan</h3>
                </div>
                <a href="{{ route('patient.prescriptions') }}" class="btn btn-sm rounded-pill px-4 py-2 hover-scale"
                    style="background: #1976d2; color: white; box-shadow: 0 4px 12px rgba(25, 118, 210, 0.25);">
                    <i class="fas fa-list-ul me-2"></i>View All Prescriptions
                </a>
            </div>

            <div class="card-body p-4 pt-2">
                <!-- Doctor Info Section -->
                <div class="d-flex align-items-center mb-4 p-3"
                    style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <div
                        style="width: 40px; height: 40px; background: #e8f0fe; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                        <i class="fas fa-user-md" style="font-size: 18px; color: #4a6cf7;"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" style="color: #2d3748; font-weight: 600;">Dr. Sarah Johnson</h5>
                        <p class="mb-1" style="color: #718096; font-size: 14px;">Cardiology Specialist</p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt me-2" style="color: #718096; font-size: 12px;"></i>
                            <span style="color: #4a5568; font-size: 13px; font-weight: 500;">Last Updated: June 10,
                                2023</span>
                        </div>
                    </div>
                </div>

                <!-- Medications List -->
                <div class="mb-4">
                    <h6 class="mb-3" style="color: #4a5568; font-weight: 600; font-size: 15px;">
                        <i class="fas fa-pills me-2" style="color: #1976d2;"></i>PRESCRIBED MEDICATIONS
                    </h6>

                    <div class="row g-3">
                        <!-- Medication 1 -->
                        <div class="col-md-6">
                            <div class="p-3 d-flex align-items-center"
                                style="background: white; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                                <div class="me-3"
                                    style="width: 36px; height: 36px; background: rgba(25, 118, 210, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-pills" style="color: #1976d2;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0" style="color: #2d3748; font-size: 14px; font-weight: 600;">
                                        Atorvastatin</h6>
                                    <p class="mb-0" style="color: #718096; font-size: 13px;">20mg · Once daily · Oral
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Medication 2 -->
                        <div class="col-md-6">
                            <div class="p-3 d-flex align-items-center"
                                style="background: white; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                                <div class="me-3"
                                    style="width: 36px; height: 36px; background: rgba(25, 118, 210, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-pills" style="color: #1976d2;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0" style="color: #2d3748; font-size: 14px; font-weight: 600;">
                                        Metoprolol</h6>
                                    <p class="mb-0" style="color: #718096; font-size: 13px;">50mg · Twice daily · Oral
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-2">
                    <div>
                        <i class="fas fa-info-circle me-2" style="color: #718096;"></i>
                        <span style="color: #718096; font-size: 13px;">Valid until: <strong style="color: #4a5568;">Dec
                                15, 2023</strong></span>
                    </div>
                    <div>
                        <button class="btn btn-sm rounded-pill px-4 py-2 me-2 hover-scale"
                            style="background: white; color: #1976d2; border: 1px solid #e2e8f0;">
                            <i class="fas fa-eye me-2"></i>View Details
                        </button>
                        <button class="btn btn-sm rounded-pill px-4 py-2 hover-scale"
                            style="background: #1976d2; color: white; box-shadow: 0 4px 12px rgba(25, 118, 210, 0.25);">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
