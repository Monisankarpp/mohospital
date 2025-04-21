<aside id="sidebar" class="d-none d-lg-block position-fixed h-100 shadow"
    style="top: 80px; width: 280px; z-index: 1030; background: linear-gradient(180deg, #2c3e50 0%, #1a1a2e 100%);">

    <div class="d-flex flex-column h-100 pt-4 overflow-hidden">
        <!-- Sidebar Header -->
        <div class="px-4 mb-4 d-flex align-items-center">
            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                style="width: 36px; height: 36px;">
                <i class="fas fa-heartbeat text-primary fs-5"></i>
            </div>
            <h5 class="mb-0 text-white fw-bold">
                {{ auth()->user()->role == 'patient' ? 'Patient Portal' : 'Doctor Console' }}
            </h5>
        </div>

        <!-- Navigation Items -->
        <ul class="nav flex-column mb-auto px-3" style="overflow-y: auto; overflow-x: hidden;">
            @if (auth()->user()->role == 'patient')
                <li class="nav-item mb-2">
                    <a href="/"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('home') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-success bg-opacity-10 rounded-circle p-2">
                            <i class="fas fa-house-user text-success fs-5"></i>
                        </div>
                        <span class="fw-semibold">Home</span>
                        <span class="badge bg-info text-dark ms-2">New</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('patient.dashboard') }}"
                        class="nav-link rounded-start px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('patient.dashboard') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-info bg-opacity-10 rounded-2 p-2">
                            <i class="fas fa-tachometer-alt text-info fs-5"></i>
                        </div>
                        <span class="fw-semibold">Dashboard</span>
                        <i class="fas fa-angle-double-right ms-auto text-muted"></i>
                    </a>
                </li>


                <li class="nav-item mb-2">
                    <a href="{{ route('patient.appointments.book') }}"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('patient.appointments*') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-info bg-opacity-10">
                            <i class="fas fa-calendar-check text-info"></i>
                        </div>
                        <span class="fw-medium">Appointments</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('patient.prescriptions') }}"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('patient.prescriptions*') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-success bg-opacity-10">
                            <i class="fas fa-prescription-bottle-alt text-success"></i>
                        </div>
                        <span class="fw-medium">Prescriptions</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('patient.payments') }}"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('patient.payments*') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-warning bg-opacity-10">
                            <i class="fas fa-money-bill-wave text-warning"></i>
                        </div>
                        <span class="fw-medium">Payments</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'doctor')
                <li class="nav-item mb-2">
                    <a href="{{ route('doctor.dashboard') }}"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('doctor.dashboard') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-primary bg-opacity-10">
                            <i class="fas fa-tachometer-alt text-primary"></i>
                        </div>
                        <span class="fw-medium">Dashboard</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('doctor.slots.index') }}"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('doctor.appointments*') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-info bg-opacity-10">
                            <i class="fas fa-calendar-alt text-info"></i>
                        </div>
                        <span class="fw-medium">Appointments</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('doctor.prescription.upload') }}"
                        class="nav-link rounded-3 px-3 py-3 d-flex align-items-center sidebar-item {{ request()->routeIs('doctor.prescription-upload*') ? 'active' : 'text-white-50' }}">
                        <div class="icon-wrapper me-3 bg-success bg-opacity-10">
                            <i class="fas fa-file-medical text-success"></i>
                        </div>
                        <span class="fw-medium">Prescriptions</span>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                </li>
            @endif
        </ul>

        <!-- Sidebar Footer -->
        <div class="mt-auto px-3 py-3 border-top border-dark">
            <div class="d-flex align-items-center text-white-50">
                <i class="fas fa-lock me-2"></i>
                <small>Secure Portal • v2.4.1</small>
            </div>
        </div>
    </div>
</aside>

<style>
    #sidebar {
        transition: all 0.3s ease;
    }

    .sidebar-item {
        transition: all 0.2s ease;
    }

    .sidebar-item:hover {
        background: rgba(255, 255, 255, 0.05) !important;
        transform: translateX(5px);
        color: white !important;
    }

    .sidebar-item:hover .icon-wrapper {
        transform: scale(1.1);
    }

    .sidebar-item.active {
        background: rgba(52, 152, 219, 0.15) !important;
        color: white !important;
        border-left: 3px solid #3498db;
    }

    .sidebar-item.active .icon-wrapper {
        background: rgba(52, 152, 219, 0.3) !important;
    }

    .icon-wrapper {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    #sidebar::-webkit-scrollbar {
        width: 5px;
    }

    #sidebar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
    }

    #sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .bg-purple {
        background-color: #9b59b6 !important;
    }

    .text-purple {
        color: #9b59b6 !important;
    }
</style>
