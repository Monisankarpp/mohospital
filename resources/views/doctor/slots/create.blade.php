@extends('layouts.doctor-dashboard')

@section('title', 'Create Slot')

@section('content')
    <div class="container-fluid py-5 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Create New Schedule</h2>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('doctor.slots.store') }}">
                                @csrf

                                <div class="form-group form-check mb-4">
                                    <input type="checkbox" class="form-check-input" id="set_as_default"
                                        name="set_as_default" value="1">
                                    <label class="form-check-label" for="set_as_default">Set as default schedule</label>
                                </div>

                                @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input day-toggle" type="checkbox"
                                                    id="day-{{ $day }}"
                                                    name="days[{{ $day }}][is_working]" value="1"
                                                    {{ $defaultSchedule[$day]['is_working'] ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day-{{ $day }}">
                                                    <strong>{{ ucfirst($day) }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body day-fields"
                                            style="{{ $defaultSchedule[$day]['is_working'] ?? false ? '' : 'display: none;' }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $day }}-start-time">Start Time</label>
                                                        <input type="time" class="form-control"
                                                            id="{{ $day }}-start-time"
                                                            name="days[{{ $day }}][start_time]"
                                                            value="{{ $defaultSchedule[$day]['start_time'] ?? '09:00' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $day }}-end-time">End Time</label>
                                                        <input type="time" class="form-control"
                                                            id="{{ $day }}-end-time"
                                                            name="days[{{ $day }}][end_time]"
                                                            value="{{ $defaultSchedule[$day]['end_time'] ?? '17:00' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $day }}-lunch-start">Lunch Start</label>
                                                        <input type="time" class="form-control"
                                                            id="{{ $day }}-lunch-start"
                                                            name="days[{{ $day }}][lunch_start]"
                                                            value="{{ $defaultSchedule[$day]['lunch_start'] ?? '13:00' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $day }}-lunch-end">Lunch End</label>
                                                        <input type="time" class="form-control"
                                                            id="{{ $day }}-lunch-end"
                                                            name="days[{{ $day }}][lunch_end]"
                                                            value="{{ $defaultSchedule[$day]['lunch_end'] ?? '14:00' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $day }}-slot-duration">Slot Duration
                                                            (minutes)
                                                        </label>
                                                        <input type="number" class="form-control"
                                                            id="{{ $day }}-slot-duration"
                                                            name="days[{{ $day }}][slot_duration]"
                                                            value="{{ $defaultSchedule[$day]['slot_duration'] ?? 30 }}"
                                                            min="15" step="5">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $day }}-break-between">Break Between Slots
                                                            (minutes)</label>
                                                        <input type="number" class="form-control"
                                                            id="{{ $day }}-break-between"
                                                            name="days[{{ $day }}][break_between_slots]"
                                                            value="{{ $defaultSchedule[$day]['break_between_slots'] ?? 5 }}"
                                                            min="0" step="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save Schedule
                                    </button>
                                    <a href="{{ route('doctor.slots.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
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
                        dayFields.style.display = '';
                    } else {
                        dayFields.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
