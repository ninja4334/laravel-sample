<?php

namespace App\Policies;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupervisorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth member user is owner of a given supervisor.
     *
     * @param User       $user
     * @param Supervisor $supervisor
     *
     * @return bool
     */
    public function owner(User $user, Supervisor $supervisor)
    {
        return $user->id === $supervisor->member_id;
    }
}
