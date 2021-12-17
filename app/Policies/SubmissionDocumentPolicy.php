<?php

namespace App\Policies;

use App\Models\SubmissionDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionDocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given application document.
     *
     * @param User               $user
     * @param SubmissionDocument $document
     * @return bool
     */
    public function access(User $user, SubmissionDocument $document)
    {
        return $user->id === $document->submission->user_id;
    }

    /**
     * TODO: need comment
     *
     * @param User               $user
     * @param SubmissionDocument $document
     * @return mixed
     */
    public function index(User $user, SubmissionDocument $document)
    {
        return $this->access($user, $document);
    }

    /**
     * TODO: need comment
     *
     * @param User               $user
     * @param SubmissionDocument $document
     * @return mixed
     */
    public function upload(User $user, SubmissionDocument $document)
    {
        return $this->access($user, $document);
    }

    /**
     * TODO: need comment
     *
     * @param User               $user
     * @param SubmissionDocument $document
     * @return mixed
     */
    public function delete(User $user, SubmissionDocument $document)
    {
        return $this->access($user, $document) && !$document->submission->status_id;
    }
}
