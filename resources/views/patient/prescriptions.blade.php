@extends('layouts.patient-dashboard')
@section('title', 'Prescriptions')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5 " style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mb-4 gap-3">
            <div>
                <h3 class="h5 fw-semibold text-dark"> My Prescriptions</h3>
                <p class="text-muted small">Manage all your prescriptions here</p>
            </div>
        </div>
    </div>
@endsection
