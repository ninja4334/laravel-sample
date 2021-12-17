<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\RequirementCreateRequest;
use App\Http\Requests\Apps\RequirementUpdateRequest;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Repositories\Contracts\AppRequirementRepositoryContract;
use App\Repositories\Criteria\AppRequirementCriteria;
use Exception;

class RequirementController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @var AppRequirementRepositoryContract
     */
    protected $requirementRepository;

    /**
     * @param AppRepositoryContract            $appRepository
     * @param AppRequirementRepositoryContract $requirementRepository
     */
    public function __construct(
        AppRepositoryContract $appRepository,
        AppRequirementRepositoryContract $requirementRepository
    ) {
        $this->appRepository = $appRepository;
        $this->requirementRepository = $requirementRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Get the requirements by application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $params = compact('app_id');

        $requirements = $this->requirementRepository
            ->pushCriteria(new AppRequirementCriteria($params))
            ->all();

        return response()->json(compact('requirements'));
    }

    /**
     * Create a requirement.
     *
     * @param int                      $app_id
     * @param RequirementCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $app_id, RequirementCreateRequest $request)
    {
        try {
            $data = $request->all();
            $data['app_id'] = $app_id;

            $result = $this->requirementRepository->create($data);

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update a requirement.
     *
     * @param int                      $app_id
     * @param int                      $requirement_id
     * @param RequirementUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $app_id, int $requirement_id, RequirementUpdateRequest $request)
    {
        // Check an access
        $requirement = $this->requirementRepository->find($requirement_id);
        $this->authorize($requirement);

        $data = $request->all();

        try {
            $result = $this->requirementRepository->update($data, $requirement_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a requirement.
     *
     * @param int $app_id
     * @param int $requirement_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id, int $requirement_id)
    {
        // Check an access
        $requirement = $this->requirementRepository->find($requirement_id);
        $this->authorize($requirement);

        try {
            $this->requirementRepository->delete($requirement_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
