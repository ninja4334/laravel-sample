<?php

namespace App\Validators;

use App\Models\User;
use Auth;
use Hash;

class PasswordValidator
{
    /**
     * Check a hash password.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return mixed
     */
    public function validatePassword($attribute, $value, $parameters)
    {
        if (isset($parameters[0])) {
            $user = User::find($parameters[0]);
        } else {
            $user = Auth::user();
        }

        return Hash::check($value, $user->password);
    }
}
