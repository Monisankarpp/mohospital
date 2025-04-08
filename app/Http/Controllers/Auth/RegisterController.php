<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function show()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->registerService->register($request->validated());

        Auth::login($user);

        return redirect()->route(match ($user->role) {
            'doctor' => 'doctor.dashboard',
            'medical_store_owner' => 'medical-store.dashboard',
            default => 'patient.dashboard',
        });
    }
}
