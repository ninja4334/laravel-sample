<?php

namespace App\Policies;

use App\Models\AppChecklist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppChecklistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given application checklist item.
     *
     * @param User         $user
     * @param AppChecklist $checklist
     *
     * @return bool
     */
    public function access(User $user, AppChecklist $checklist)
    {
        return $user->boards()->where('id', $checklist->app->board_id)->exists();
    }

    /**
     * @param User         $user
     * @param AppChecklist $checklist
     *
     * @return mixed
     */
    public function update(User $user, AppChecklist $checklist)
    {
        return $this->access($user, $checklist);
    }

    /**
     * @param User         $user
     * @param AppChecklist $checklist
     *
     * @return mixed
     */
    public function delete(User $user, AppChecklist $checklist)
    {
        return $this->access($user, $checklist);
    }
}
