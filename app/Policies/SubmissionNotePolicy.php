<?php

namespace App\Policies;

use App\Models\SubmissionNote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionNotePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param SubmissionNote $note
     * @return mixed
     */
    public function update(User $user, SubmissionNote $note)
    {
        return $this->access($user, $note);
    }
}
