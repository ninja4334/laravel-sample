<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\ChecklistCreateRequest;
use App\Http\Requests\Apps\ChecklistUpdateRequest;
use App\Repositories\Contracts\AppChecklistRepositoryContract;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Repositories\Criteria\AppChecklistCriteria;
use Exception;

class ChecklistController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @var AppChecklistRepositoryContract
     */
    protected $checklistRepository;

    /**
     * @param AppRepositoryContract          $appRepository
     * @param AppChecklistRepositoryContract $checklistRepository
     */
    public function __construct(
        AppRepositoryContract $appRepository,
        AppChecklistRepositoryContract $checklistRepository
    ) {
        $this->appRepository = $appRepository;
        $this->checklistRepository = $checklistRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Get the checklist of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $params = compact('app_id');

        $checklist = $this->checklistRepository
            ->pushCriteria(new AppChecklistCriteria($params))
            ->all();

        return response()->json(compact('checklist'));
    }

    /**
     * Create a checklist item.
     *
     * @param int                    $app_id
     * @param ChecklistCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $app_id, ChecklistCreateRequest $request)
    {
        try {
            $data = $request->all();
            $data['app_id'] = $app_id;

            $result = $this->checklistRepository->create($data);

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update a checklist item.
     *
     * @param int                    $app_id
     * @param int                    $checklist_id
     * @param ChecklistUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $app_id, int $checklist_id, ChecklistUpdateRequest $request)
    {
        // Check an access
        $checklist = $this->checklistRepository->find($checklist_id);
        $this->authorize($checklist);

        try {
            $data = $request->all();

            $result = $this->checklistRepository->update($data, $checklist_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a checklist item.
     *
     * @param int $app_id
     * @param int $checklist_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id, int $checklist_id)
    {
        // Check an access
        $checklist = $this->checklistRepository->find($checklist_id);
        $this->authorize($checklist);

        try {
            $this->checklistRepository->delete($checklist_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
