<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Route;

class UserUpdateRequest extends FormRequest
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
            'email'            => 'required|email|max:60|unique:users,email,' . Route::input('user_id'),
            'current_password' => 'check_password:' . Route::input('user_id'),
            'role.name'        => 'alpha_dash|exists:roles,name',
            'first_name'       => 'required|string|between:3,20',
            'last_name'        => 'required|string|between:3,20',
            'phone'            => 'phone:US|nullable'
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
            return !User::where('email', $input->email)->exists();
        });

        return $validator;
    }
}
