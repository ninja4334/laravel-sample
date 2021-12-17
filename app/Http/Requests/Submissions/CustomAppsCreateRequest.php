<?php

namespace App\Http\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class CustomAppsCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*.email'                    => 'required|email|max:60',
            '*.first_name'               => 'required|string|between:3,36',
            '*.last_name'                => 'required|string|between:3,36',
            '*.phone'                    => 'phone:LENIENT,US|nullable',
            '*.license_type_acronym'     => 'required|exists:app_types,acronym',
            '*.renewal_date'             => 'required|date_format:Y-m-d',
            '*.is_registration_required' => 'required|boolean',
            '*.is_send_email_required'   => 'required|boolean'
        ];
    }
}
