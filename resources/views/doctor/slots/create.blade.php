@extends('layouts.doctor-dashboard')

@section('title', 'Create Slot')

@section('content')
    <div class="container-fluid py-5 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container mt-4">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient text-white" style="background: #4a6cf7; border-radius: 10px 10px 0 0;">
                    <h3 class="mb-0">{{ isset($slot) ? 'Edit Time Slot' : 'Add New Time Slot' }}</h3>
                </div>
                <div class="card-body p-5 bg-light rounded-bottom">
                    <form action="{{ isset($slot) ? route('doctor.slots.update', $slot->id) : route('doctor.slots.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($slot))
                            @method('PUT')
                        @endif

                        <!-- Department Selection -->
                        <div class="mb-4">
                            <label for="department" class="form-label text-muted mb-2">Department</label>
                            <select name="doctor_department_id" id="department"
                                class="form-select form-select-lg shadow-sm rounded-3" required>
                                <option value="">Select Department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('doctor_department_id', $slot->doctor_department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->specialization ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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
                                        value="{{ old('start_time', isset($slot) ? $slot->start_time->format('Y-m-d\TH:i') : '') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label text-muted mb-2">End Time</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white border-end-0">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    <input type="datetime-local" id="end_time" name="end_time"
                                        class="form-control form-control-lg rounded-end shadow-sm"
                                        value="{{ old('end_time', isset($slot) ? $slot->end_time->format('Y-m-d\TH:i') : '') }}"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-4 mt-5">
                            <a href="{{ route('doctor.slots.index') }}" class="btn btn-outline-secondary px-5 rounded-pill">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                <i class="fas fa-save me-2"></i> {{ isset($slot) ? 'Update Slot' : 'Create Slot' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
