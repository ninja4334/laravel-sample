<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationBoardRequest extends FormRequest
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
            'role'                     => 'required|alpha|exists:roles,name,name,ADMIN',
            'first_name'               => 'required|string|between:3,20',
            'last_name'                => 'required|string|between:3,20',
            'email'                    => 'required|email|max:60|unique:users',
            'password'                 => 'required|min:6',
            'password_confirmation'    => 'required|same:password',
            'board'                    => 'required|array',
            'board.title'              => 'required|string',
            'board.abbreviation'       => 'required|string',
            'board.email'              => 'required|email|max:60|unique:boards,email',
            'board.phone'              => 'required|phone:US',
            'board.state_id'           => 'required|max:10',
            'board.professions'        => 'required|array',
            'board.professions.*'      => 'required|array',
            'board.professions.*.name' => 'required|string',
            'agree'                    => 'required|boolean',
        ];
    }
}
