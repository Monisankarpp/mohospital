<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                return match ($user->role) {
                    'super_admin' => redirect()->route('admin.dashboard'),
                    'hospital_owner' => redirect()->route('hospital.dashboard'),
                    'doctor' => redirect()->route('doctor.dashboard'),
                    'medical_store_owner' => redirect()->route('medical-store.dashboard'),
                    default => redirect()->route('patient.dashboard'),
                };
            }
        }

        return $next($request);
    }
}

