<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'max:255',
            'next_expected_date' => 'required|date_format:Y/m/d h:i A',
        ];

        if ($this->has('reminders_frequency')) {
            $rules += ['frequency_number' => 'min:1|max:255|numeric'];
        }

        return $rules;
    }
}
