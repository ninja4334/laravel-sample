<?php

namespace App\Policies;

use App\Models\App;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    /**
     * Check an access to application by user (member).
     *
     * @param User $user
     * @param App $app
     *
     * @return bool
     */
    public function accessByUser(User $user, App $app)
    {
        return $user->boards()->where('id', $app->board_id)->exists();
    }
}
