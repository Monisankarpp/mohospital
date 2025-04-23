@extends('layouts.doctor-dashboard')

@section('title', 'Edit Appointment Slot')

@section('content')
    <div class="container-fluid py-5 px-4" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Edit Appointment Slot</h2>
                <a href="{{ route('doctor.schedule.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Back to Schedule
                </a>
            </div>

            <!-- Card -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-light border-bottom py-3">
                    <h5 class="mb-0 fw-semibold text-dark">
                        Editing Slot for {{ $slot->start_time->format('l, M d, Y') }}
                    </h5>
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('doctor.slots.update', $slot) }}" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Start Time -->
                        <div class="mb-4 row">
                            <label for="start_time" class="col-md-3 col-form-label fw-semibold text-end">Start Time</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text text-primary bg-light"><i class="fas fa-clock"></i></span>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                        id="start_time" name="start_time"
                                        value="{{ old('start_time', $slot->start_time->format('H:i')) }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- End Time -->
                        <div class="mb-4 row">
                            <label for="end_time" class="col-md-3 col-form-label fw-semibold text-end">End Time</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text text-primary bg-light"><i class="fas fa-clock"></i></span>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                        id="end_time" name="end_time"
                                        value="{{ old('end_time', $slot->end_time->format('H:i')) }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-save me-1"></i> Update Slot
                                </button>
                                <a href="{{ route('doctor.schedule.index') }}"
                                    class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            forms.forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            });
        })();
    </script>
@endpush
