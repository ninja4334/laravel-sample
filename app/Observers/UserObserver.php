<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Listen to the User updating event.
     *
     * @param User $model
     *
     * @return void
     */
    public function updating(User $model)
    {
        if ($model->is_active) {
            $model->confirmation_token = null;
        }
    }

    /**
     * Listen to the User deleting event.
     *
     * @param User $model
     *
     * @return void
     */
    public function deleting(User $model)
    {
        $model->email .= '_' . $model->id;
        $model->push();
    }
}