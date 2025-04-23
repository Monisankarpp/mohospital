<!-- resources/views/doctor/slots/setup.blade.php -->
@extends('layouts.doctor-dashboard')

@section('title', 'Schedule Management')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container pt-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Appointment Calendar</h2>
                    <p class="text-muted mb-0">Manage your weekly availability</p>
                </div>
                @if ($currentSchedule)
                    <div class="badge bg-primary bg-opacity-10 text-primary p-2">
                        <i class="fas fa-calendar-check me-2"></i>
                        Active: {{ $currentSchedule->valid_from->format('M d') }} -
                        {{ $currentSchedule->valid_to->format('M d') }}
                    </div>
                @endif
            </div>

            <!-- Calendar Controls -->
            <div class="card mb-3 border-0 shadow-sm rounded-3">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-outline-primary rounded-pill me-2">
                                <i class="fas fa-chevron-left me-1"></i> Previous
                            </button>
                            <button class="btn btn-outline-primary rounded-pill">
                                Next <i class="fas fa-chevron-right ms-1"></i>
                            </button>
                        </div>
                        <h5 class="mb-0 fw-semibold text-dark">
                            {{ now()->startOfWeek()->format('M d') }} - {{ now()->endOfWeek()->format('M d, Y') }}
                        </h5>
                        <div>
                            <button class="btn btn-primary rounded-pill px-3">
                                <i class="fas fa-plus me-1"></i> New Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Calendar -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                @if ($currentSchedule)
                    <!-- Calendar Header -->
                    <div class="calendar-header bg-light">
                        <div class="row g-0 text-center">
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                <div class="col border-end">
                                    <div class="p-3">
                                        <div class="text-muted small">{{ substr($day, 0, 3) }}</div>
                                        <div class="fw-medium {{ date('l') === $day ? 'text-primary' : '' }}">
                                            {{ now()->startOfWeek()->addDays(array_search($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']))->format('d') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Calendar Body -->
                    <div class="calendar-body">
                        @php
                            $workingHours = range(8, 18); // 8AM to 6PM
                        @endphp

                        @foreach ($workingHours as $hour)
                            <div class="row g-0 border-top">
                                <!-- Time Column -->
                                <div class="col-1 border-end text-end pe-3 py-2">
                                    <small class="text-muted">{{ sprintf('%02d:00', $hour) }}</small>
                                </div>

                                <!-- Day Columns -->
                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $dayIndex => $day)
                                    @php
                                        $currentDate = now()->startOfWeek()->addDays($dayIndex);
                                        $slotsForDay = $slots->filter(function ($slot) use ($currentDate) {
                                            return $slot->date->format('Y-m-d') === $currentDate->format('Y-m-d');
                                        });
                                    @endphp
                                    <div class="col border-end p-1" style="min-height: 60px;">
                                        @foreach ($slotsForDay as $slot)
                                            <div class="calendar-slot mb-1 rounded-2 p-2 
                                    {{ $slot->is_booked ? 'bg-danger bg-opacity-10' : 'bg-primary bg-opacity-10' }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $slot->start_time->format('h:i A') }} - {{ $slot->end_time->format('h:i A') }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small
                                                        class="{{ $slot->is_booked ? 'text-danger' : 'text-primary' }} fw-medium">
                                                        {{ $slot->start_time->format('h:i') }}-{{ $slot->end_time->format('h:i A') }}
                                                    </small>
                                                    @if ($slot->isEditable())
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm p-0" type="button"
                                                                data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-v text-muted"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('doctor.slots.edit', $slot) }}">
                                                                        <i class="far fa-edit me-2"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('doctor.slots.destroy', $slot) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger"
                                                                            onclick="return confirm('Are you sure?')">
                                                                            <i class="far fa-trash-alt me-2"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if ($slot->is_booked)
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-user me-1"></i> Booked
                                                    </small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-calendar-plus text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-semibold text-muted mb-3">No Schedule Found</h5>
                        <p class="text-muted mb-4">You haven't created any schedule for this week yet.</p>
                        <a href="{{ route('doctor.slots.setup') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-plus me-1"></i> Create New Schedule
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .calendar-header {
            border-bottom: 1px solid #e9ecef;
        }

        .calendar-body {
            background-color: #f8f9fa;
        }

        .calendar-slot {
            transition: all 0.2s ease;
            border-left: 3px solid var(--bs-primary);
        }

        .calendar-slot:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .bg-danger.bg-opacity-10 {
            border-left-color: var(--bs-danger);
        }

        .row {
            margin-right: 0;
            margin-left: 0;
        }

        .col {
            padding-right: 0;
            padding-left: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
