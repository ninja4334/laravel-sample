<?php

namespace App\Repositories\Eloquent\Apps;

use App\Models\App;
use App\Repositories\Contracts\Apps\CEActivityRepositoryContract;

class CEActivityRepository implements CEActivityRepositoryContract
{
    /**
     * Get application activities.
     *
     * @param int $app_id
     *
     * @return mixed
     */
    public function all(int $app_id)
    {
        $app = App::with('activity', 'requirements')
            ->where('id', $app_id)
            ->first();

        $activity = $app->activity;

        if ($activity) {
            $activity->offsetSet('items', $app->requirements);
        }

        return $activity;
    }
}
