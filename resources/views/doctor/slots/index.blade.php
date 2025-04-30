@extends('layouts.doctor-dashboard')

@section('title', 'Schedule Management')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <!-- Header Section -->
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="text-primary">Your Schedule & Slots</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('doctor.slots.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Create New Schedule
                </a>
                @if (auth()->user()->doctor->default_schedule)
                    <a href="{{ route('doctor.slots.apply-default') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-redo me-2"></i> Apply Default Schedule
                    </a>
                @endif
            </div>
        </div>

        <!-- Weekly Schedule Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i> Weekly Schedule
                    </h4>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-bold text-muted">Day</th>
                                <th class="text-uppercase small fw-bold text-muted">Status</th>
                                <th class="text-uppercase small fw-bold text-muted">Working Hours</th>
                                <th class="text-uppercase small fw-bold text-muted">Lunch Break</th>
                                <th class="text-uppercase small fw-bold text-muted">Slot Duration</th>
                                <th class="pe-4 text-end text-uppercase small fw-bold text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                @php
                                    $schedule = $schedules->firstWhere('day_of_week', $day);
                                @endphp
                                <tr class="border-top">
                                    <td class="ps-4 py-3 fw-semibold">
                                        <span class="{{ $day === strtolower(now()->format('l')) ? 'text-primary' : '' }}">
                                            {{ ucfirst($day) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge rounded-pill py-2 px-3 bg-{{ $schedule && $schedule->is_working ? 'success' : 'secondary' }}-subtle text-{{ $schedule && $schedule->is_working ? 'success' : 'secondary' }}">
                                            {{ $schedule && $schedule->is_working ? 'Working' : 'Off' }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if ($schedule && $schedule->is_working)
                                            <span class="text-muted">{{ $schedule->start_time->format('h:i A') }}</span>
                                            <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                            <span class="text-muted">{{ $schedule->end_time->format('h:i A') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if ($schedule && $schedule->is_working && $schedule->lunch_start)
                                            <span class="badge bg-info-subtle text-info rounded-pill py-2 px-3">
                                                <i class="fas fa-utensils me-1"></i>
                                                {{ $schedule->lunch_start->format('h:i A') }} -
                                                {{ $schedule->lunch_end->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if ($schedule && $schedule->is_working)
                                            <span class="badge bg-primary-subtle text-primary rounded-pill py-2 px-3">
                                                {{ $schedule->slot_duration }} mins
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="form-check form-switch d-inline-flex align-items-center gap-2">
                                            <input class="form-check-input styled-toggle day-toggle" type="checkbox"
                                                id="dayToggle-{{ $day }}"
                                                name="days[{{ $day }}][is_working]" value="1"
                                                {{ $schedule->is_working ? 'checked' : '' }}>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i> Current week view
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Slots Card -->
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-white border-bottom-0 px-4 py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <h4 class="fw-semibold mb-2 mb-md-0 text-primary">
                        <i class="fas fa-clock me-2"></i> Upcoming Slots
                    </h4>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge rounded-pill bg-success">Available</span>
                        <span class="badge rounded-pill bg-danger">Booked</span>
                        <span class="badge rounded-pill bg-warning text-dark">Past</span>
                        <span class="badge rounded-pill text-white" style="background-color: #6f42c1;">Break</span>
                    </div>
                </div>
            </div>

            <div class="card-body px-4 py-4">
                @if (count($slots) === 0)
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-secondary">No upcoming slots scheduled</h5>
                        <p class="text-muted">Create new slots to start accepting appointments</p>
                    </div>
                @else
                    @foreach ($slots as $date => $dateSlots)
                        <div class="mb-5">
                            <h5 class="border-bottom pb-2 mb-4 text-secondary">
                                <i class="fas fa-calendar-day me-2 text-info"></i>
                                {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                            </h5>

                            <div class="row g-4">
                                @foreach ($dateSlots as $slot)
                                    @php
                                        $now = now();
                                        $isPast = $slot->start_time->lt($now);
                                        $isToday = $slot->start_time->isToday();

                                        $cardClass = '';
                                        if ($slot->status === 'booked') {
                                            $cardClass = 'border-danger';
                                        } elseif ($slot->status === 'break') {
                                            $cardClass = 'border-0';
                                        } elseif ($isPast) {
                                            $cardClass = 'border-warning';
                                        } else {
                                            $cardClass = 'border-success';
                                        }
                                    @endphp

                                    <div class="col-md-3">
                                        <div
                                            class="card shadow-sm h-100 rounded-4 border {{ $cardClass }} {{ $isToday ? 'border-primary border-2' : '' }}">
                                            <div class="card-body d-flex flex-column p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0 fw-semibold">
                                                        <i class="far fa-clock me-1 text-muted"></i>
                                                        {{ $slot->start_time->format('h:i A') }} -
                                                        {{ $slot->end_time->format('h:i A') }}
                                                    </h6>
                                                    @if ($isToday)
                                                        <span class="badge bg-primary rounded-pill">Today</span>
                                                    @endif
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-3 mt-auto">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $slot->status === 'booked' ? 'danger' : ($slot->status === 'break' ? '' : ($isPast ? 'warning text-dark' : 'success')) }}"
                                                        style="{{ $slot->status === 'break' ? 'background-color: #6f42c1' : '' }}">
                                                        {{ ucfirst($slot->status) }}
                                                        @if ($slot->status === 'available' && $isPast)
                                                            (Past)
                                                        @endif
                                                    </span>
                                                    @if ($slot->appointment)
                                                        <span
                                                            class="badge bg-info text-white text-truncate rounded-pill px-2"
                                                            style="max-width: 100px;"
                                                            title="Patient: {{ $slot->appointment->patient->name }}">
                                                            {{ $slot->appointment->patient->name }}
                                                        </span>
                                                    @endif
                                                </div>

                                                @if ($slot->isEditable() && !$isPast && $slot->status !== 'break')
                                                    <div class="d-grid gap-2 d-md-flex mt-auto">
                                                        <a href="{{ route('doctor.slots.edit', $slot) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill flex-grow-1">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </a>
                                                        <form action="{{ route('doctor.slots.destroy', $slot) }}"
                                                            method="POST" class="flex-grow-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill w-100">
                                                                <i class="fas fa-trash me-1"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif($slot->status === 'break')
                                                    <small class="text-muted mt-2"><i class="fas fa-coffee me-1"></i>
                                                        Break
                                                        time - not editable</small>
                                                @elseif($isPast)
                                                    <small class="text-muted mt-2"><i class="fas fa-history me-1"></i>
                                                        Past
                                                        slot - not editable</small>
                                                @else
                                                    <small class="text-muted mt-2"><i class="fas fa-lock me-1"></i>
                                                        Editing disabled</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
@endsection
