<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class SubmissionPresenter extends Presenter
{
    /**
     * Add a given time to application submitted (by reviewer) time.
     *
     * @return string|null
     */
    public function locking_time()
    {
        $user = $this->entity->reviewers->first();

        if ($user && $user->pivot->locked_at) {
            $time = config('app.submission_locking_time');

            $current = Carbon::now();
            $locked_time = Carbon::parse($user->pivot->locked_at)->addSeconds($time);

            if ($current->diffInSeconds($locked_time, false) > 0) {
                return $current->diffInSeconds($locked_time);
            }
        }

        return null;
    }

    /**
     * Retrieve difference between submission's created_at
     * and application renewal date or year.
     *
     * @return mixed
     */
    public function expiration_date()
    {
        $app = $this->entity->app;

        if ($app) {
            if ($app->renewal_date) {
                return $app->renewal_date;
            } else if ($app->renewal_years && $this->entity->approved_at) {
                $date = Carbon::parse($this->entity->approved_at);
                $date->addYears($app->renewal_years);
                return $date->toDateTimeString();
            }
        } else {
            return $this->entity->renewal_date->toDateTimeString();
        }
    }
}