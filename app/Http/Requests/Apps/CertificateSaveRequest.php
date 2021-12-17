<?php

namespace App\Http\Requests\Apps;

use Illuminate\Foundation\Http\FormRequest;

class CertificateSaveRequest extends FormRequest
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
            'name'              => 'required|string|between:2,255',
            'email'             => 'required|email|max:60',
            'phone'             => 'phone:US|nullable',
            'signature_title'   => 'required|string|between:2,255',
            'signature_name'    => 'required|string|between:2,255',
            'signet_file_id'    => 'required|integer|exists:media,id',
            'signature_file_id' => 'required|integer|exists:media,id'
        ];
    }
}
