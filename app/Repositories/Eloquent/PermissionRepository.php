<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Permission::class;
    }
}
