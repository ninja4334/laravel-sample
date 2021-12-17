<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class AppNotificationPresenter extends Presenter
{
    /**
     * Format date attribute to only date string.
     *
     * @param Carbon|null $value
     * @return string|null
     */
    public function date($value)
    {
        if ($value) {
            return Carbon::parse($value)->toDateString();
        }
    }
}