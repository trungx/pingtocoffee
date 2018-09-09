<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFieldRequest extends FormRequest
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
        return [
            'contact_field_id' => 'required|exists:contact_fields,id',
            'label_id' => 'required|alpha_num|exists:default_labels,id',
            'privacy_id' => 'required|exists:privacy,id',
            'value' => 'required|max:255',
        ];
    }
}
