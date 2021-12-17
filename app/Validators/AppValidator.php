<?php

namespace App\Validators;

use App\Models\User;

class AppValidator
{
    /**
     * Check if an app has at least one reviewer.
     *
     * @param $attribute
     * @param $value
     * @param $params
     *
     * @return mixed
     */
    public function validateReviewerExists($attribute, $value, $params)
    {
        if ($value >= 5) {
            return User::query()
                ->whereHas('apps', function ($query) use ($params) {
                    return $query->where('app_id', array_get($params, 0));
                })
                ->exists();
        }

        return true;
    }
}
