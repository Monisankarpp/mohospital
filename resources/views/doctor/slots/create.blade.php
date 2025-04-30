@extends('layouts.doctor-dashboard')

@section('title', 'Create Slot')

@section('content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Create New Schedule</h2>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('doctor.slots.store') }}">
                            @csrf

                            <!-- Default Schedule Checkbox -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="set_as_default" name="set_as_default"
                                    value="1">
                                <label class="form-check-label fw-medium" for="set_as_default">
                                    Set as default schedule
                                </label>
                            </div>

                            <!-- Days of the Week -->
                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <div class="card mb-4 border rounded-3 shadow-sm">
                                    <div class="card-header bg-light">
                                        <div class="form-check form-switch d-flex align-items-center">
                                            <input class="form-check-input day-toggle" type="checkbox"
                                                id="day-{{ $day }}" name="days[{{ $day }}][is_working]"
                                                value="1"
                                                {{ $defaultSchedule[$day]['is_working'] ?? false ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2 fw-semibold" for="day-{{ $day }}">
                                                {{ ucfirst($day) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div
                                        class="card-body day-fields {{ $defaultSchedule[$day]['is_working'] ?? false ? '' : 'd-none' }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $day }}-start-time" class="form-label">Start
                                                    Time</label>
                                                <input type="time" class="form-control"
                                                    id="{{ $day }}-start-time"
                                                    name="days[{{ $day }}][start_time]"
                                                    value="{{ $defaultSchedule[$day]['start_time'] ?? '09:00' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $day }}-end-time" class="form-label">End
                                                    Time</label>
                                                <input type="time" class="form-control"
                                                    id="{{ $day }}-end-time"
                                                    name="days[{{ $day }}][end_time]"
                                                    value="{{ $defaultSchedule[$day]['end_time'] ?? '17:00' }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $day }}-lunch-start" class="form-label">Lunch
                                                    Start</label>
                                                <input type="time" class="form-control"
                                                    id="{{ $day }}-lunch-start"
                                                    name="days[{{ $day }}][lunch_start]"
                                                    value="{{ $defaultSchedule[$day]['lunch_start'] ?? '13:00' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $day }}-lunch-end" class="form-label">Lunch
                                                    End</label>
                                                <input type="time" class="form-control"
                                                    id="{{ $day }}-lunch-end"
                                                    name="days[{{ $day }}][lunch_end]"
                                                    value="{{ $defaultSchedule[$day]['lunch_end'] ?? '14:00' }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $day }}-slot-duration" class="form-label">Slot
                                                    Duration (minutes)</label>
                                                <input type="number" class="form-control"
                                                    id="{{ $day }}-slot-duration"
                                                    name="days[{{ $day }}][slot_duration]"
                                                    value="{{ $defaultSchedule[$day]['slot_duration'] ?? 30 }}"
                                                    min="15" step="5">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $day }}-break-between" class="form-label">Break
                                                    Between Slots (minutes)</label>
                                                <input type="number" class="form-control"
                                                    id="{{ $day }}-break-between"
                                                    name="days[{{ $day }}][break_between_slots]"
                                                    value="{{ $defaultSchedule[$day]['break_between_slots'] ?? 5 }}"
                                                    min="0" step="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-end mt-4 gap-3">
                                <a href="{{ route('doctor.slots.index') }}" class="btn btn-outline-secondary rounded-pill">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    Save Schedule
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.day-toggle').forEach(function(toggle) {
                toggle.addEventListener('change', function() {
                    const dayFields = this.closest('.card').querySelector('.day-fields');
                    if (this.checked) {
                        dayFields.classList.remove('d-none');
                    } else {
                        dayFields.classList.add('d-none');
                    }
                });
            });
        });
    </script>
@endsection
