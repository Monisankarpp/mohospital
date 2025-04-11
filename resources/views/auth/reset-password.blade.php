@extends('layouts.app')

@section('title', 'Reset Password - Mohospital')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-10">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="row g-0">

        <!-- Left: Illustration and message -->
        <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center p-4"
        style="background: #e8f4fd;">
        <div class="text-center">
          <img src="https://i.pinimg.com/originals/ea/7f/2d/ea7f2dd47969349da148ea0b4ec56815.gif"
          class="img-fluid mb-4" alt="Reset Password Illustration" style="max-height: 200px;">
          <h4 class="fw-bold text-primary">Reset Your Password</h4>
          <p class="text-muted mt-2">Enter your new password and confirm it to regain access to your account.</p>
        </div>
        </div>

        <!-- Right: Reset Form -->
        <div class="col-md-7 bg-white p-5">
        <h3 class="mb-4 text-center fw-bold text-primary">Create a New Password</h3>

        @if ($errors->any())
      <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
        @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
        </ul>
      </div>
    @endif

        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="mb-3">
          <label for="email" class="form-label text-muted">Email Address</label>
          <input type="email" id="email" name="email" class="form-control rounded-3"
            value="{{ $email ?? old('email') }}" required>
          </div>

          <div class="mb-3">
          <label for="password" class="form-label text-muted">New Password</label>
          <input type="password" id="password" name="password" class="form-control rounded-3" required>
          </div>

          <div class="mb-4">
          <label for="password_confirmation" class="form-label text-muted">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation"
            class="form-control rounded-3" required>
          </div>

          <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
          Reset Password
          </button>
        </form>

        <p class="text-center mt-4 mb-0 text-muted">
          Remember your password?
          <a href="{{ route('login') }}" class="text-decoration-none text-primary">Login</a>
        </p>
        </div>

      </div>
      </div>
    </div>
    </div>
  </div>
@endsection