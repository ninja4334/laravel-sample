<?php

namespace App\Policies;

use App\Models\BoardProfession;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardProfessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given board type.
     *
     * @param User $user
     * @param BoardProfession $profession
     * @return bool
     */
    public function access(User $user, BoardProfession $profession)
    {
        return $user->boards()->where('id', $profession->board_id)->exists();
    }

    /**
     * @param User $user
     * @param BoardProfession $profession
     * @return mixed
     */
    public function update(User $user, BoardProfession $profession)
    {
        return $this->access($user, $profession);
    }

    /**
     * @param User $user
     * @param BoardProfession $profession
     * @return mixed
     */
    public function delete(User $user, BoardProfession $profession)
    {
        return $this->access($user, $profession);
    }
}
