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
        $key = 'login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in a few minutes.',
            ])->withInput();
        }

        RateLimiter::hit($key, 60); // lockout for 60 seconds after 5 failed attempts

        $credentials = $request->validated();
        $remember = $request->filled('remember');

        if ($this->loginService->authenticate($credentials, $remember)) {
            RateLimiter::clear($key); // Clear attempts on success
            return $this->loginService->redirectBasedOnRole();
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout(): RedirectResponse
    {
        $this->loginService->logout();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
