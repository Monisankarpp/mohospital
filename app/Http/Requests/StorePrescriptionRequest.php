<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
{
  public function authorize(): bool
  {
    return auth()->user()->role === 'doctor';
  }

  public function rules(): array
  {
    return [
      'patient_id' => 'required|exists:users,id',
      'notes' => 'required|string',
      'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];
  }
}
