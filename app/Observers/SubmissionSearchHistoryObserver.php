<?php

namespace App\Observers;

use App\Models\SubmissionSearchHistory;

class SubmissionSearchHistoryObserver
{
    /**
     * Listen to the SubmissionSearchHistory creating event.
     *
     * @param SubmissionSearchHistory $model
     *
     * @return void
     */
    public function creating(SubmissionSearchHistory $model)
    {
        $model->created_at = $model->freshTimestamp();
    }
}