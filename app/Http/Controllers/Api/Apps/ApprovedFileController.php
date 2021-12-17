<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\ApprovedFileUploadRequest;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Services\MediaManager;
use Exception;

class ApprovedFileController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @param AppRepositoryContract   $appRepository
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
     * Get the approved files of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $files = $this->appRepository->getApprovedFiles($app_id);

        return response()->json(compact('files'));
    }

    /**
     * Upload an approved file to application.
     *
     * @param int                       $app_id
     * @param ApprovedFileUploadRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(int $app_id, ApprovedFileUploadRequest $request)
    {
        try {
            $file = $request->file('file');

            // Upload a file
            $media = MediaManager::upload($file, 'approved');

            // Attach a media file
            $this->appRepository->attachApprovedFile($media, $app_id);

            return response()->jsonSuccess(trans('events.uploaded'), $media);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Destroy an approved file of application.
     *
     * @param int $app_id
     * @param int $media_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id, int $media_id)
    {
        try {
            $this->appRepository->detachApprovedFile($media_id, $app_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
