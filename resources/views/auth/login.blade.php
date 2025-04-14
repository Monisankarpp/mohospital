@extends('layouts.app')

@section('title', 'Login - Mohospital')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <!-- Left: Image and welcome text -->
                        <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center p-4"
                            style="background: #e8f4fd;">
                            <div class="text-center">
                                <img src="https://i.pinimg.com/originals/ea/7f/2d/ea7f2dd47969349da148ea0b4ec56815.gif"
                                    class="img-fluid mb-4" alt="Healthcare Illustration" style="max-height: 220px;">
                                <h3 class="fw-bold text-primary">Welcome Back</h3>
                                <p class="mt-2 text-muted">Login to continue exploring Mohospital's trusted healthcare
                                    services.</p>
                            </div>
                        </div>

                        <!-- Right: Login Form -->
                        <div class="col-md-7 bg-white p-5">
                            <h3 class="mb-4 text-center fw-bold text-primary">Login to Your Account</h3>

                            {{-- General Error --}}
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Error:</strong>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any() && session('seconds_remaining') <= 0)
                                <div class="alert alert-danger rounded-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('seconds_remaining') > 0)
                                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                    <strong><i class="bi bi-clock-fill"></i> Locked:</strong>
                                    Please wait <strong id="timer">{{ session('seconds_remaining') }}</strong> seconds
                                    before trying again.
                                </div>
                            @elseif (session('attempts_left') !== null && session('attempts_left') > 0)
                                <div class="alert alert-warning alert-dismissible fade show rounded-3" role="alert">
                                    <strong><i class="bi bi-exclamation-diamond-fill"></i> Warning:</strong>
                                    You have <strong>{{ session('attempts_left') }}</strong> login attempt(s) remaining.
                                </div>
                            @endif


                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Input -->
                                <div class="mb-3">
                                    <label for="email" class="form-label text-muted">Email Address</label>
                                    <input type="email" class="form-control rounded-3" name="email"
                                        value="{{ old('email') }}" required autofocus>
                                </div>

                                <!-- Password Input with Toggle -->
                                <div class="mb-3">
                                    <label for="password" class="form-label text-muted">Password</label>
                                    <div class="input-group" data-toggle-password>
                                        <input type="password" class="form-control border-end-0 rounded-start-3"
                                            name="password" id="password" required>
                                        <span class="input-group-text bg-white border-start-0 rounded-end-3"
                                            style="cursor: pointer;">
                                            <i class="fas fa-eye-slash text-muted"></i>
                                        </span>
                                    </div>
                                </div>


                                <!-- Remember & Forgot -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label text-muted" for="remember">Remember Me</label>
                                    </div>

                                    <a href="{{ route('password.request') }}"
                                        class="text-decoration-none text-primary small">
                                        Forgot Password?
                                    </a>
                                </div>

                                <!-- Login Button -->
                                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                                    Login
                                </button>

                                <!-- Register Link -->
                                <p class="text-center mt-3 mb-0 text-muted">
                                    Don’t have an account?
                                    <a href="{{ route('register.form') }}"
                                        class="text-decoration-none text-primary">Register</a>
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

    @if (session('seconds_remaining') > 0)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let seconds = parseInt('{{ session('seconds_remaining') }}');
                const timer = document.getElementById("timer");

                const form = document.querySelector("form");
                const inputs = form.querySelectorAll("input, button");
                inputs.forEach(input => input.disabled = true);

                const countdown = setInterval(() => {
                    seconds--;
                    timer.textContent = seconds;

                    if (seconds <= 0) {
                        clearInterval(countdown);
                        inputs.forEach(input => input.disabled = false);
                        timer.textContent = "0";
                        location.reload(); // Optional: resets the lock state visually
                    }
                }, 1000);
            });
        </script>
    @endif

@endsection
