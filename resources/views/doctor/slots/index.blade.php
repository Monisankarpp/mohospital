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
                                        <button type="button"
                                            class="btn btn-link text-decoration-none fw-semibold view-day-slots {{ $day === strtolower(now()->format('l')) ? 'text-primary' : '' }}"
                                            data-day="{{ $day }}">
                                            {{ ucfirst($day) }}
                                        </button>

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
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <form action="{{ route('doctor.slots.unavailable-day') }}" method="POST"
                                                class="mark-unavailable-form" data-day="{{ $day }}">
                                                @csrf
                                                <input type="hidden" name="day" value="{{ $day }}">
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger rounded-pill mark-unavailable-btn"
                                                    data-day="{{ $day }}"
                                                    {{ !$schedule || !$schedule->is_working ? 'disabled' : '' }}>
                                                    <i class="fas fa-ban me-1"></i> Mark Unavailable
                                                </button>

                                            </form>
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

    <script>
        document.querySelectorAll('.mark-unavailable-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const day = this.dataset.day;
                Swal.fire({
                    title: `Mark ${day.charAt(0).toUpperCase() + day.slice(1)} as Unavailable?`,
                    text: "All slots will be deleted and patients notified.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, mark unavailable!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });


        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('.mark-unavailable-form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const day = this.dataset.day;
                    const row = this.closest('tr');

                    // Disable the button
                    const button = this.querySelector('button');
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-check-circle me-1"></i> Unavailable';

                    // Change status badge to "Off"
                    const statusCell = row.children[1];
                    statusCell.innerHTML = `
                <span class="badge rounded-pill py-2 px-3 bg-secondary-subtle text-secondary">
                    Off
                </span>
            `;

                    // Replace time cells with "-"
                    for (let i = 2; i <= 4; i++) {
                        row.children[i].innerHTML = `<span class="text-muted">-</span>`;
                    }

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.querySelector('input[name="_token"]')
                                .value,
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(new FormData(this))
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const slotsByDay = @json($slotsByDay);

            document.querySelectorAll('.view-day-slots').forEach(button => {
                button.addEventListener('click', function() {
                    const day = this.dataset.day;
                    const slots = slotsByDay[day] || [];



                    if (slots.length === 0) {
                        Swal.fire({
                            title: 'No Slots',
                            text: 'No slots found for ' + capitalize(day),
                            icon: 'info',
                            background: 'rgba(248, 249, 250, 0.95)',
                            backdrop: 'rgba(0, 0, 0, 0.15)'
                        });
                        return;
                    }

                    // Build responsive slot cards (3 per row)
                    const slotCards = slots.map(slot => {
                        const start = new Date(slot.start_time).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        const end = new Date(slot.end_time).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        const isBooked = slot.appointment && slot.appointment.user;
                        const isBreak = slot.status === 'break';

                        return `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden bg-gradient bg-opacity-10 ${isBooked ? 'bg-danger bg-opacity-10' : isBreak ? 'bg-warning bg-opacity-10' : 'bg-success bg-opacity-10'}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-title mb-0 text-dark fw-semibold">${start} - ${end}</h6>
                                    <span class="badge rounded-pill ${isBooked ? 'bg-danger' : isBreak ? 'bg-warning' : 'bg-success'}">${isBooked ? 'Booked' : isBreak ? 'Break' : 'Available'}</span>
                                </div>
                                ${isBooked
                                    ? `<button class="btn btn-sm btn-outline-primary w-100 view-patient-btn mt-2"
                                                                                                                                                                                        data-name="${slot.appointment.user.name || 'N/A'}"
                                                                                                                                                                                        data-email="${slot.appointment.user.email || 'N/A'}"
                                                                                                                                                                                        data-phone="${slot.appointment.user.phone || 'N/A'}">
                                                                                                                                                                                        <i class="bi bi-person-circle me-1"></i> View Patient
                                                                                                                                                                                    </button>`
                                    : isBreak
                                    ? `<button class="btn btn-sm btn-warning w-100 mt-2" disabled>
                                                                                                                                                                                        <i class="bi bi-pause me-1"></i> Break Taken
                                                                                                                                                                                    </button>`
                                    : `<button class="btn btn-sm btn-primary w-100 mt-2 take-break-btn"
                                                                                                                                                                                data-slot-id="${slot.id}">
                                                                                                                                                                                    <i class="bi bi-pause me-1"></i> Let's Take a Break
                                                                                                                                                                                </button>`
                                }
                            </div>
                        </div>
                    </div>`;
                    }).join('');

                    // Wrap in Bootstrap row
                    const htmlContent = `<div class="row g-3">${slotCards}</div>`;

                    Swal.fire({
                        title: `<span class="text-dark">Slots for ${capitalize(day)}</span>`,
                        html: htmlContent,
                        width: 900,
                        showConfirmButton: false,
                        showCloseButton: true,
                        background: 'rgba(248, 249, 250, 0.98)',
                        backdrop: 'rgba(0, 0, 0, 0.1)',
                        didRender: () => {
                            // Use event delegation for dynamic buttons
                            document.querySelectorAll('.view-patient-btn').forEach(
                                btn => {
                                    btn.addEventListener('click', function() {
                                        Swal.fire({
                                            title: '<span class="text-dark">Patient Details</span>',
                                            html: `
                                    <div class="text-start">
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Name</h6>
                                            <p class="text-dark fw-semibold mb-0">${this.dataset.name}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Email</h6>
                                            <p class="text-dark fw-semibold mb-0">${this.dataset.email}</p>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Phone</h6>
                                            <p class="text-dark fw-semibold mb-0">${this.dataset.phone}</p>
                                        </div>
                                    </div>`,
                                            icon: 'info',
                                            background: 'rgba(248, 249, 250, 0.98)',
                                            confirmButtonColor: '#0d6efd',
                                            backdrop: 'rgba(0, 0, 0, 0.1)'
                                        });
                                    });
                                });

                            // Handle Take Break button click
                            document.querySelectorAll('.take-break-btn').forEach(
                                btn => {
                                    btn.addEventListener('click', function() {
                                        const slotId = this.dataset.slotId;
                                        console.log('slotsByDay:',
                                            slotId);


                                        markSlotAsBreak(slotId);

                                        this.innerHTML =
                                            `<i class="bi bi-pause me-1"></i> Break Taken`;
                                        this.disabled =
                                            true;
                                        this.classList.remove(
                                            'btn-primary');
                                        this.classList.add('btn-warning');

                                        const cardBody = this.closest(
                                            '.card-body');
                                        const badge = cardBody
                                            .querySelector('.badge');

                                        if (badge && badge.textContent
                                            .trim() === 'Available') {
                                            badge.textContent = 'Break';
                                            badge.classList.remove(
                                                'bg-success');
                                            badge.classList.add(
                                                'bg-warning');
                                        }
                                    });
                                });
                        }
                    });
                });
            });

            function capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function markSlotAsBreak(slotId) {
                fetch(`/doctor/update-slot/${slotId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        status: 'break'
                    })
                }).then(response => {
                    if (response.ok) {
                        console.log(`Slot ${slotId} marked as break`);
                    } else {
                        console.error('Failed to update slot status');
                    }
                });
            }
        });
    </script>
@endsection
