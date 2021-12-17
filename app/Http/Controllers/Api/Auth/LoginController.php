<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Criteria\ByEmailCriteria;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends ApiController
{
    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @param UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // Collect the credentials
        $credentials = $request->only('email', 'password');

        try {
            $user = $this->userRepository
                ->pushCriteria(new ByEmailCriteria($credentials['email']))
                ->first();

            $token = JWTAuth::attempt($credentials);

            // Check if user exists
            if (!$token) {
                return response()->jsonError(trans('errors.credentials_not_match'), 401);
            }

            // Check if user is active
            if (!$user->is_active) {
                return response()->jsonForbidden('auth.unverified_account');
            }

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->jsonError('could_not_create_token', 500);
        }
    }

    /**
     * Handle a login request to the application by referrer id from jwt token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginByReferrer()
    {
        $referrer_id = JWTAuth::parseToken()->getPayload()->get('referrer_id');

        return $this->loginById($referrer_id);
    }

    /**
     * Handle a login request to the application by user id.
     * TODO: need the policy
     *
     * @param int $user_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginById(int $user_id)
    {
        try {
            $authUser = JWTAuth::parseToken()->authenticate();

            $user = $this->userRepository->find($user_id);

            if (!$token = JWTAuth::fromUser($user, ['referrer_id' => $authUser->id])) {
                return response()->jsonError(trans('credentials_not_match'), 401);
            }
        } catch (JWTException $e) {
            return response()->jsonError('could_not_create_token', 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * Get an authenticate user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->jsonNotFound('user_not_found');
            }
        } catch (TokenExpiredException $e) {
            return response()->jsonError('token_expired', $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->jsonError('token_invalid', $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->jsonError('token_absent', $e->getStatusCode());
        }

        $user->load('roles', 'boards');
        $user->append('role', 'perms');

        return response()->json(compact('user'));
    }
}
