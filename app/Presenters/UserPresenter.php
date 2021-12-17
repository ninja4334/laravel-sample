<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    /**
     * Generate a full name.
     *
     * @return string
     */
    public function full_name()
    {
        return $this->entity->first_name . ' ' . $this->entity->last_name;
    }
}