@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">Available Slots</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Specialization</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($slots as $slot)
                    <tr>
                        <td>{{ $slot->doctor->name }}</td>
                        <td>{{ $slot->doctor->specialization }}</td>
                        <td>{{ $slot->start_time->format('Y-m-d') }}</td>
                        <td>{{ $slot->start_time->format('h:i A') }} - {{ $slot->end_time->format('h:i A') }}</td>
                        <td>
                            <button class="btn btn-outline-primary book-btn" data-bs-toggle="modal" data-bs-target="#bookModal"
                                data-doctor-id="{{ $slot->doctor->id }}" data-doctor-name="{{ $slot->doctor->name }}"
                                data-doctor-specialty="{{ $slot->doctor->specialization }}" data-slot-id="{{ $slot->id }}"
                                data-date="{{ $slot->start_time->format('Y-m-d') }}"
                                data-time="{{ $slot->start_time->format('H:i') }} - {{ $slot->end_time->format('H:i') }}">
                                Book Now
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="bookModalLabel">Book Appointment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" id="modalDoctorId">

                        <div class="text-center mb-4">
                            <h5 id="modalDoctorName" class="fw-bold"></h5>
                            <p class="text-muted" id="modalDoctorSpecialty"></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Date</label>
                            <input type="date" name="appointment_date" class="form-control" required readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Time Slot</label>
                            <select name="time_slot" class="form-select" required>
                                <option value="">Choose a time slot</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reason for Visit</label>
                            <textarea name="reason" class="form-control" rows="3"
                                placeholder="Briefly describe your symptoms or reason for visit"></textarea>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill py-2">
                                <i class="fas fa-calendar-check me-2"></i> Confirm Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingForm = document.getElementById('bookingForm');

            document.querySelectorAll('.book-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const doctorId = this.getAttribute('data-doctor-id');
                    const doctorName = this.getAttribute('data-doctor-name');
                    const doctorSpecialty = this.getAttribute('data-doctor-specialty');
                    const slotId = this.getAttribute('data-slot-id');
                    const date = this.getAttribute('data-date');
                    const time = this.getAttribute('data-time');

                    document.getElementById('modalDoctorId').value = doctorId;
                    document.getElementById('modalDoctorName').textContent = doctorName;
                    document.getElementById('modalDoctorSpecialty').textContent = doctorSpecialty;

                    bookingForm.action = `/appointments/book/${slotId}`;
                    document.querySelector('[name="appointment_date"]').value = date;
                    document.querySelector('[name="time_slot"]').innerHTML =
                        `<option value="${time}" selected>${time}</option>`;
                });
            });
        });
    </script>
@endsection
