<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\RequiredFileUploadRequest;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Services\MediaManager;
use Exception;

class RequiredFileController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @param AppRepositoryContract $appRepository
     */
    public function __construct(AppRepositoryContract $appRepository)
    {
        $this->appRepository = $appRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Get the required files of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $files = $this->appRepository->getRequiredFiles($app_id);

        return response()->json(compact('files'));
    }

    /**
     * Upload a required file to application.
     *
     * @param int                       $app_id
     * @param RequiredFileUploadRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(int $app_id, RequiredFileUploadRequest $request)
    {
        try {
            $file = $request->file('file');

            // Upload a file
            $media = MediaManager::upload($file, 'required');

            // Attach a media file
            $this->appRepository->attachRequiredFile($media, $app_id);

            return response()->jsonSuccess(trans('events.uploaded'), $media);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Destroy a required file of application.
     *
     * @param int $app_id
     * @param int $file_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id, int $file_id)
    {
        try {
            $this->appRepository->detachRequiredFile($file_id, $app_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
