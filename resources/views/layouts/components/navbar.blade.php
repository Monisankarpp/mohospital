@php
    $user = auth()->user();
    $avatarUrl = 'https://api.dicebear.com/8.x/thumbs/svg?seed=' . urlencode($user->name);
@endphp
<!-- Dark Theme Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm border-bottom border-secondary"
    style="background: linear-gradient(180deg, #2c3e50 0%, #1a1a2e 100%">
    <div class="container-fluid">

        <!-- Sidebar Toggle (Mobile) -->
        <button class="btn btn-outline-light d-lg-none me-2" id="toggleSidebarMobile">
            <i class="bi bi-list"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('patient.dashboard') }}">
            <span class="text-primary">Mo</span><span class="text-light">Hospital</span>
        </a>

        <!-- Search -->
        <form class="d-none d-md-flex ms-auto me-4 w-50">
            <div class="input-group">
                <span class="input-group-text border-end-0 text-secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" class="form-control border-start-0 text-dark" placeholder="Search...">
            </div>
        </form>

        <!-- Right Side -->
        <ul class="navbar-nav ms-auto align-items-center">

            <!-- Notification Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link position-relative d-flex align-items-center" href="#" id="notificationDropdown"
                    data-bs-toggle="dropdown" style="transition: all 0.3s ease;">
                    <div class="position-relative">
                        <i class="fa-solid fa-bell text-light fs-4" style="transition: color 0.3s ease;"></i>

                        <!-- Notification Badge -->
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm"
                            style="font-size: 0.5rem; width: 10px; height: 10px; padding: 0;">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div>
                </a>
                {{-- notification start --}}
                <ul class="dropdown-menu dropdown-menu-end shadow p-0 overflow-hidden"
                    style="width: 350px; border: none; border-radius: 12px;" aria-labelledby="notificationDropdown">

                    <!-- Header with gradient background -->
                    <li class="py-2 px-3 text-white"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-bell-fill me-2"></i>Notifications</h6>
                            <span class="badge bg-white text-primary rounded-pill">
                                {{ auth()->user()->notifications()->count() }} New
                            </span>
                        </div>
                    </li>

                    <!-- Notification items container with scroll -->
                    <div style="max-height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                        @forelse(auth()->user()->notifications()->latest()->take(2)->get() as $notification)
                            <li class="border-bottom border-light">
                                <a href="javascript:void(0);"
                                    class="dropdown-item d-flex py-3 px-3 position-relative notification-item"
                                    data-id="{{ $notification->id }}" data-title="{{ $notification->title }}"
                                    data-message="{{ $notification->message }}">
                                    <!-- Colored icon badge based on notification type -->
                                    <div class="flex-shrink-0 me-3">
                                        <div class="notification-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background: {{ $notification->type === 'alert' ? '#ff6b6b' : '#48dbfb' }}; width: 40px; height: 40px;">
                                            <i
                                                class="bi {{ $notification->type === 'alert' ? 'bi-exclamation-triangle' : 'bi-info-circle' }} text-white"></i>
                                        </div>
                                    </div>

                                    <!-- Notification content -->
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1 fw-semibold text-dark">{{ $notification->title }}</h6>
                                            <small
                                                class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 small text-muted">
                                            {{ Str::limit($notification->message ?? '', 60) }}</p>
                                    </div>
                                    <!-- Unread indicator -->
                                    @if (!$notification->read_at)
                                        <span
                                            class="position-absolute top-50 start-0 translate-middle-y bg-danger rounded-circle"
                                            style="width: 8px; height: 8px;"></span>
                                    @endif
                                </a>
                            </li>
                        @empty
                            <!-- Empty state -->
                            <li class="text-center py-4">
                                <div class="py-3">
                                    <i class="bi bi-bell-slash text-muted" style="font-size: 2.5rem;"></i>
                                    <h6 class="mt-2 text-muted">No notifications yet</h6>
                                    <p class="small text-muted mb-0">We'll notify you when something arrives</p>
                                </div>
                            </li>
                        @endforelse

                    </div>

                    <!-- Footer with view all button -->
                    <li class="bg-white pt-2 pb-2 border-top">
                        <a href="#" class="dropdown-item text-center fw-semibold text-primary">
                            <i class="bi bi-arrow-right-circle-fill me-2"></i>View all notifications
                            <i class="bi bi-chevron-right ms-1 small"></i>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Modal for displaying full message -->
            <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6 id="notificationTitle"></h6>
                            <p id="notificationMessage"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <li class="nav-item dropdown ms-3">
                <a class="nav-link dropdown-toggle d-flex align-items-center position-relative" href="#"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="position-relative">
                        <div class="rounded-circle overflow-hidden shadow-sm"
                            style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                            <img src="{{ $avatarUrl }}" alt="avatar"
                                class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                        <span
                            class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white"
                            style="width: 10px; height: 10px;"></span>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-0 overflow-hidden"
                    style="width: 280px; border: none; border-radius: 12px;" aria-labelledby="userDropdown">

                    <!-- Header with gradient background -->
                    <li class="px-4 py-3 text-white"
                        style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle overflow-hidden shadow-sm"
                                style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                                <img src="{{ $avatarUrl }}" alt="avatar"
                                    class="img-fluid w-100 h-100 object-fit-cover">
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-truncate">{{ auth()->user()->name }}</h6>
                                <small class="opacity-75 text-truncate d-block">{{ auth()->user()->email }}</small>
                                <span
                                    class="badge bg-white text-primary mt-1">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                        </div>
                    </li>

                    <!-- Menu items -->
                    <div class="py-2" style="background-color: #f8f9fa;">
                        <li>
                            <a href="{{ auth()->user()->role == 'patient' ? route('patient.profile') : route('doctor.profile') }}"
                                class="dropdown-item d-flex align-items-center py-2 px-4 menu-item">
                                <div class="icon-wrapper me-3"
                                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="fa-solid fa-user text-white"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-medium">My Profile</span>
                                    <small class="text-muted">View & edit profile</small>
                                </div>
                                <i class="bi bi-chevron-right ms-auto text-muted"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="dropdown-item d-flex align-items-center py-2 px-4 menu-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="icon-wrapper me-3"
                                    style="background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%);">
                                    <i class="fa-solid fa-right-from-bracket text-white"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-medium">Sign Out</span>
                                    <small class="text-muted">End current session</small>
                                </div>
                                <i class="bi bi-chevron-right ms-auto text-muted"></i>
                            </a>
                        </li>
                    </div>

                    <!-- Footer -->
                    <li class="bg-light px-4 py-2 border-top">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Last login: {{ now()->format('M j, Y') }}</span>
                        </div>
                    </li>
                </ul>
            </li>

            {{-- end --}}
        </ul>
    </div>
</nav>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<script>
    $(document).ready(function() {
        // When a notification is clicked
        $('.notification-item').on('click', function() {
            // Get the notification data
            var notificationId = $(this).data('id');
            var notificationTitle = $(this).data('title');
            var notificationMessage = $(this).data('message');

            // Set modal content
            $('#notificationModalLabel').text(notificationTitle);
            $('#notificationTitle').text(notificationTitle);
            $('#notificationMessage').text(notificationMessage);

            // Open the modal
            $('#notificationModal').modal('show');

            // Mark the notification as read after the modal is closed
            $('#notificationModal').on('hidden.bs.modal', function() {
                $.ajax({
                    url: '/notifications/' + notificationId +
                        '/read', // Adjust the URL according to your routes
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Optionally update the notification badge or status
                        // Example: Remove the unread indicator from the notification item
                        $('li[data-id="' + notificationId + '"] .position-absolute')
                            .remove();
                    },
                    error: function(error) {
                        console.log('Error marking notification as read:', error);
                    }
                });
            });
        });
    });
</script>
