<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationMemberRequest extends FormRequest
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
            'role'                  => 'required|alpha|exists:roles,name,name,member',
            'first_name'            => 'required|string|between:3,20',
            'last_name'             => 'required|string|between:3,20',
            'email'                 => 'required|email|max:60|unique:users',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'board.state_id'        => 'required_without:board.id|max:10',
            'board.id'              => 'required|integer',
            'board.profession'      => 'required_without:board.id',
            'agree'                 => 'required|boolean'
        ];
    }
}
