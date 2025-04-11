@extends('layouts.app')

@section('title', 'Register - Mohospital')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-10">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="row g-0">

        <!-- Left Illustration -->
        <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center p-4 text-white"
        style="background: #e8f4fd;">
        <div class="text-center">
          <img src="https://i.pinimg.com/originals/ea/7f/2d/ea7f2dd47969349da148ea0b4ec56815.gif"
          class="img-fluid mb-4" alt="Healthcare Illustration" style="max-height: 220px;">
          <h3 class="fw-bold text-primary">Your Health, Our Priority</h3>
          <p class="mt-2 text-muted">Join Mohospital and connect with trusted doctors, hospitals, and pharmacies.
          </p>
        </div>
        </div>

        <!-- Right Form -->
        <div class="col-md-7 bg-white p-5">
        <h3 class="mb-4 text-center fw-bold text-primary">Create Your Account</h3>

        @if ($errors->any())
      <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
        @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
        </ul>
      </div>
    @endif

        <form method="POST" action="{{ route('register.submit') }}">
          @csrf

          <div class="mb-3">
          <label for="name" class="form-label text-muted">Full Name</label>
          <input type="text" class="form-control rounded-3" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
          <label for="email" class="form-label text-muted">Email Address</label>
          <input type="email" class="form-control rounded-3" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
          <label for="phone" class="form-label text-muted">Phone Number</label>
          <input type="text" class="form-control rounded-3" name="phone" value="{{ old('phone') }}" required
            maxlength="10" pattern="\d{10}" inputmode="numeric"
            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)"
            title="Phone number must be exactly 10 digits">
          </div>


          <div class="mb-3">
          <label for="address" class="form-label text-muted">Address</label>
          <textarea class="form-control rounded-3" name="address" rows="2"
            required>{{ old('address') }}</textarea>
          </div>

          <div class="mb-3">
          <label for="role" class="form-label text-muted">Register As</label>
          <select class="form-select rounded-3" name="role" required>
            <option value="">-- Select Role --</option>
            <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
            <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
            <option value="medical_store_owner" {{ old('role') == 'medical_store_owner' ? 'selected' : '' }}>Medical
            Store Owner</option>
          </select>
          </div>

          <!-- Password with toggle -->
          <div class="mb-3">
          <label for="password" class="form-label text-muted">Password</label>
          <div class="input-group" data-toggle-password>
            <input type="password" class="form-control border-end-0 rounded-start-3" name="password" id="password"
            required>
            <span class="input-group-text bg-white border-start-0 rounded-end-3" style="cursor: pointer;">
            <i class="fas fa-eye-slash text-muted"></i>
            </span>
          </div>
          </div>


          <!-- Confirm Password (no toggle) -->
          <div class="mb-4">
          <label for="password_confirmation" class="form-label text-muted">Confirm Password</label>
          <input type="password" class="form-control rounded-3" name="password_confirmation" id="confirmPassword"
            required>
          </div>

          <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">Register</button>

          <p class="text-center mt-3 mb-0 text-muted">
          Already have an account?
          <a href="{{ route('login') }}" class="text-decoration-none text-primary">Login</a>
          </p>
        </form>
        </div>

      </div>
      </div>
    </div>
    </div>
  </div>
@endsection

@section('scripts')
  @include('components.scripts.password-toggle')
@endsection