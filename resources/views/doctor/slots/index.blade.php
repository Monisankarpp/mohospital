@extends('layouts.doctor-dashboard')

@section('title', 'My Slots')

@section('content')
    <div class="container-fluid py-4" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="container">

            <!-- Header with Action -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 fw-bold text-primary mb-1">
                        <i class="far fa-calendar-check me-2 text-primary"></i> My Available Slots
                    </h2>
                    <p class="text-muted">Easily manage your appointment availability</p>
                </div>
                <a href="{{ route('doctor.slots.create') }}"
                    class="btn btn-info text-white rounded-pill px-4 shadow-sm bg-primary">
                    <i class="fas fa-plus me-2"></i> Add Slot
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Slots Table -->
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-header bg-light border-bottom py-3 px-4">
                    <h5 class="mb-0 text-primary fw-semibold">
                        <i class="far fa-clock me-2 text-secondary"></i> Upcoming Slots
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <thead class="bg-body-secondary text-uppercase small text-muted">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($slots as $slot)
                                    <tr class="align-middle border-bottom">
                                        <td class="ps-4">
                                            <span
                                                class="fw-semibold text-dark">{{ $slot->start_time->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="far fa-clock me-1 text-primary"></i>
                                                {{ $slot->start_time->format('h:i A') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="far fa-clock me-1 text-primary"></i>
                                                {{ $slot->end_time->format('h:i A') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-stethoscope me-2 text-info"></i>
                                                {{ $slot->doctorDepartment->department->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($slot->is_booked)
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                                    <i class="fas fa-lock me-1"></i> Booked
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                                    <i class="fas fa-unlock me-1"></i> Available
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('doctor.slots.edit', $slot->id) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                    data-bs-toggle="tooltip" title="Edit Slot">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('doctor.slots.destroy', $slot->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure to delete this slot?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        data-bs-toggle="tooltip" title="Delete Slot">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-info-circle me-2 text-muted"></i>
                                            No slots added yet. Click "Add Slot" to get started.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $slots->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltips.map(function(tooltipEl) {
                return new bootstrap.Tooltip(tooltipEl)
            })
        })
    </script>
@endsection
