@extends('layouts.app')

@section('title', 'Forgot Password - Mohospital')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-10">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="row g-0">
        <!-- Left: Image & welcome -->
        <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center p-4"
        style="background: #e8f4fd;">
        <div class="text-center">
          <img src="https://i.pinimg.com/originals/ea/7f/2d/ea7f2dd47969349da148ea0b4ec56815.gif"
          class="img-fluid mb-4" alt="Password Reset Illustration" style="max-height: 220px;">
          <h3 class="fw-bold text-primary">Reset Password</h3>
          <p class="mt-2 text-muted">Enter your email and we'll send you a reset link.</p>
        </div>
        </div>

        <!-- Right: Form -->
        <div class="col-md-7 bg-white p-5">
        <h3 class="mb-4 text-center fw-bold text-primary">Forgot Your Password?</h3>

        @if (session('status'))
      <div class="alert alert-success rounded-3">
        {{ session('status') }}
      </div>
    @endif

        @if ($errors->any())
      <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
        @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
        </ul>
      </div>
    @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="mb-3">
          <label for="email" class="form-label text-muted">Email Address</label>
          <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
            required value="{{ old('email') }}" autofocus>
          @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
          Send Password Reset Link
          </button>

          <p class="text-center mt-3 mb-0 text-muted">
          Remember your password?
          <a href="{{ route('login') }}" class="text-decoration-none text-primary">Back to Login</a>
          </p>
        </form>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection