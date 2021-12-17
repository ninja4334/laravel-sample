<?php

namespace App\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class BoardUpdateRequest extends FormRequest
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
            'state_id'                             => 'required|integer|exists:states,id',
            'supervisors_app_id'                   => 'integer|exists:apps,id',
            'title'                                => 'required|string',
            'abbreviation'                         => 'required|string',
            'email'                                => 'required|email|max:60|unique:boards,email,' . Route::input('board_id'),
            'phone'                                => 'required|phone:US',
            'is_supervisors_verification_required' => 'boolean',
        ];
    }
}
