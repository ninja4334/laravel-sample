<?php

namespace App\Http\Controllers\Api\Boards;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Boards\AppTypeCreateRequest;
use App\Http\Requests\Boards\AppTypeUpdateRequest;
use App\Repositories\Contracts\AppTypeRepositoryContract;
use App\Repositories\Contracts\BoardRepositoryContract;
use App\Repositories\Criteria\ByBoardIdCriteria;
use Exception;

class AppTypeController extends ApiController
{
    /**
     * @var BoardRepositoryContract
     */
    protected $boardRepository;

    /**
     * @var AppTypeRepositoryContract
     */
    protected $typeRepository;

    /**
     * @param AppTypeRepositoryContract $typeRepository
     * @param BoardRepositoryContract   $boardRepository
     */
    public function __construct(
        AppTypeRepositoryContract $typeRepository,
        BoardRepositoryContract $boardRepository
    ) {
        $this->typeRepository = $typeRepository;
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
     * Get all application types by board.
     *
     * @param int $board_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $board_id)
    {
        $types = $this->typeRepository
            ->pushCriteria(new ByBoardIdCriteria($board_id))
            ->all();

        return response()->json(compact('types'));
    }

    /**
     * Create a new application type.
     *
     * @param int                  $board_id
     * @param AppTypeCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $board_id, AppTypeCreateRequest $request)
    {
        try {
            $request->merge(compact('board_id'));

            $result = $this->typeRepository->create($request->all());

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update an application type by id.
     *
     * @param int                  $board_id
     * @param int                  $type_id
     * @param AppTypeUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $board_id, int $type_id, AppTypeUpdateRequest $request)
    {
        // Check an access
        $type = $this->typeRepository->find($type_id);
        $this->authorize($type);

        try {
            $result = $this->typeRepository->update($request->all(), $type_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete an application type by id.
     *
     * @param int $board_id
     * @param int $type_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $board_id, int $type_id)
    {
        // Check an access
        $type = $this->typeRepository->find($type_id);
        $this->authorize($type);

        try {
            $this->typeRepository->delete($type_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
