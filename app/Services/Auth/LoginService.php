<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LoginService
{
    /**
     * Attempt to authenticate the user.
     */
    public function authenticate(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * Redirect user based on their role.
     */
    public function redirectBasedOnRole(): RedirectResponse
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            $this->logout();
            return redirect()->route('login')->withErrors(['email' => 'Unauthorized role or account.']);
        }

        return match ($user->role) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'hospital_owner' => redirect()->route('hospital.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'medical_store_owner' => redirect()->route('medical-store.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => $this->handleInvalidRole(),
        };
    }

    /**
     * Log the user out securely.
     */
    public function logout(): void
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    /**
     * Handle an invalid or unrecognized user role.
     */
    protected function handleInvalidRole(): RedirectResponse
    {
        $this->logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Your account role is not recognized by the system.',
        ]);
    }
}
