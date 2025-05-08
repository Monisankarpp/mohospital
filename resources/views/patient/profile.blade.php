@extends('layouts.base')

@section('title', 'Profile')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5">
        <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-primary bg-opacity-10 py-3 border-0">
                <h4 class="mb-0 text-primary">
                    <i class="bi bi-person-gear me-2"></i> My Profile
                </h4>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('patient.profile.update') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <!-- Profile Information -->
                        <div class="col-lg-6">
                            <div class="p-4 rounded-3 h-100" style="background-color: #f8f9fa;">
                                <h5 class="mb-4 text-primary position-relative d-inline-block">
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-placement="right"
                                        data-bs-content="Please ensure all information is accurate as it will be used for medical records and communications.">
                                        <i class="fas fa-info-circle text-primary"></i>
                                    </span>
                                    Personal Information
                                </h5>

                                <div class="mb-4">
                                    <label for="name" class="form-label text-muted">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary bg-opacity-10 text-primary">
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', auth()->user()->name) }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="phone" class="form-label text-muted">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary bg-opacity-10 text-primary">
                                            <i class="fa-solid fa-phone"></i>
                                        </span>
                                        <input type="text" id="phone" name="phone"
                                            value="{{ old('phone', auth()->user()->phone) }}"
                                            class="form-control @error('phone') is-invalid @enderror" required>
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label text-muted">Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary bg-opacity-10 text-primary">
                                            <i class="fa-solid fa-address-card"></i>
                                        </span>
                                        <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                            required>{{ old('address', auth()->user()->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Update -->
                        <div class="col-lg-6">
                            <div class="p-4 rounded-3 h-100" style="background-color: #f8f9fa;">
                                <h5 class="mb-4 text-primary">
                                    <i class="fa-solid fa-shield"></i> Password Settings
                                </h5>
                                <p class="text-muted mb-4">Leave blank to keep current password</p>

                                <div class="mb-4">
                                    <label for="current_password" class="form-label text-muted">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary bg-opacity-10 text-primary">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror">
                                    </div>
                                    @error('current_password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label text-muted">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary bg-opacity-10 text-primary">
                                            <i class="fa-solid fa-key"></i>
                                        </span>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label text-muted">Confirm
                                        Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary bg-opacity-10 text-primary">
                                            <i class="fa-solid fa-key"></i> </span>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">
                            <i class="bi bi-check-circle me-2"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


<!-- CSS -->
<style>
    .fa-info-circle {
        color: #5541e5;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .fa-info-circle:hover {
        transform: scale(1.2);
        color: #a29bfe;
    }

    .popover {
        border-left: 3px solid #6c5ce7;
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.15);
    }

    .popover-header {
        background-color: white;
        color: #4530e5;
        border-bottom: none;
        font-weight: 600;
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                container: 'body',
                html: true,
                content: function() {
                    return `
          <div class="popover-body">
            <p class="small mb-0 text-muted">
              <i class="fas fa-circle-info text-primary me-1"></i>
              Please ensure all information is accurate as it will be used for medical records and communications.
            </p>
          </div>
        `;
                }
            });
        });
    });
</script>
