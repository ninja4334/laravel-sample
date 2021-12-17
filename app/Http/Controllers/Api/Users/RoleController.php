<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Repositories\Contracts\RoleRepositoryContract;
use App\Repositories\Criteria\RoleCriteria;

class RoleController extends ApiController
{
    /**
     * @var RoleRepositoryContract
     */
    protected $roleRepository;

    /**
     * @param RoleRepositoryContract $roleRepository
     */
    public function __construct(RoleRepositoryContract $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get all custom roles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $params = [
            'without_member'      => true,
            'without_system_role' => true
        ];

        $roles = $this->roleRepository
            ->pushCriteria(new RoleCriteria($params))
            ->all();

        return response()->json(compact('roles'));
    }
}
