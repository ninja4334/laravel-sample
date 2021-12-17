<?php

namespace App\Repositories\Eloquent\Apps;

use App\Models\App;
use App\Repositories\Contracts\Apps\AppRepositoryContract;

class AppRepository implements AppRepositoryContract
{
    /**
     * Find application by id.
     *
     * @param int $app_id
     * @param bool $is_active
     *
     * @return mixed
     */
    public function find(int $app_id, bool $is_active = false)
    {
        return App::query()
            ->where('id', $app_id)
            ->where('is_active', $is_active)
            ->first();
    }
}
