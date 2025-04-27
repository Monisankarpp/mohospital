@extends('layouts.doctor-dashboard')

@section('title', 'Schedule Setup')

@section('content')
    <div class="container-fluid py-5 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ URL::previous() }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <!-- Card Header -->
                        <div class="card-header bg-white py-4 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="h3 fw-bold text-primary mb-1">
                                        <i class="far fa-calendar-plus me-2"></i>
                                        Schedule Setup
                                    </h2>
                                    <p class="text-muted mb-0">Configure your availability for patient appointments</p>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-user-md me-1"></i> Doctor Settings
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 p-lg-5">
                            <form method="POST" action="{{ route('doctor.slots.store') }}" class="needs-validation"
                                novalidate>
                                @csrf

                                <!-- Time Section -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                                            <i class="fas fa-clock fs-5"></i>
                                        </div>
                                        <h5 class="fw-semibold mb-0">Working Hours</h5>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="time" class="form-control border-2 py-3" id="start_time"
                                                    name="start_time" required>
                                                <label for="start_time">Start Time</label>
                                                <div class="invalid-feedback">
                                                    Please provide a start time
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="time" class="form-control border-2 py-3" id="end_time"
                                                    name="end_time" required>
                                                <label for="end_time">End Time</label>
                                                <div class="invalid-feedback">
                                                    Please provide an end time
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="time" class="form-control border-2 py-3" id="lunch_start"
                                                    name="lunch_start" required>
                                                <label for="lunch_start">Lunch Start</label>
                                                <div class="invalid-feedback">
                                                    Please provide lunch start time
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="time" class="form-control border-2 py-3" id="lunch_end"
                                                    name="lunch_end" required>
                                                <label for="lunch_end">Lunch End</label>
                                                <div class="invalid-feedback">
                                                    Please provide lunch end time
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Breaks Section -->
                                <div class="mb-5">
                                    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                                <i class="fas fa-coffee fs-5"></i>
                                            </div>
                                            <h5 class="fw-semibold mb-0">Breaks</h5>
                                        </div>
                                        <button type="button" class="btn btn-primary rounded-pill px-4" id="add-break">
                                            <i class="fas fa-plus me-1"></i> Add Break
                                        </button>
                                    </div> --}}

                                    <div id="breaks-container" class="row g-3">
                                        <!-- Dynamic breaks will be added here -->
                                    </div>
                                </div>

                                <!-- Working Days Section -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                                            <i class="far fa-calendar-alt fs-5"></i>
                                        </div>
                                        <h5 class="fw-semibold mb-0">Working Days</h5>
                                    </div>

                                    <div class="row g-3">
                                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                            <div class="col-md-4">
                                                <div class="form-check card p-3 border-0 shadow-sm h-100">
                                                    <input class="form-check-input" type="checkbox" name="working_days[]"
                                                        id="day-{{ strtolower($day) }}" value="{{ strtolower($day) }}">
                                                    <label class="form-check-label fw-medium d-flex align-items-center"
                                                        for="day-{{ strtolower($day) }}">
                                                        <div class="bg-white rounded-circle p-2 me-2 shadow-sm">
                                                            <i class="far fa-calendar text-primary"></i>
                                                        </div>
                                                        {{ $day }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center pt-3">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold">
                                        <i class="far fa-save me-2"></i> Save Schedule
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add break functionality
        document.getElementById('add-break').addEventListener('click', function() {
            const container = document.getElementById('breaks-container');
            const breakId = Date.now();

            const breakHtml = `
                <div class="col-md-12" id="break-${breakId}">
                    <div class="card p-3 border-0 shadow-sm mb-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Break Time</label>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="time" class="form-control border-2" name="breaks[${breakId}][start]" required>
                                    <label>Start</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="time" class="form-control border-2" name="breaks[${breakId}][end]" required>
                                    <label>End</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger rounded-pill w-100" 
                                        onclick="document.getElementById('break-${breakId}').remove()">
                                    <i class="far fa-trash-alt me-1"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', breakHtml);
        });

        // Form validation
        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection
