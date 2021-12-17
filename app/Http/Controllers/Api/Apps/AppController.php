<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Repositories\Criteria\AppSingleCriteria;

class AppController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @param AppRepositoryContract $appRepository
     */
    public function __construct(AppRepositoryContract $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    /**
     * Get an application by id.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $app_id)
    {
        $application = $this->appRepository
            ->pushCriteria(new AppSingleCriteria())
            ->active()
            ->find($app_id);

        if (!$application) {
            return response()->jsonNotFound();
        }

        return response()->json(compact('application'));
    }
}
