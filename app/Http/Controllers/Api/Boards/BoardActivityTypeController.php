<?php

namespace App\Http\Controllers\Api\Boards;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Boards\BoardActivityTypeCreateRequest;
use App\Http\Requests\Boards\BoardActivityTypeUpdateRequest;
use App\Models\BoardActivityType;
use App\Repositories\Contracts\BoardRepositoryContract;
use Response;

class BoardActivityTypeController extends ApiController
{
    /**
     * @var BoardRepositoryContract
     */
    protected $boardRepository;

    /**
     * @param BoardRepositoryContract $boardRepository
     */
    public function __construct(BoardRepositoryContract $boardRepository)
    {
        $this->boardRepository = $boardRepository;

        // Check an access to board and application type
        $this->middleware(function ($request, $next) {

            // Check an access to board
            $board_id = $request->route('board_id');
            $board = $this->boardRepository->find($board_id);

            $this->authorize('access', $board);

            return $next($request);
        });
    }

    /**
     * Get the board activity types.
     *
     * @param int $board_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $board_id)
    {
        $activityTypes = BoardActivityType::query()
            ->where('board_id', $board_id)
            ->get();

        return response()->json($activityTypes);
    }

    /**
     * Create board activity type.
     *
     * @param int $board_id
     * @param BoardActivityTypeCreateRequest $request
     *
     * @return mixed
     */
    public function store(int $board_id, BoardActivityTypeCreateRequest $request)
    {
        $model = new BoardActivityType();
        $model->fill($request->all());
        $model->board_id = $board_id;
        $model->save();

        return Response::json($model);
    }

    /**
     * Update board activity type.
     *
     * @param int $board_id
     * @param int $type_id
     * @param BoardActivityTypeUpdateRequest $request
     *
     * @return mixed
     */
    public function update(int $board_id, int $type_id, BoardActivityTypeUpdateRequest $request)
    {
        $model = BoardActivityType::find($type_id);

        if (!$model) {
            return Response::jsonNotFound();
        }

        $model->fill($request->all());
        $model->save();

        return Response::json($model);
    }

    /**
     * Delete board activity type.
     *
     * @param int $board_id
     * @param int $type_id
     *
     * @return mixed
     */
    public function destroy(int $board_id, int $type_id)
    {
        $model = BoardActivityType::find($type_id);

        if (!$model) {
            return Response::jsonNotFound();
        }

        $model->delete();

        return Response::jsonSuccess(trans('events.deleted'));
    }
}
