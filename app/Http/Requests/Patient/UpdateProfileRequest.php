<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ensure only authenticated users can update their profile
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s\(\)]+$/'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required_with:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.regex' => 'Name can only contain letters and spaces.',
            'phone.regex' => 'Phone number format is invalid.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'current_password.required_with' => 'Please enter your current password to set a new one.',
        ];
    }
}
