<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'email'      => 'required|email|max:60|unique:users',
            'first_name' => 'required|string|between:3,20',
            'last_name'  => 'required|string|between:3,20',
            'phone'      => 'phone:US|nullable',
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

        $validator->sometimes('role.name', 'required|alpha_dash|exists:roles,name', function () {
            return !auth()->user()->hasRole('super_admin');
        });

        return $validator;
    }
}
