<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Criteria\UserCriteria;
use Exception;

class UserController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @param AppRepositoryContract  $appRepository
     * @param UserRepositoryContract $userRepository
     */
    public function __construct(
        AppRepositoryContract $appRepository,
        UserRepositoryContract $userRepository
    ) {
        $this->appRepository = $appRepository;
        $this->userRepository = $userRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Get the reviewers of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $params = [
            'app_id' => $app_id,
            'role'   => 'reviewer'
        ];

        $users = $this->userRepository
            ->pushCriteria(new UserCriteria($params))
            ->active()
            ->all();

        return response()->json(compact('users'));
    }

    /**
     * Attach a reviewer to an application.
     *
     * @param int $app_id
     * @param int $user_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach(int $app_id, int $user_id)
    {
        try {
            $this->appRepository->attachUser($user_id, $app_id);

            return response()->jsonSuccess(trans('events.attached'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Detach a reviewer from an application.
     *
     * @param int $application_id
     * @param int $user_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detach(int $application_id, int $user_id)
    {
        try {
            $this->appRepository->detachUser($user_id, $application_id);

            return response()->jsonSuccess(trans('events.detached'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
