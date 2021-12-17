<?php

namespace App\Repositories\Contracts;

use Freevital\Repository\Contracts\RepositoryContract;

interface SettingsRepositoryContract extends RepositoryContract
{
    /**
     * Update all entities by key.
     *
     * @param array  $data
     * @param string $keyColumn
     *
     * @return mixed
     */
    public function updateAllByKey(array $data, string $keyColumn);
}
