<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserActivityType;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserActivityTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth member user is owner of a given user activity type.
     *
     * @param User $user
     * @param UserActivityType $userActivityType
     *
     * @return bool
     */
    public function owner(User $user, UserActivityType $userActivityType)
    {
        return $user->id === $userActivityType->user_id;
    }
}
