@extends('layouts.doctor-dashboard')

@section('title', 'Edit Slot')

@section('content')
    <div class="container-fluid py-5 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container mt-4">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient text-white" style="background: #4a6cf7; border-radius: 10px 10px 0 0;">
                    <h3 class="mb-0">Edit Time Slot</h3>
                </div>
                <div class="card-body p-5 bg-light rounded-bottom">
                    <form action="{{ route('doctor.slots.update', $slot->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Time Selection -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label text-muted mb-2">Start Time</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white border-end-0">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    <input type="datetime-local" id="start_time" name="start_time"
                                        class="form-control form-control-lg rounded-end shadow-sm"
                                        value="{{ old('start_time', \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d\TH:i')) }}"
                                        required>
                                </div>
                                @error('start_time')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label text-muted mb-2">End Time</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white border-end-0">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    <input type="datetime-local" id="end_time" name="end_time"
                                        class="form-control form-control-lg rounded-end shadow-sm"
                                        value="{{ old('end_time', \Carbon\Carbon::parse($slot->end_time)->format('Y-m-d\TH:i')) }}"
                                        required>
                                </div>
                                @error('end_time')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Slot Booking Status -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-2">Booking Status</label>
                                <div class="form-control-lg p-2 bg-white rounded shadow-sm">
                                    @if ($slot->is_booked)
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-calendar-check me-1"></i> Booked
                                        </span>
                                        <small class="text-muted ms-2">This slot has been booked and cannot be
                                            modified</small>
                                    @else
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-calendar-alt me-1"></i> Available
                                        </span>
                                        <small class="text-muted ms-2">This slot is available for booking</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="doctor_id" value="{{ $slot->doctor_id }}">

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-4 mt-5">
                            <a href="{{ route('doctor.slots.index') }}" class="btn btn-outline-secondary px-5 rounded-pill">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                            @if (!$slot->is_booked)
                                <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                    <i class="fas fa-save me-2"></i> Update Slot
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary px-5 rounded-pill shadow-sm" disabled>
                                    <i class="fas fa-lock me-2"></i> Cannot Edit Booked Slot
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
