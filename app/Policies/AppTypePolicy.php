<?php

namespace App\Policies;

use App\Models\AppType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given board type.
     *
     * @param User $user
     * @param AppType $type
     * @return bool
     */
    public function access(User $user, AppType $type)
    {
        return $user->boards()->where('id', $type->board_id)->exists();
    }

    /**
     * @param User $user
     * @param AppType $type
     * @return mixed
     */
    public function update(User $user, AppType $type)
    {
        return $this->access($user, $type);
    }

    /**
     * Check if application type has submissions with existing user.
     *
     * @param User $user
     * @param AppType $type
     * @return mixed
     */
    public function delete(User $user, AppType $type)
    {
        $existsSubmissions = $type
            ->submissions()
            ->has('user')
            ->exists();

        return $this->access($user, $type) && !$existsSubmissions;
    }
}
