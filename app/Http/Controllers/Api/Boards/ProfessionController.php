<?php

namespace App\Http\Controllers\Api\Boards;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Boards\ProfessionCreateRequest;
use App\Http\Requests\Boards\ProfessionUpdateRequest;
use App\Repositories\Contracts\BoardProfessionRepositoryContract;
use App\Repositories\Contracts\BoardRepositoryContract;
use App\Repositories\Criteria\ByBoardIdCriteria;
use Exception;

class ProfessionController extends ApiController
{
    /**
     * @var BoardRepositoryContract
     */
    protected $boardRepository;

    /**
     * @var BoardProfessionRepositoryContract
     */
    protected $professionRepository;

    /**
     * @param BoardProfessionRepositoryContract $professionRepository
     * @param BoardRepositoryContract           $boardRepository
     */
    public function __construct(
        BoardProfessionRepositoryContract $professionRepository,
        BoardRepositoryContract $boardRepository
    ) {
        $this->professionRepository = $professionRepository;
        $this->boardRepository = $boardRepository;

        // Check an access to board
        $this->middleware(function ($request, $next) {
            $board_id = $request->route('board_id');
            $board = $this->boardRepository->find($board_id);

            $this->authorize('access', $board);

            return $next($request);
        })->except('index');
    }

    /**
     * Get the board profession list.
     *
     * @param int $board_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $board_id)
    {
        $professions = $this->professionRepository
            ->pushCriteria(new ByBoardIdCriteria($board_id))
            ->all();

        return response()->json(compact('professions'));
    }

    /**
     * Create a new profession.
     *
     * @param int                     $board_id
     * @param ProfessionCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(int $board_id, ProfessionCreateRequest $request)
    {
        try {
            $request->merge(compact('board_id'));

            $result = $this->professionRepository->create($request->all());

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update a profession by id.
     *
     * @param int                     $board_id
     * @param int                     $profession_id
     * @param ProfessionUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $board_id, int $profession_id, ProfessionUpdateRequest $request)
    {
        // Check an access
        $profession = $this->professionRepository->find($profession_id);
        $this->authorize($profession);

        try {
            $result = $this->professionRepository->update($request->all(), $profession_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a profession by id.
     *
     * @param int $board_id
     * @param int $profession_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $board_id, int $profession_id)
    {
        // Check an access
        $profession = $this->professionRepository->find($profession_id);
        $this->authorize($profession);

        try {
            $this->professionRepository->delete($profession_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
