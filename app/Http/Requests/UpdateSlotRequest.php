<?php

namespace App\Http\Requests;
use Carbon\Carbon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Let policy or controller handle authorization
        return true;
    }

    public function rules(): array
    {
        return [
            'start_time' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $minTime = now()->addHours(24);
                    if (Carbon::parse($value) < $minTime) {
                        $fail("Start time must be at least 24 hours from now");
                    }
                }
            ],
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                function ($attribute, $value, $fail) {
                    $start = Carbon::parse(request('start_time'));
                    $end = Carbon::parse($value);

                    $duration = $start->diffInMinutes($end);

                    if ($duration < 15) {
                        $fail("Slot duration must be at least 15 minutes");
                    }
                }
            ]
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'start_time.required' => 'Start time is required.',
    //         'start_time.date_format' => 'Start time must be in HH:MM format.',
    //         'end_time.required' => 'End time is required.',
    //         'end_time.date_format' => 'End time must be in HH:MM format.',
    //         'end_time.after' => 'End time must be after start time.',
    //     ];
    // }
}
