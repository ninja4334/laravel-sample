<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    /**
     * Listen to the Role saving event.
     *
     * @param Role $model
     *
     * @return void
     */
    public function saving(Role $model)
    {
        if (!$model->name) {
            $model->name = str_slug($model->display_name, '_');
        }
    }
}