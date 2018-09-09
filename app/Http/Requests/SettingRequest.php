<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        if ($this->filled('year') || $this->filled('month') || $this->filled('day')) {
            $rules = [
                'year' => 'required|numeric|min:1918|max:' . Carbon::now()->format('Y'),
                'month' => 'required|numeric|min:1|max:12',
                'day' => 'required|numeric|min:1|max:31',
            ];
        } else {
            $rules = [
                'year' => 'nullable|numeric|min:1918|max:' . Carbon::now()->format('Y'),
                'month' => 'nullable|numeric|min:1|max:12',
                'day' => 'nullable|numeric|min:1|max:31',
            ];
        }

        return $rules + [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'description' => 'max:300',
            'email' => 'required|email|max:2083|unique:users,email,' . $this->user()->id,
            'gender' => 'in:male,female,other,none',
            'timezone' => 'required',
        ];
    }
}
