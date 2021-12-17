<?php

namespace App\Policies;

use App\Models\SubmissionRequirement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionRequirementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given submission requirement.
     *
     * @param User $user
     * @param SubmissionRequirement $requirement
     * @return bool
     */
    public function access(User $user, SubmissionRequirement $requirement)
    {
        return $user->id === $requirement->submission->user_id;
    }

    /**
     * @param User $user
     * @param SubmissionRequirement $requirement
     * @return mixed
     */
    public function update(User $user, SubmissionRequirement $requirement)
    {
        return $this->access($user, $requirement) && !$requirement->submission->status_id;
    }

    /**
     * @param User $user
     * @param SubmissionRequirement $requirement
     * @return mixed
     */
    public function delete(User $user, SubmissionRequirement $requirement)
    {
        return $this->access($user, $requirement) && !$requirement->submission->status_id;
    }
}
