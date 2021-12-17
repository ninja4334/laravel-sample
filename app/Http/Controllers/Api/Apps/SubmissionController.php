<?php
namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Repositories\Contracts\SubmissionRepositoryContract;
use App\Repositories\Criteria\LatestCriteria;
use App\Repositories\Criteria\SubmissionCriteria;
use Exception;

class SubmissionController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @var SubmissionRepositoryContract
     */
    protected $submissionRepository;

    /**
     * @var \Illuminate\Database\Eloquent\Model|null|static
     */
    protected $app;

    /**
     * @param AppRepositoryContract        $appRepository
     * @param SubmissionRepositoryContract $submissionRepository
     */
    public function __construct(
        AppRepositoryContract $appRepository,
        SubmissionRepositoryContract $submissionRepository
    ) {
        $this->appRepository = $appRepository;
        $this->submissionRepository = $submissionRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $this->app = $this->appRepository->active()->find($app_id);

            $this->authorize('access', $this->app);

            return $next($request);
        });
    }

    /**
     * Create a submission.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $app_id)
    {
        $board = $this->app->board;

        if (!$board->is_chargeable) {
            return response()->jsonForbidden('unverified_board');
        }



        // Collect the data
        $attributes = [
            'board_id' => $this->app->board_id,
            'app_id'   => $app_id,
            'user_id'  => auth()->id()
        ];

        try {
            // Find a user's last submission by application.
            $lastSubmission = $this->submissionRepository
                ->pushCriteria(new SubmissionCriteria($attributes))
                ->pushCriteria(new LatestCriteria())
                ->first();

            // Check an access to create a submission
            if ($lastSubmission && !$lastSubmission->is_lapsed) {
                return response()->jsonForbidden('you_have_already_application');
            }

            // Create a submission
            $result = $this->submissionRepository->create($attributes);

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
