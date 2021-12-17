<?php

namespace App\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionHistoryCreateRequest extends FormRequest
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
            'type_id'     => 'required|integer|exists:app_types,id',
            'percentages' => 'required|integer|between:1,100',
            'date_start'  => 'required|date_format:m/d/Y',
            'date_end'    => 'required|date_format:m/d/Y|after:date_start'
        ];
    }
}
