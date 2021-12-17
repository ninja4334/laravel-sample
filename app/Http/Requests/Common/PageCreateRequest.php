<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class PageCreateRequest extends FormRequest
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
            'title'            => 'required|string|between:3,255',
            'slug'             => 'required|alpha_dash|unique:pages,slug',
            'description'      => 'required|string',
            'meta_title'       => 'string|max:255|nullable',
            'meta_description' => 'string|nullable',
            'is_active'        => 'required|boolean',
        ];
    }
}
