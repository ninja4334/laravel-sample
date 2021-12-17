<?php

namespace App\Observers;

use App\Models\AppStatus;

class AppStatusObserver
{
    /**
     * Listen to the AppStatus deleting event.
     * Set a default (submitted) status to the submissions
     * when custom status has been deleted.
     *
     * @param AppStatus $model
     *
     * @return void
     */
    public function deleting(AppStatus $model)
    {
        $model->load('submissions');

        $model->submissions->each(function ($item) {
            $submittedStatus = AppStatus::query()
                ->where('system_name', AppStatus::SYSTEM_NAME_SUBMITTED)
                ->first();

            $item->status_id = $submittedStatus->id;
            $item->save();
        });
    }
}