<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Allow everyone to register.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare and sanitize input before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
            'email' => trim($this->email),
            'phone' => preg_replace('/\D/', '', $this->phone),
        ]);
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'], // no unique email
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:15',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,15}$/'
            ],
            'phone' => ['required', 'digits:10'],
            'address' => ['required', 'string'],
            'role' => ['required', 'in:patient,doctor,medical_store_owner'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'Password must be 8-15 characters long and include at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
        ];
    }
}
