<?php

namespace App\Http\Controllers\Api\Boards;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Boards\AppStatusCreateRequest;
use App\Http\Requests\Boards\AppStatusUpdateRequest;
use App\Repositories\Contracts\AppStatusRepositoryContract;
use App\Repositories\Contracts\BoardRepositoryContract;
use App\Repositories\Criteria\AppStatusCriteria;
use Exception;

class AppStatusController extends ApiController
{
    /**
     * @var BoardRepositoryContract
     */
    protected $boardRepository;

    /**
     * @var AppStatusRepositoryContract
     */
    protected $statusRepository;

    /**
     * @param AppStatusRepositoryContract $statusRepository
     * @param BoardRepositoryContract     $boardRepository
     */
    public function __construct(
        AppStatusRepositoryContract $statusRepository,
        BoardRepositoryContract $boardRepository
    ) {
        $this->statusRepository = $statusRepository;
        $this->boardRepository = $boardRepository;

        // Check an access to board
        $this->middleware(function ($request, $next) {
            $board_id = $request->route('board_id');
            $board = $this->boardRepository->find($board_id);

            $this->authorize('access', $board);

            return $next($request);
        });
    }

    /**
     * Get all statuses by board.
     *
     * @param int $board_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $board_id)
    {
        $statuses = $this->statusRepository
            ->pushCriteria(new AppStatusCriteria($board_id))
            ->all();

        return response()->json(compact('statuses'));
    }

    /**
     * Create a new status.
     *
     * @param int                    $board_id
     * @param AppStatusCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $board_id, AppStatusCreateRequest $request)
    {
        try {
            $request->merge(compact('board_id'));

            $result = $this->statusRepository->create($request->all());

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update a status by id.
     *
     * @param int                    $board_id
     * @param int                    $status_id
     * @param AppStatusUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $board_id, int $status_id, AppStatusUpdateRequest $request)
    {
        // Check an access
        $status = $this->statusRepository->find($status_id);
        $this->authorize($status);

        try {
            $result = $this->statusRepository->update($request->all(), $status_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a status by id.
     *
     * @param int $board_id
     * @param int $status_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $board_id, int $status_id)
    {
        // Check an access
        $status = $this->statusRepository->find($status_id);
        $this->authorize($status);

        try {
            $this->statusRepository->delete($status_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
