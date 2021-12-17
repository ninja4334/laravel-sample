<?php

namespace App\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class AppTypeUpdateRequest extends FormRequest
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
            'name'    => 'required|string|max:255|unique:app_types,name,' . Route::input('type_id'),
            'acronym' => 'required|string|max:10|unique:app_types,acronym,' . Route::input('type_id')
        ];
    }
}
