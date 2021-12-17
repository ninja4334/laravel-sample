<?php

namespace App\Http\Controllers\Api\Boards;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Mail\PasswordResetLink;
use App\Repositories\Contracts\BoardRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Exception;
use Illuminate\Support\Facades\Password;
use Mail;

class PasswordController extends ApiController
{
    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @param UserRepositoryContract  $userRepository
     * @param BoardRepositoryContract $boardRepository
     */
    public function __construct(
        UserRepositoryContract $userRepository,
        BoardRepositoryContract $boardRepository
    ) {
        $this->userRepository = $userRepository;
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
     * Send a reset link to the given user.
     *
     * @param int $board_id
     * @param int $user_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(int $board_id, int $user_id)
    {
        try {
            // Find a user
            $user = $this->userRepository
                ->active()
                ->find($user_id);

            if (!$user) {
                return response()->jsonError('invalid_credentials', 401);
            }

            // Create a token
            $token = Password::createToken($user);

            // Generate a password reset link
            $link = 'auth/password/confirm?token=' . $token . '&email=' . $user->email;
            $link = url($link);

            // Send an email with a link for resetting password
            Mail::queue(new PasswordResetLink($user, $token, $link));

            return response()->jsonSuccess(trans('passwords.sent'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
