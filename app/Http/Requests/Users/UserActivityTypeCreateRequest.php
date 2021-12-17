<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserActivityTypeCreateRequest extends FormRequest
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
            'board_activity_type_id' => 'required|integer|exists:board_activity_types,id',
            'hours'                  => 'required|numeric|max:1000',
            'passed_at'              => 'required|date_format:Y-m-d'
        ];
    }
}
