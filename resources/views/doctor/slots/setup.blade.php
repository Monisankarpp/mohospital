<!-- resources/views/doctor/slots/setup.blade.php -->
@extends('layouts.doctor-dashboard')

@section('title', 'Slot-Setup')

@section('content')
    <div class="container-fluid py-5 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Set Up Your Schedule</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('doctor.slots.store') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="start_time" class="col-md-4 col-form-label text-md-right">Start Time</label>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="start_time" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="end_time" class="col-md-4 col-form-label text-md-right">End Time</label>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="end_time" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lunch_start" class="col-md-4 col-form-label text-md-right">Lunch
                                        Start</label>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="lunch_start" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lunch_end" class="col-md-4 col-form-label text-md-right">Lunch End</label>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="lunch_end" required>
                                    </div>
                                </div>

                                <div id="breaks-container">
                                    <!-- Dynamic breaks will be added here -->
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="button" class="btn btn-secondary" id="add-break">
                                            Add Break
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">Working Days</label>
                                    <div class="col-md-6">
                                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]"
                                                    id="day-{{ strtolower($day) }}" value="{{ strtolower($day) }}">
                                                <label class="form-check-label" for="day-{{ strtolower($day) }}">
                                                    {{ $day }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Save Schedule
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-break').addEventListener('click', function() {
            const container = document.getElementById('breaks-container');
            const breakId = Date.now();

            const breakHtml = `
        <div class="form-group row break-row" id="break-${breakId}">
            <label class="col-md-4 col-form-label text-md-right">Break</label>
            <div class="col-md-3">
                <input type="time" class="form-control" name="breaks[${breakId}][start]" required>
            </div>
            <div class="col-md-3">
                <input type="time" class="form-control" name="breaks[${breakId}][end]" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('break-${breakId}').remove()">
                    Remove
                </button>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', breakHtml);
        });
    </script>
@endsection
