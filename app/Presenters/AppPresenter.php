<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class AppPresenter extends Presenter
{
    /**
     * Build a link of application.
     *
     * @return string
     */
    public function link()
    {
        return url()->to(config('app.apps_url') . '/' . $this->entity->id);
    }

    /**
     * Reformat a renewal date.
     *
     * @param Carbon|null $value
     *
     * @return string|null
     */
    public function renewal_date($value)
    {
        if ($value) {
            return Carbon::parse($value)->toDateString();
        }

        return null;
    }
}