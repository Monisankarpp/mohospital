<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * Register a new user with secure password handling and transactional safety.
     */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'address' => $data['address'],
                'role' => $data['role'],
            ]);
        });
    }
}
