<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Common\NotifyRequest;
use App\Mail\BoardNeeds;
use Mail;

class NotifyController extends ApiController
{
    /**
     * Email admin when a user needed application of his state.
     *
     * @param NotifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(NotifyRequest $request)
    {
        $data = $request->all();

        Mail::queue(new BoardNeeds($data));

        return response()->jsonSuccess(trans('events.sent'));
    }
}
