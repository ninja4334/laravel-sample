<?php

namespace App\Policies;

use App\Models\AppStatus;
use App\Models\Submission;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to submission via board.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function access(User $user, Submission $submission)
    {
        return $user->boards()->where('id', $submission->app->board_id)->exists();
    }

    /**
     * Determine if an auth member user is owner of a given submission.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function owner(User $user, Submission $submission)
    {
        return $user->id === $submission->user_id;
    }

    /**
     * Determine if an auth user has access to submission.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function view(User $user, Submission $submission)
    {
        return $this->owner($user, $submission)
            || (!$user->hasRole('member') && $this->access($user, $submission));
    }

    /**
     * Determine if an auth user has access to submission via board.
     * The submission need be unlocked.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function lock(User $user, Submission $submission)
    {
        return
            $this->access($user, $submission)
            && !$submission->is_locked
            && $submission->hasReviewer($user->id);
    }

    /**
     * Determine if an auth user has access to submission via board.
     * The submission need to be locked
     * and an auth user has the rights to restrict the access of submission.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function unlock(User $user, Submission $submission)
    {
        return $this->access($user, $submission)
            && $submission->is_locked
            && $submission->hasReviewer($user->id);
    }

    /**
     * Determine if an auth user has access to submission via board.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function review(User $user, Submission $submission)
    {
        return
            $this->access($user, $submission)
            && (
                ($submission->status->system_name === AppStatus::SYSTEM_NAME_SUBMITTED
                    && $submission->progress_status !== Submission::STATUS_IN_REVIEW)
                || $submission->status->system_name !== AppStatus::SYSTEM_NAME_SUBMITTED);
    }

    /**
     * Determine if an auth user has access to submission via board
     * and submission status is "Submitted".
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function notifyReviewers(User $user, Submission $submission)
    {
        return
            $this->access($user, $submission)
            && $submission->status->system_name === AppStatus::SYSTEM_NAME_SUBMITTED;
    }

    /**
     * Determine if an auth user has access to submission via board.
     * The submission need be unlocked.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function updateStatus(User $user, Submission $submission)
    {
        return
            $this->access($user, $submission)
            && !$submission->is_locked
            && $submission->hasReviewer($user->id);
    }

    /**
     * Determine if an auth user has access to submission via board.
     * The submission need be locked.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function cancelUpdatingStatus(User $user, Submission $submission)
    {
        return
            $this->access($user, $submission)
            && $submission->is_locked
            && $submission->hasReviewer($user->id);
    }

    /**
     * Determine if an auth member user is owner of a given submission.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function updateFields(User $user, Submission $submission)
    {
        return
            !$user->hasRole('reviewer') &&
            (
                ($this->owner($user, $submission) && !$submission->status_id)
                || $submission->hasReviewer($user->id)
            );
    }

    /**
     * Determine if an auth member user is owner of a given submission
     * and the submission hasn't a status.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function submit(User $user, Submission $submission)
    {
        $result = true;

        if (!$this->owner($user, $submission)) {
            $result = false;
        }
        if ($submission->status_id) {
            $result = false;
        }
        if ($submission->requirement_hours < $submission->app->requirement_hours) {
            $result = false;
        }
        if ($submission->app->price) {
            $transactionExists = Transaction::query()
                ->where([
                    'user_id'                 => $user->id,
                    /*'metadata->submission->id' => $submission->id,
                    'metadata->status'        => 'succeeded'*/
                ])
                ->exists();
            if (!$transactionExists) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Determine if a given submission is not submitted.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function isNotSubmitted(User $user, Submission $submission)
    {
        return !$submission->status_id;
    }

    /**
     * Determine if an auth user has access to submission via board.
     * The submission need be unlocked.
     *
     * @param User       $user
     * @param Submission $submission
     *
     * @return bool
     */
    public function changeReviewer(User $user, Submission $submission)
    {
        return $this->access($user, $submission);
    }
}
