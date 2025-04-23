<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i|after:start_time',
      'lunch_start' => 'required|date_format:H:i',
      'lunch_end' => 'required|date_format:H:i|after:lunch_start',
      'working_days' => 'required|array|min:3|max:6',
      'working_days.*' => Rule::in([
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday'
      ]),
      'breaks' => 'sometimes|array',
      'breaks.*.start' => 'required_with:breaks|date_format:H:i',
      'breaks.*.end' => 'required_with:breaks|date_format:H:i|after:breaks.*.start',
    ];
  }

  public function messages()
  {
    return [
      'working_days.min' => 'You must select at least 3 working days',
      'working_days.max' => 'You can select maximum 6 working days',
    ];
  }
}