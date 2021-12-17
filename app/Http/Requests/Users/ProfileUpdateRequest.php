<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'email'                 => 'required|email|max:60|unique:users,email,' . auth()->id(),
            'current_password'      => 'check_password',
            'password'              => 'min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'first_name'            => 'required|string|between:3,20',
            'last_name'             => 'required|string|between:3,20',
            'phone'                 => 'phone:US|nullable',
        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('current_password', 'required', function ($input) {
            return (bool)$input->password || ($input->email != auth()->user()->email);
        });

        return $validator;
    }
}
