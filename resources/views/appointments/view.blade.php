@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i> Appointment Details
                </h5>
            </div>
            <div class="card-body">
                <p><strong>Doctor:</strong> Dr. {{ $appointment->slot->doctor->user->name }}</p>
                <p><strong>Specialty:</strong> {{ $appointment->slot->doctor->specialization }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</p>
                <p><strong>Time:</strong>
                    {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}
                </p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-secondary text-capitalize">{{ $appointment->status }}</span>
                </p>

                <a href="{{ route('patient.appointments.edit', $appointment->id) }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-edit me-1"></i> Edit Appointment
                </a>
                <a href="{{ route('patient.appointments.book') }}" class="btn btn-outline-secondary rounded-pill ms-2">
                    <i class="fas fa-plus me-1"></i> Book New
                </a>
            </div>
        </div>
    </div>
@endsection
