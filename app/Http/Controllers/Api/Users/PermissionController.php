<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Repositories\Contracts\PermissionRepositoryContract;
use App\Repositories\Criteria\BySystemCriteria;

class PermissionController extends ApiController
{
    /**
     * @var PermissionRepositoryContract
     */
    protected $permissionRepository;

    /**
     * @param PermissionRepositoryContract $permissionRepository
     */
    public function __construct(PermissionRepositoryContract $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get all permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = $this->permissionRepository
            ->system(false)
            ->all();

        return response()->json(compact('permissions'));
    }
}
