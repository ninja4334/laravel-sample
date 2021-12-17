<?php

namespace App\Policies;

use App\Models\AppDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppDocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if an auth user has access to a given application document.
     *
     * @param User        $user
     * @param AppDocument $document
     *
     * @return bool
     */
    public function access(User $user, AppDocument $document)
    {
        return $user->boards()->where('id', $document->app->board_id)->exists();
    }

    /**
     * @param User        $user
     * @param AppDocument $document
     *
     * @return mixed
     */
    public function update(User $user, AppDocument $document)
    {
        return $this->access($user, $document);
    }

    /**
     * @param User        $user
     * @param AppDocument $document
     *
     * @return mixed
     */
    public function delete(User $user, AppDocument $document)
    {
        return $this->access($user, $document);
    }
}
