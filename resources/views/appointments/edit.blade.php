@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i> Edit Appointment
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('patient.appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <input type="text" class="form-control" value="Dr. {{ $appointment->slot->doctor->user->name }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Specialty</label>
                        <input type="text" class="form-control" value="{{ $appointment->slot->doctor->specialization }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time</label>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('h:i A') }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Change Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="accepted" {{ $appointment->status == 'accepted' ? 'selected' : '' }}>Accepted
                            </option>
                            <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                            <option value="rescheduled" {{ $appointment->status == 'rescheduled' ? 'selected' : '' }}>
                                Rescheduled</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success rounded-pill">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                        <a href="{{ route('patient.appointments.view', $appointment->id) }}"
                            class="btn btn-secondary rounded-pill ms-2">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
