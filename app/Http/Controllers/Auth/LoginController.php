<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $email = strtolower($request->input('email'));
        $key = 'login:' . $email . '|' . $request->ip();

        $maxAttempts = 5; // 5 attempts allowed
        $decaySeconds = 60; // 1 minute lockout

        // Check if already locked out
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $secondsRemaining = RateLimiter::availableIn($key);
            return back()
                ->withErrors([
                    'email' => "Too many login attempts.",
                ])
                ->with('seconds_remaining', $secondsRemaining)
                ->with('attempts_left', 0)
                ->withInput();
        }

        $credentials = $request->validated();
        $remember = $request->filled('remember');

        if (strlen($credentials['password']) < 8) {
            return back()
                ->withErrors(['password' => 'Password must be at least 8 characters.'])
                ->with('attempts_left', $maxAttempts - RateLimiter::attempts($key))
                ->withInput();
        }

        if ($this->loginService->authenticate($credentials, $remember)) {
            RateLimiter::clear($key);
            return $this->loginService->redirectBasedOnRole();
        }

        // Increment attempt counter
        RateLimiter::hit($key, $decaySeconds);
        $attemptsRemaining = $maxAttempts - RateLimiter::attempts($key);

        return back()
            ->withErrors(['email' => 'The email address or password you entered is incorrect.'])
            ->with('attempts_left', $attemptsRemaining)
            ->withInput();
    }


    public function logout(): RedirectResponse
    {
        $this->loginService->logout();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
