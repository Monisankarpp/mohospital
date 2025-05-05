@extends('layouts.doctor-dashboard')

@section('title', 'Edit Appointment Slot')

@section('content')
    <div class="container-fluid py-5 px-4" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h2 class="h5 mb-0 py-2">Edit Appointment Slot</h2>
                    </div>
                    <div class="card-body p-5 bg-light rounded-bottom-4">

                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3">
                                <strong>Whoops! Something went wrong:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('doctor.slots.update', $slot) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="start_time" class="form-label fw-semibold">Start Time</label>
                                <input type="text"
                                    class="form-control form-control-lg rounded-3 shadow-sm datetime-picker" id="start_time"
                                    name="start_time" value="{{ $slot->start_time->format('Y-m-d H:i') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="end_time" class="form-label fw-semibold">End Time</label>
                                <input type="text"
                                    class="form-control form-control-lg rounded-3 shadow-sm datetime-picker" id="end_time"
                                    name="end_time" value="{{ $slot->end_time->format('Y-m-d H:i') }}" required>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('doctor.slots.index') }}"
                                    class="btn btn-outline-secondary rounded-pill px-4 py-2 shadow-sm">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                    Update Slot
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
            flatpickr(".datetime-picker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                minuteIncrement: 5,
                allowInput: true,
            });
        });
    </script>

@endsection
