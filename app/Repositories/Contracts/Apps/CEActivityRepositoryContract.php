<?php

namespace App\Repositories\Contracts\Apps;

interface CEActivityRepositoryContract
{
    /**
     * Get application activities.
     *
     * @param int $app_id
     *
     * @return mixed
     */
    public function all(int $app_id);
}
