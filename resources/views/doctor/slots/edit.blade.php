@extends('layouts.doctor-dashboard')

@section('title', 'Edit Appointment Slot')

@section('content')
    <div class="container-fluid py-5 px-4" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h2>Edit Slot</h2>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops! Something went wrong:</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('doctor.slots.update', $slot) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="start_time">Start Time</label>
                                    <input type="datetime-local" class="form-control" id="start_time" name="start_time"
                                        value="{{ $slot->start_time->format('Y-m-d\TH:i') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="end_time">End Time</label>
                                    <input type="datetime-local" class="form-control" id="end_time" name="end_time"
                                        value="{{ $slot->end_time->format('Y-m-d\TH:i') }}" required>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Slot
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
@endsection
