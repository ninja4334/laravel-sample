<?php

namespace App\Policies;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppNotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given application notification.
     *
     * @param User            $user
     * @param AppNotification $notification
     *
     * @return bool
     */
    public function access(User $user, AppNotification $notification)
    {
        return $user->whereHas('boards.types', function ($query) use ($notification) {
            return $query->where('id', $notification->type_id);
        })->exists();
    }

    /**
     * @param User            $user
     * @param AppNotification $notification
     *
     * @return mixed
     */
    public function update(User $user, AppNotification $notification)
    {
        return $this->access($user, $notification);
    }

    /**
     * @param User            $user
     * @param AppNotification $notification
     *
     * @return mixed
     */
    public function delete(User $user, AppNotification $notification)
    {
        return $this->access($user, $notification);
    }
}
