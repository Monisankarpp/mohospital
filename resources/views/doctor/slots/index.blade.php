@extends('layouts.doctor-dashboard')

@section('title', 'My Slots')

@section('content')
    <div class="container-fluid py-4" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">

            <!-- Header with Action -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 fw-bold text-primary mb-1">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i> My Appointment Slots
                    </h2>
                    <p class="text-muted mb-0">Manage your availability for patients</p>
                </div>
                <a href="{{ route('doctor.slots.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus me-2"></i> New Slot
                </a>
            </div>

            <!-- Slots Table -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="mb-0 fw-semibold text-primary">
                        <i class="fas fa-list-ul me-2 text-secondary"></i> Current Availability
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase small">
                                <tr>
                                    <th class="ps-4 fw-semibold text-primary">Date</th>
                                    <th class="fw-semibold text-primary">Time</th>
                                    <th class="fw-semibold text-primary">Duration</th>
                                    <th class="fw-semibold text-primary">Specialization</th>
                                    <th class="fw-semibold text-primary">Status</th>
                                    <th class="pe-4 text-end fw-semibold text-primary">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($slots as $slot)
                                    <tr class="border-bottom border-light">
                                        <td class="ps-4">
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-semibold text-dark">{{ $slot->start_time->format('D, M d') }}</span>
                                                <small class="text-muted">{{ $slot->start_time->format('Y') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark">{{ $slot->start_time->format('h:i A') }}</span>
                                                <span class="text-muted small">to
                                                    {{ $slot->end_time->format('h:i A') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                                                {{ $slot->start_time->diffInMinutes($slot->end_time) }} mins
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-flex align-items-center text-primary">
                                                <i class="fas fa-stethoscope me-2 text-info"></i>
                                                {{ $slot->doctor->specialization ?? 'General' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($slot->is_booked)
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                                    <i class="fas fa-user-clock me-1"></i> Booked
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                                    <i class="fas fa-calendar-check me-1"></i> Available
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('doctor.slots.edit', $slot->id) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-circle p-2"
                                                    data-bs-toggle="tooltip" title="Edit Slot">
                                                    <i class="far fa-edit fa-sm"></i>
                                                </a>
                                                <form action="{{ route('doctor.slots.destroy', $slot->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('This will permanently delete the slot. Continue?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                                        data-bs-toggle="tooltip" title="Delete Slot">
                                                        <i class="far fa-trash-alt fa-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 bg-light">
                                            <div class="py-4">
                                                <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No slots available</h5>
                                                <p class="text-muted small">Add your first availability slot to start
                                                    accepting appointments</p>
                                                <a href="{{ route('doctor.slots.create') }}"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-2">
                                                    <i class="fas fa-plus me-1"></i> Create Slot
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if ($slots->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Page navigation">
                        {{ $slots->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            @endif

        </div>
    </div>
@endsection
