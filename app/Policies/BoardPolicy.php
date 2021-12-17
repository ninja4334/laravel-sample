<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given board.
     *
     * @param User  $user
     * @param Board $board
     *
     * @return mixed
     */
    public function access(User $user, Board $board)
    {
        return $user->boards->contains('id', $board->id);
    }

    /**
     * @param User  $user
     * @param Board $board
     *
     * @return mixed
     */
    public function update(User $user, Board $board)
    {
        return $this->access($user, $board);
    }

    /**
     * @param User  $user
     * @param Board $board
     *
     * @return mixed
     */
    public function updateFee(User $user, Board $board)
    {
        return $this->access($user, $board) || $user->can('boards.fee.manage');
    }
}
