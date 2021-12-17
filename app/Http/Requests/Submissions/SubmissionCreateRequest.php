<?php

namespace App\Http\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionCreateRequest extends FormRequest
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
            'email'        => 'required|email|unique:users|max:60',
            'first_name'   => 'required|string|between:3,20',
            'last_name'    => 'required|string|between:3,20',
            'phone'        => 'required|phone:US',
            'type_id'      => 'required|integer|exists:app_types,id',
            'renewal_date' => 'required|date_format:m/d/Y',
        ];
    }
}
