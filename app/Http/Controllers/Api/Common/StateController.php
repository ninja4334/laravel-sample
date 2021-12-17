<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\ApiController;
use App\Repositories\Contracts\StateRepositoryContract;

class StateController extends ApiController
{
    /**
     * @var StateRepositoryContract
     */
    protected $stateRepository;

    /**
     * @param StateRepositoryContract $stateRepository
     */
    public function __construct(StateRepositoryContract $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * Get all states.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $states = $this->stateRepository->all();

        return response()->json(compact('states'));
    }
}
