<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedRoleBased
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect()->route(match (Auth::user()->role) {
                'doctor' => 'doctor.dashboard',
                'medical_store_owner' => 'medical-store.dashboard',
                'patient' => 'patient.dashboard',
            });
        }

        return $next($request);
    }
}

