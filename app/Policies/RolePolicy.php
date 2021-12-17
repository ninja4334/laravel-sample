<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given role.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function access(User $user, Role $role)
    {
        return $role->boards()->where('board_id', $user->boards()->first()->id)->exists();
    }

    /**
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function view(User $user, Role $role)
    {
        return $this->access($user, $role);
    }

    /**
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function update(User $user, Role $role)
    {
        return
            $user->role->id != $role->id
            && $this->access($user, $role);
    }

    /**
     * Determine if a given role can be destroyed.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function delete(User $user, Role $role)
    {
        return
            !$role->is_system
            && $user->role->id != $role->id
            && $this->access($user, $role);
    }
}
