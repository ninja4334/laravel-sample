<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given user.
     *
     * @param User $authUser
     * @param User $givenUser
     *
     * @return bool
     */
    public function access(User $authUser, User $givenUser)
    {
        return $authUser->boards()->first()->id == $givenUser->boards()->first()->id;
    }

    /**
     * Determine if a given user is not the last admin user.
     *
     * @param User        $givenUser
     * @param string|null $roleName
     *
     * @return bool
     */
    public function update(User $givenUser, string $roleName = null)
    {
        if (!$roleName || !$givenUser->hasRole('admin') || $roleName == 'admin') {
            return true;
        }

        $count = User::byBoardId($givenUser->boards()->first()->id)
            ->byRoleName('admin')
            ->count();

        return $count > 1;
    }

    /**
     * Determine if a given user can be destroyed.
     *
     * @param User $authUser
     * @param User $givenUser
     *
     * @return bool
     */
    public function delete(User $authUser, User $givenUser)
    {
        return
            !$givenUser->hasRole('system')
            || ($givenUser->id != 1
                && $authUser->id != $givenUser->id
                && (!$authUser->hasRole('super_admin') && $this->access($authUser, $givenUser))
            );
    }
}
