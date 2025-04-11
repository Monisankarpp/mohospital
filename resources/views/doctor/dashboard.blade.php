@extends('layouts.doctor-dashboard')

@section('page-title', 'Doctor Dashboard')

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
    <!-- Today's Appointments Card -->
    <div class="col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #4e73df;">
      <div class="card-body">
        <div class="d-flex align-items-center">
        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
          <i class="fas fa-calendar-day text-primary fa-lg"></i>
        </div>
        <div>
          <h3 class="mb-0 fw-bold">8</h3>
          <small class="text-muted">Today's Appointments</small>
        </div>
        </div>
        <div class="mt-3">
        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">
          View All <i class="fas fa-chevron-right ms-1"></i>
        </a>
        </div>
      </div>
      </div>
    </div>

    <!-- Pending Prescriptions Card -->
    <div class="col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1cc88a;">
      <div class="card-body">
        <div class="d-flex align-items-center">
        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
          <i class="fa-solid fa-clock text-success fa-lg"></i>
          {{-- <i class="fas fa-prescription text-success fa-lg"></i> --}}
        </div>
        <div>
          <h3 class="mb-0 fw-bold">5</h3>
          <small class="text-muted">Pending Prescriptions</small>
        </div>
        </div>
        <div class="mt-3">
        <a href="#" class="btn btn-sm btn-outline-success rounded-pill">
          View All <i class="fas fa-chevron-right ms-1"></i>
        </a>
        </div>
      </div>
      </div>
    </div>

    <!-- Patient Messages Card -->
    <div class="col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #f6c23e;">
      <div class="card-body">
        <div class="d-flex align-items-center">
        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
          <i class="fas fa-comments text-warning fa-lg"></i>
        </div>
        <div>
          <h3 class="mb-0 fw-bold">3</h3>
          <small class="text-muted">Unread Messages</small>
        </div>
        </div>
        <div class="mt-3">
        <a href="#" class="btn btn-sm btn-outline-warning rounded-pill">
          View All <i class="fas fa-chevron-right ms-1"></i>
        </a>
        </div>
      </div>
      </div>
    </div>
    </div>

    <!-- Today's Schedule -->
    <div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0 text-primary">
        <i class="fas fa-calendar-alt me-2"></i> Today's Schedule
      </h5>
      <div class="btn-group">
        <button class="btn btn-sm btn-outline-primary">Day</button>
        <button class="btn btn-sm btn-outline-primary">Week</button>
        <button class="btn btn-sm btn-outline-primary">Month</button>
      </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light sticky-top" style="top: -1px;">
        <tr>
          <th class="ps-4">Time</th>
          <th>Patient</th>
          <th>Appointment Type</th>
          <th>Status</th>
          <th class="pe-4 text-end">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ps-4">09:00 AM</td>
          <td>
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" width="40" height="40">
            <div>
            <h6 class="mb-0">John Smith</h6>
            <small class="text-muted">ID: P10045</small>
            </div>
          </div>
          </td>
          <td>Consultation</td>
          <td><span class="badge bg-success bg-opacity-10 text-success">Confirmed</span></td>
          <td class="pe-4 text-end">
          <button class="btn btn-sm btn-outline-primary rounded-pill px-3">
            Start <i class="fas fa-play ms-1"></i>
          </button>
          </td>
        </tr>
        <!-- Additional appointments -->
        </tbody>
      </table>
      </div>
      <div class="card-footer bg-white border-0 text-end py-3">
      <a href="#" class="btn btn-primary rounded-pill px-4">
        <i class="fas fa-plus-circle me-1"></i> Add Availability
      </a>
      </div>
    </div>
    </div>

    <!-- Recent Patients -->
    <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
      <h5 class="mb-0 text-primary">
      <i class="fas fa-user-injured me-2"></i> Recent Patients
      </h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light sticky-top" style="top: -1px;">
        <tr>
          <th class="ps-4">Patient</th>
          <th>Last Visit</th>
          <th>Condition</th>
          <th class="pe-4 text-end">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ps-4">
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" width="40" height="40">
            <div>
            <h6 class="mb-0">Sarah Johnson</h6>
            <small class="text-muted">35 years</small>
            </div>
          </div>
          </td>
          <td>2 days ago</td>
          <td>Hypertension</td>
          <td class="pe-4 text-end">
          <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2">
            <i class="fas fa-file-medical"></i> Records
          </button>
          <button class="btn btn-sm btn-outline-success rounded-pill px-3">
            <i class="fas fa-comment-medical"></i> Message
          </button>
          </td>
        </tr>
        <!-- Additional patients -->
        </tbody>
      </table>
      </div>
      <div class="card-footer bg-white border-0 text-end py-3">
      <a href="#" class="btn btn-primary rounded-pill px-4">
        View All Patients
      </a>
      </div>
    </div>
    </div>
  </div>
@endsection