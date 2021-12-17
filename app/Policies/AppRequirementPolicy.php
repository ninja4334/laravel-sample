<?php

namespace App\Policies;

use App\Models\AppRequirement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppRequirementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given application requirement.
     *
     * @param User $user
     * @param AppRequirement $requirement
     * @return bool
     */
    public function access(User $user, AppRequirement $requirement)
    {
        return $user->boards()->where('id', $requirement->app->board_id)->exists();
    }

    /**
     * @param User $user
     * @param AppRequirement $requirement
     * @return mixed
     */
    public function update(User $user, AppRequirement $requirement)
    {
        return $this->access($user, $requirement);
    }

    /**
     * @param User $user
     * @param AppRequirement $requirement
     * @return mixed
     */
    public function delete(User $user, AppRequirement $requirement)
    {
        return $this->access($user, $requirement);
    }
}
