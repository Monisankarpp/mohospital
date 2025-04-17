@extends('layouts.doctor')

@section('content')
    <div class="container mt-4">
        <h3>{{ isset($slot) ? 'Edit Slot' : 'Add Slot' }}</h3>
        <form action="{{ isset($slot) ? route('doctor.slots.update', $slot->id) : route('doctor.slots.store') }}"
            method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            @if (isset($slot))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="doctor_department_id" class="form-select" required>
                    <option value="">Choose...</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('doctor_department_id', $slot->doctor_department_id ?? '') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->department->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control"
                    value="{{ old('start_time', isset($slot) ? $slot->start_time->format('Y-m-d\TH:i') : '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control"
                    value="{{ old('end_time', isset($slot) ? $slot->end_time->format('Y-m-d\TH:i') : '') }}" required>
            </div>

            <button class="btn btn-success">{{ isset($slot) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('doctor.slots.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
