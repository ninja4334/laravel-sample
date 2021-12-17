<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class SubmissionRequirementPresenter extends Presenter
{
    /**
     * Convert a passed at attribute to date string.
     *
     * @param Carbon|null $value
     * @return string|null
     */
    public function passed_at($value)
    {
        if ($value) {
            return Carbon::parse($value)->toDateString();
        }
    }
}