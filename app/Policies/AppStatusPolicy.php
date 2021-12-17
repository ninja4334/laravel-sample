<?php

namespace App\Policies;

use App\Models\AppStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given board status.
     *
     * @param User      $user
     * @param AppStatus $status
     * @return bool
     */
    public function access(User $user, AppStatus $status)
    {
        return $user->boards()->where('id', $status->board_id)->exists();
    }

    /**
     * Determine if a status is not default.
     *
     * @param User      $user
     * @param AppStatus $status
     * @return mixed
     */
    public function update(User $user, AppStatus $status)
    {
        return !$status->is_default && $this->access($user, $status);
    }

    /**
     * Determine if a status is not default.
     *
     * @param User      $user
     * @param AppStatus $status
     * @return mixed
     */
    public function delete(User $user, AppStatus $status)
    {
        return !$status->is_default && $this->access($user, $status);
    }
}
