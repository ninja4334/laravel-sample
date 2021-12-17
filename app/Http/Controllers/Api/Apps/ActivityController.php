<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\ActivitySaveRequest;
use App\Repositories\Contracts\AppActivityRepositoryContract;
use App\Repositories\Contracts\AppRepositoryContract;
use Exception;

class ActivityController extends ApiController
{
    /**
     * @var AppActivityRepositoryContract
     */
    protected $activityRepository;

    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @param AppActivityRepositoryContract $activityRepository
     * @param AppRepositoryContract         $appRepository
     */
    public function __construct(
        AppActivityRepositoryContract $activityRepository,
        AppRepositoryContract $appRepository
    ) {
        $this->activityRepository = $activityRepository;
        $this->appRepository = $appRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Get an activity of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $activity = $this->activityRepository->find($app_id);

        if (!$activity) {
            return response()->jsonNotFound();
        }

        return response()->json(compact('activity'));
    }

    /**
     * Save an activity of application.
     *
     * @param int                 $app_id
     * @param ActivitySaveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(int $app_id, ActivitySaveRequest $request)
    {
        try {
            // Collect data for creating an activity
            $attributes = compact('app_id');

            $request->merge($attributes);

            // Save an activity
            $result = $this->activityRepository
                ->updateOrCreate($attributes, $request->all());

            return response()->jsonSuccess(trans('events.saved'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete an activity by application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id)
    {
        try {
            $this->activityRepository->delete($app_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
