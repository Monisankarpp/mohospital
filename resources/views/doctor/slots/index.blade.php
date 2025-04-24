@extends('layouts.doctor-dashboard')

@section('title', 'Schedule Management')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container pt-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">Schedule Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="font-size: 0.875rem;">
                            <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointment Slots</li>
                        </ol>
                    </nav>
                </div>
                @if ($currentSchedule)
                    <div class="badge bg-primary bg-opacity-10 text-primary p-2 rounded-pill">
                        <i class="fas fa-calendar-check me-2"></i>
                        Active Schedule: {{ $currentSchedule->valid_from->format('M d') }} -
                        {{ $currentSchedule->valid_to->format('M d') }}
                    </div>
                @endif
            </div>

            <!-- Main Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="far fa-calendar-alt me-2 text-primary"></i>
                            Weekly Appointment Slots
                        </h5>
                        <a href="{{ route('doctor.slots.setup') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-plus me-1"></i> Create New Schedule
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    @if ($currentSchedule)
                        <!-- Calendar View -->
                        <div class="p-4">
                            {{-- <div class="row mb-4">
                                <!-- Week Navigation -->
                                <div class="col-md-6">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-primary rounded-start-pill">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="btn btn-outline-primary disabled">
                                            {{ $currentSchedule->valid_from->format('M d') }} -
                                            {{ $currentSchedule->valid_to->format('M d') }}
                                        </button>
                                        <button class="btn btn-outline-primary rounded-end-pill">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-primary active">Week</button>
                                        <button class="btn btn-outline-primary">Month</button>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Week Days Header -->
                            <div class="row g-2 mb-3">
                                @php
                                    $days = [];
                                    $currentDate = clone $currentSchedule->valid_from;
                                    while ($currentDate <= $currentSchedule->valid_to) {
                                        $days[] = clone $currentDate;
                                        $currentDate->modify('+1 day');
                                    }
                                @endphp

                                @foreach ($days as $day)
                                    <div class="col">
                                        <div
                                            class="text-center p-2 rounded-3 {{ $day->format('Y-m-d') == now()->format('Y-m-d') ? 'bg-primary bg-opacity-10' : '' }}">
                                            <div class="text-muted small">{{ $day->format('D') }}</div>
                                            <div
                                                class="fw-bold {{ $day->format('Y-m-d') == now()->format('Y-m-d') ? 'text-primary' : '' }}">
                                                {{ $day->format('d') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Time Slots Grid -->
                            <div class="row g-2">
                                @foreach ($days as $day)
                                    <div class="col">
                                        <div class="border rounded-3 h-100 p-2">
                                            @php
                                                $dayKey = $day->format('Y-m-d');
                                                $daySlots = $slots[$dayKey] ?? collect();
                                            @endphp

                                            @if ($daySlots->count() > 0)
                                                @foreach ($daySlots as $slot)
                                                    <div class="mb-2">
                                                        <div
                                                            class="p-2 rounded-3 border position-relative 
                                                    {{ $slot->is_booked ? 'bg-danger bg-opacity-5 border-danger border-opacity-10' : 'bg-success bg-opacity-5 border-success border-opacity-10' }}">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-medium small">
                                                                    {{ $slot->start_time->format('h:i A') }} -
                                                                    {{ $slot->end_time->format('h:i A') }}
                                                                </span>
                                                                @if ($slot->isEditable())
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-sm p-0 text-muted"
                                                                            type="button" data-bs-toggle="dropdown">
                                                                            <i class="fas fa-ellipsis-v"></i>
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
                                                                                        onclick="return confirm('Are you sure you want to delete this slot?')">
                                                                                        <i
                                                                                            class="far fa-trash-alt me-2"></i>
                                                                                        Delete
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span
                                                                    class="badge bg-{{ $slot->is_booked ? 'danger' : 'success' }}-subtle text-{{ $slot->is_booked ? 'danger' : 'success' }} rounded-pill small">
                                                                    {{ $slot->is_booked ? 'Booked' : 'Available' }}
                                                                </span>
                                                                <span class="text-muted small">{{ $slot->duration }}
                                                                    min</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="far fa-calendar-plus text-muted mb-2"></i>
                                                    <p class="small text-muted mb-0">No slots</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-calendar-times text-muted opacity-25" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="fw-semibold text-muted mb-3">No Schedule Found</h5>
                            <p class="text-muted mb-4">You haven't created any schedule for this week yet.</p>
                            <a href="{{ route('doctor.slots.setup') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-plus me-1"></i> Create New Schedule
                            </a>
                        </div>
                    @endif
                </div>

                @if ($currentSchedule && $slots->count() > 0)
                    <!-- Card Footer -->
                    <div class="card-footer bg-white py-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i> Showing {{ $slots->count() }} slots
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill me-2">
                                    <i class="fas fa-circle small me-1"></i> Available
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                    <i class="fas fa-circle small me-1"></i> Booked
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border: none;
            box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            border: none;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .slot-card {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .slot-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
        }

        .badge.bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .badge.bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Add any interactive JavaScript here if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Highlight today's date
            const today = new Date().toISOString().split('T')[0];
            document.querySelectorAll('.day-header').forEach(header => {
                if (header.dataset.date === today) {
                    header.classList.add('bg-primary', 'text-white');
                }
            });
        });
    </script>
@endpush
