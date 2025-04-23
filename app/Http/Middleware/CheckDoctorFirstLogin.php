<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDoctorFirstLogin
{
  public function handle($request, Closure $next)
  {
    $user = Auth::user();

    if ($user->role === 'doctor' && $user->doctor->schedules()->count() === 0) {
      if (
        $request->route()->getName() !== 'doctor.slots.setup' &&
        $request->route()->getName() !== 'doctor.slots.store'
      ) {
        return redirect()->route('doctor.slots.setup');
      }
    }

    return $next($request);
  }
}