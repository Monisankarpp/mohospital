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

    <!-- Upcoming Appointments Table -->
    <div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white border-0 pt-3 pb-2">
      <h5 class="mb-0 text-primary">
      <i class="bi bi-calendar2-week me-2"></i> Upcoming Appointments
      </h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light sticky-top" style="top: -1px;">
        <tr>
          <th class="ps-4">Doctor</th>
          <th>Department</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th class="pe-4 text-end">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ps-4">
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" width="40" height="40">
            <div>
            <h6 class="mb-0">Dr. Sarah Johnson</h6>
            <small class="text-muted">Cardiology</small>
            </div>
          </div>
          </td>
          <td>Cardiology</td>
          <td>15 Jun, 2023</td>
          <td>10:00 AM</td>
          <td><span class="badge bg-success bg-opacity-10 text-success">Confirmed</span></td>
          <td class="pe-4 text-end">
          <button class="btn btn-sm btn-outline-primary rounded-pill px-3">
            View <i class="bi bi-chevron-right ms-1"></i>
          </button>
          </td>
        </tr>
        <!-- Additional rows can be added here -->
        </tbody>
      </table>
      </div>
      <div class="card-footer bg-white border-0 text-end py-3">
      <a href="" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Book New Appointment
      </a>
      </div>
    </div>
    </div>

    <!-- Recent Prescriptions Table -->
    <div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 pt-3 pb-2">
      <h5 class="mb-0 text-primary">
      <i class="bi bi-prescription2 me-2"></i> Recent Prescriptions
      </h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light sticky-top" style="top: -1px;">
        <tr>
          <th class="ps-4">Doctor</th>
          <th>Date</th>
          <th>Medications</th>
          <th class="pe-4 text-end">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ps-4">
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" width="40" height="40">
            <div>
            <h6 class="mb-0">Dr. Sarah Johnson</h6>
            <small class="text-muted">Cardiology</small>
            </div>
          </div>
          </td>
          <td>10 Jun, 2023</td>
          <td>3 medications</td>
          <td class="pe-4 text-end">
          <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2">
            <i class="bi bi-eye"></i> View
          </button>
          <button class="btn btn-sm btn-outline-success rounded-pill px-3">
            <i class="bi bi-download"></i> Download
          </button>
          </td>
        </tr>
        <!-- Additional rows can be added here -->
        </tbody>
      </table>
      </div>
      <div class="card-footer bg-white border-0 text-end py-3">
      <a href="" class="btn btn-primary rounded-pill px-4">
        View All Prescriptions
      </a>
      </div>
    </div>
    </div>
  </div>
@endsection