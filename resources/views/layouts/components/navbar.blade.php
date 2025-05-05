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

        <!-- Right Side -->
        <ul class="navbar-nav ms-auto align-items-center">

            <!-- Notification Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link position-relative d-flex align-items-center" href="#" id="notificationDropdown"
                    data-bs-toggle="dropdown" style="transition: all 0.3s ease;">
                    <div class="position-relative">
                        <i id="bellIcon" class="fa-solid fa-bell text-light fs-4"
                            style="transition: transform 0.3s ease, color 0.3s ease;"></i>

                        <!-- Notification Badge -->
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm"
                            style="font-size: 0.5rem; width: 10px; height: 10px; padding: 0; animation: pulse 1s infinite;">
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
                                    <div class="flex-shrink-0 me-3">
                                        <div class="notification-icon d-flex align-items-center justify-content-center rounded-circle shadow-sm"
                                            style="
                                                width: 42px; 
                                                height: 42px; 
                                                background: {{ $notification->is_read ? '#e0e0e0' : '#0d6efd' }};">
                                            <i
                                                class="bi {{ $notification->is_read ? 'bi-check-circle' : 'bi-bell-fill' }} text-white fs-5"></i>
                                        </div>
                                    </div>


                                    <!-- Notification content -->
                                    <div class="flex-grow-1">
                                        <div>
                                            <h6
                                                class="{{ $notification->is_read ? 'fw-normal text-secondary' : 'fw-bold text-dark' }} mb-1">
                                                {{ $notification->title }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>

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
                        <a href="javascript:void(0);" id="viewAllNotifications"
                            class="dropdown-item text-center fw-semibold text-primary">
                            <i class="bi bi-arrow-right-circle-fill me-2"></i>View all notifications
                            <i class="bi bi-chevron-right ms-1 small"></i>
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Notification Sound -->
            <audio id="notificationSound" preload="auto">
                <source src="{{ asset('sounds/notify.mp3') }}" type="audio/mpeg">
            </audio>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.notification-item', function() {
            const notificationId = $(this).data('id');
            const notificationTitle = $(this).data('title');
            const notificationMessage = $(this).data('message');

            // Show SweetAlert
            Swal.fire({
                title: notificationTitle,
                html: `<p class="text-start">${notificationMessage}</p>`,
                icon: 'info',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-primary rounded-pill px-4'
                },
                buttonsStyling: false
            });

            // Mark as read via AJAX
            $.ajax({
                url: `/notifications/${notificationId}/read`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    const item = $(`a[data-id="${notificationId}"]`);
                    // Remove red dot
                    item.find('.position-absolute.bg-danger').remove();
                    // Update font style
                    item.find('h6').removeClass('fw-bold text-dark').addClass(
                        'fw-normal text-secondary');
                },
                error: function() {
                    console.error('Error marking notification as read');
                }
            });
        });
    });



    document.addEventListener("DOMContentLoaded", function() {
        const bellIcon = document.getElementById("bellIcon");
        const notificationSound = document.getElementById("notificationSound");
        const unreadCount = {{ auth()->user()->notifications()->where('is_read', false)->count() }};

        // Helper: Simulate shake
        const shakeBell = () => {
            let i = 0;
            const shakeDuration = 10;
            const interval = setInterval(() => {
                bellIcon.style.transform = (i % 2 === 0) ? "rotate(-40deg)" : "rotate(40deg)";
                i++;
                if (i >= shakeDuration) {
                    clearInterval(interval);
                    bellIcon.style.transform = "rotate(0)";
                }
            }, 100);
        };


        const tryPlaySound = () => {
            if (notificationSound) {
                const playPromise = notificationSound.play();
                if (playPromise !== undefined) {
                    playPromise
                        .then(() => {
                            localStorage.setItem("soundAllowed", "true");
                        })
                        .catch(error => {
                            console.warn("Autoplay prevented. Waiting for user interaction.");
                            document.body.addEventListener("click", () => {
                                notificationSound.play().then(() => {
                                    localStorage.setItem("soundAllowed", "true");
                                }).catch(() => {});
                            }, {
                                once: true
                            });
                        });
                }
            }
        };

        if (unreadCount > 0) {
            shakeBell();
            setInterval(shakeBell, 5000);

            // Play sound only once
            tryPlaySound();
        }
    });



    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('viewAllNotifications').addEventListener('click', function() {
            fetch("{{ route('notifications.all') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Notifications',
                            text: 'You have no notifications yet.',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }

                    let html = data.map(notif => `
                        <div class="notification-item shadow-sm mb-3 p-3 rounded" 
                            style="background: #f8f9fa; border-left: 5px solid ${notif.type === 'alert' ? '#dc3545' : '#0d6efd'};">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 ${notif.is_read ? 'fw-normal text-dark' : 'fw-bold text-dark'}">${notif.title}</h6>
                                    <p class="text-muted mb-1 small">${notif.message}</p>
                                    <small class="text-secondary">${notif.time}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-primary ms-3 view-notif" 
                                        data-id="${notif.id}">
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </div>
                        </div>
                    `).join('');

                    Swal.fire({
                        title: '<strong class="text-primary">All Notifications</strong>',
                        html: `<div style="max-height: 400px; overflow-y: auto;" id="notifList">${html}</div>`,
                        width: 650,
                        background: '#ffffff',
                        showCloseButton: true,
                        showConfirmButton: false,
                        scrollbarPadding: false,
                        customClass: {
                            popup: 'rounded-4 text-start'
                        },
                        didOpen: () => {
                            document.querySelectorAll('.view-notif').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const notifId = this.getAttribute(
                                        'data-id');
                                    if (!notifId) return;

                                    fetch(`/notifications/${notifId}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.message) {
                                                Swal.fire({
                                                    icon: data
                                                        .type ===
                                                        'alert' ?
                                                        'warning' :
                                                        'info',
                                                    title: data
                                                        .title,
                                                    html: `
                                                    <div class="text-start">
                                                        <p class="mb-2">${data.message}</p>
                                                        <small class="text-muted">Received on ${data.created_at}</small>
                                                    </div>
                                                `,
                                                    confirmButtonColor: '#0d6efd',
                                                    width: 600,
                                                    customClass: {
                                                        popup: 'rounded-4'
                                                    }
                                                });

                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Notification not found',
                                                    text: data
                                                        .message,
                                                    confirmButtonColor: '#dc3545'
                                                });
                                            }
                                        });
                                });
                            });
                        }
                    });
                });
        });
    });
</script>
