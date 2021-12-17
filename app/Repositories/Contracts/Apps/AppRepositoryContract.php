<?php

namespace App\Repositories\Contracts\Apps;

interface AppRepositoryContract
{
    /**
     * Find application by id.
     *
     * @param int $app_id
     * @param bool $is_active
     *
     * @return mixed
     */
    public function find(int $app_id, bool $is_active = false);
}
