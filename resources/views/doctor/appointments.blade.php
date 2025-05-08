@extends('layouts.base')

@section('title', 'My Appointments')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5"> <!-- Page Header -->
        <div
            class="p-4 rounded-4 bg-light shadow-sm border-start border-4 border-primary d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 mt-4">
            <div class="mb-3 mb-md-0">
                <h2 class="h4 fw-bold text-primary mb-3 d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-3 text-primary fs-4"></i>
                    My Appointments
                </h2>
                <p class="text-muted mb-0">View and manage your upcoming patient appointments with ease</p>
            </div>

            <div class="text-md-end">
                <div class="text-muted small">Last Login</div>
                <div class="fw-semibold text-dark">{{ now()->format('M j, Y h:i A') }}</div>
            </div>
        </div>


        @if ($appointments->count())
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-list-ul me-2 text-primary"></i> Appointment List
                        </h5>
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchInput"
                                placeholder="Search appointments...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="appointmentsTable">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr class="fw-semibold">
                                <th class="ps-4 py-3">Patient</th>
                                <th class="py-3">Date & Time</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Type</th>
                                <th class="pe-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="appointment-row" data-patient="{{ strtolower($appointment->patient->name) }}"
                                    data-date="{{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('Y-m-d') }}">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 42px; height: 42px; background-color: #e3f2fd; color: #3498db;">
                                                {{ substr($appointment->patient->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $appointment->patient->name }}</div>
                                                <small class="text-muted">{{ $appointment->patient->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-medium text-dark">
                                            {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('M j, Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3 py-2 text-capitalize"
                                            style="{{ $appointment->status == 'completed'
                                                ? 'background-color: #e8f5e9; color: #2e7d32;'
                                                : ($appointment->status == 'rescheduled'
                                                    ? 'background-color: #ffebee; color: #c62828;'
                                                    : ($appointment->status == 'accepted'
                                                        ? 'background-color: #fff8e1; color: #f57f17;'
                                                        : 'background-color: #eceff1; color: #546e7a;')) }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-capitalize">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">
                                            {{ $appointment->type ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm btn-outline-secondary rounded-pill px-3 dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item view-details"
                                                        data-patient="{{ $appointment->patient->name }}"
                                                        data-email="{{ $appointment->patient->email }}"
                                                        data-date="{{ $appointment->slot->start_time }}"
                                                        data-status="{{ $appointment->status }}"
                                                        data-type="{{ $appointment->type ?? 'General' }}">
                                                        <i class="fas fa-eye me-2 text-muted"></i> View Details
                                                    </a>
                                                </li>
                                                @if ($appointment->status != 'completed' && \Carbon\Carbon::parse($appointment->slot->start_time)->isFuture())
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item reschedule-btn"
                                                            data-id="{{ $appointment->id }}"
                                                            data-date="{{ $appointment->slot->start_time }}">
                                                            <i class="fas fa-edit me-2 text-muted"></i> Reschedule
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="card-footer bg-white border-top-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing <strong>{{ $appointments->firstItem() }}</strong> to
                        <strong>{{ $appointments->lastItem() }}</strong> of
                        <strong>{{ $appointments->total() }}</strong> appointments
                    </div>
                    <div>
                        {{ $appointments->appends(request()->except('upcoming_page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @else
            <!-- No Appointments State -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-times fa-3x text-muted"></i>
                </div>
                <h5 class="fw-semibold text-dark mb-2">No Appointments Found</h5>
                <p class="text-muted mb-4">You don't have any upcoming appointments scheduled.</p>
            </div>
        @endif


        @if ($completedAppointments->count())
            <div class="card border-0 shadow-sm rounded-4 mt-5">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-check-circle me-2 text-success"></i> Completed Appointments
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr class="fw-semibold">
                                <th class="ps-4 py-3">Patient</th>
                                <th class="py-3">Date & Time</th>
                                <th class="py-3">Type</th>
                                <th class="pe-4 py-3 text-end">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($completedAppointments as $appointment)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 42px; height: 42px; background-color: #e8f5e9; color: #2e7d32;">
                                                {{ substr($appointment->patient->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $appointment->patient->name }}</div>
                                                <small class="text-muted">{{ $appointment->patient->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-medium text-dark">
                                            {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('M j, Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td class="py-3 text-capitalize">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                                            {{ $appointment->type ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <button class="btn btn-sm btn-outline-success rounded-pill view-details"
                                            data-patient="{{ $appointment->patient->name }}"
                                            data-email="{{ $appointment->patient->email }}"
                                            data-date="{{ $appointment->slot->start_time }}"
                                            data-status="{{ $appointment->status }}"
                                            data-type="{{ $appointment->type ?? 'General' }}">
                                            <i class="fas fa-eye me-1"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white border-top-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing <strong>{{ $completedAppointments->firstItem() }}</strong> to
                        <strong>{{ $completedAppointments->lastItem() }}</strong> of
                        <strong>{{ $completedAppointments->total() }}</strong> completed
                    </div>
                    <div>
                        {{ $completedAppointments->appends(request()->except('completed_page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 mt-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle fa-3x text-muted"></i>
                </div>
                <h5 class="fw-semibold text-dark mb-2">No Completed Appointments</h5>
                <p class="text-muted mb-0">You haven't completed any appointments yet.</p>
            </div>
        @endif


    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // View Details
        document.querySelectorAll('.view-details').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Appointment Details',
                    html: `
                    <div class="text-start">
                        <p><strong>Patient:</strong> ${btn.dataset.patient}</p>
                        <p><strong>Email:</strong> ${btn.dataset.email}</p>
                        <p><strong>Date & Time:</strong> ${new Date(btn.dataset.date).toLocaleString()}</p>
                        <p><strong>Status:</strong> ${btn.dataset.status}</p>
                        <p><strong>Type:</strong> ${btn.dataset.type}</p>
                    </div>
                `,
                    icon: 'info',
                    confirmButtonText: 'Close',
                    customClass: {
                        confirmButton: 'btn btn-primary rounded-pill px-4'
                    },
                    buttonsStyling: false
                });
            });
        });

        // Reschedule
        document.querySelectorAll('.reschedule-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const rawDatetime = btn.dataset.date;
                const [date, time] = rawDatetime.split(' ');
                const formattedDate = new Date(date).toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                const formattedTime = new Date(`1970-01-01T${time}`).toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
            <label class="mb-2">Select new date & time:</label>
            <select id="availableSlots" class="form-control">
                <option value="">Loading...</option>
            </select>
        `;

                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Reschedule Appointment',
                    html: wrapper,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Reschedule',
                    customClass: {
                        confirmButton: 'btn btn-success rounded-pill px-4 me-2',
                        cancelButton: 'btn btn-secondary rounded-pill px-4'
                    },
                    didOpen: async () => {
                        // Fetch available slots for the doctor
                        const response = await fetch(
                            `/doctor/appointments/${btn.dataset.id}/available-slots`);
                        const data = await response.json();

                        if (data.success) {
                            const slotsDropdown = document.getElementById('availableSlots');
                            slotsDropdown.innerHTML = '';
                            data.slots.forEach(slot => {
                                const option = document.createElement('option');
                                option.value = slot.id;
                                option.textContent = `${slot.date} - ${slot.time}`;
                                slotsDropdown.appendChild(option);
                            });
                        } else {
                            Swal.fire('Error', 'Unable to fetch available slots', 'error');
                        }
                    },
                    preConfirm: () => {
                        const selectedSlot = document.getElementById('availableSlots')
                            .value;
                        if (!selectedSlot) {
                            Swal.showValidationMessage('Please select a valid slot');
                        }
                        return selectedSlot;
                    }
                });

                const selectedSlot = document.getElementById('availableSlots')?.value;

                if (isConfirmed && selectedSlot) {
                    try {
                        const response = await fetch(
                            `/doctor/appointments/${btn.dataset.id}/reschedule`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    slot_id: selectedSlot
                                })
                            });

                        const data = await response.json();
                        if (data.success) {
                            Swal.fire('Rescheduled!', 'Appointment updated successfully.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Unable to communicate with the server.', 'error');
                    }
                }
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('.appointment-row');

            rows.forEach(row => {
                const patientName = row.getAttribute('data-patient');
                const appointmentDate = row.getAttribute('data-date');

                if (patientName.includes(query) || appointmentDate.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
