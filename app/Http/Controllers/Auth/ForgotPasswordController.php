<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the sending of a reset link email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'We couldn’t find an account with that email address.',
        ]);

        // Rate limiting: max 5 attempts per 1 hour from the same IP
        $throttleKey = 'forgot-password:' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => ['Too many password reset attempts. Please try again in 1 hour.'],
            ]);
        }

        RateLimiter::hit($throttleKey, 3600); // 3600 seconds = 1 hour

        // Attempt to send reset link
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // Catch all unexpected errors
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
