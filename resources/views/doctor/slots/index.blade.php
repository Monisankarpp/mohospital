@extends('layouts.doctor-dashboard')

@section('title', 'Schedule Management')

@section('content')
    <div class="container-fluid ps-lg-5 pe-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">
            <div class="row justify-content-between mb-4">
                <div class="col-md-6">
                    <h2>Your Schedule & Slots</h2>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('doctor.slots.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Schedule
                    </a>
                    @if (auth()->user()->doctor->default_schedule)
                        <a href="{{ route('doctor.slots.apply-default') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Apply Default Schedule
                        </a>
                    @endif
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Weekly Schedule</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Working?</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Lunch Break</th>
                                <th>Slot Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                @php
                                    $schedule = $schedules->firstWhere('day_of_week', $day);
                                @endphp
                                <tr>
                                    <td>{{ ucfirst($day) }}</td>
                                    <td>{{ $schedule && $schedule->is_working ? 'Yes' : 'No' }}</td>
                                    <td>{{ $schedule && $schedule->is_working ? $schedule->start_time->format('h:i A') : '-' }}
                                    </td>
                                    <td>{{ $schedule && $schedule->is_working ? $schedule->end_time->format('h:i A') : '-' }}
                                    </td>
                                    <td>
                                        @if ($schedule && $schedule->is_working && $schedule->lunch_start)
                                            {{ $schedule->lunch_start->format('h:i A') }} -
                                            {{ $schedule->lunch_end->format('h:i A') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $schedule && $schedule->is_working ? $schedule->slot_duration . ' mins' : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Upcoming Slots</h4>
                </div>
                <div class="card-body">
                    @foreach ($slots as $date => $dateSlots)
                        <div class="mb-4">
                            <h5>{{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</h5>
                            <div class="row">
                                @foreach ($dateSlots as $slot)
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    {{ $slot->start_time->format('h:i A') }} -
                                                    {{ $slot->end_time->format('h:i A') }}
                                                </h6>
                                                <p class="card-text">
                                                    Status:
                                                    <span
                                                        class="badge bg-{{ $slot->status === 'booked' ? 'success' : ($slot->status === 'break' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($slot->status) }}
                                                    </span>
                                                </p>
                                                @if ($slot->isEditable())
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('doctor.slots.edit', $slot) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('doctor.slots.destroy', $slot) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <small class="text-muted">Editing disabled (less than 24h before
                                                        slot)</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
