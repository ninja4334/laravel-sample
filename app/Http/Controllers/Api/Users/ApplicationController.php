<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Models\Submission;

class ApplicationController extends ApiController
{
    /**
     * Check an access.
     */
    public function __construct() {
        $this->middleware([
            'jwt.auth',
            'role:member'
        ]);
    }

    /**
     * Delete a user application.
     *
     * @param int $app_id
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $app_id)
    {
        $app = Submission::where('id', $app_id)
            ->whereNull('status_id')
            ->first();

        if (!$app) {
            return response()->jsonNotFound();
        }

        $this->authorize('owner', $app);

        $app->delete();

        return response()->jsonSuccess(trans('events.deleted'));
    }
}
