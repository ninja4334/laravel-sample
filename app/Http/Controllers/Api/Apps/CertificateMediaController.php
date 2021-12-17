<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\CertificateMediaUploadRequest;
use App\Repositories\Contracts\AppCertificateRepositoryContract;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Services\MediaManager;
use Exception;

class CertificateMediaController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @var AppCertificateRepositoryContract
     */
    protected $certificateRepository;

    /**
     * @param AppRepositoryContract            $appRepository
     * @param AppCertificateRepositoryContract $certificateRepository
     */
    public function __construct(
        AppRepositoryContract $appRepository,
        AppCertificateRepositoryContract $certificateRepository
    ) {
        $this->appRepository = $appRepository;
        $this->certificateRepository = $certificateRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Upload an image to certificate.
     *
     * @param int                           $app_id
     * @param CertificateMediaUploadRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(int $app_id, CertificateMediaUploadRequest $request)
    {
        try {
            $file = $request->file('file');

            $media = MediaManager::upload($file, 'certificate');

            return response()->jsonSuccess(trans('events.uploaded'), $media);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete an image of certificate.
     *
     * @param int $app_id
     * @param int $media_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id, int $media_id)
    {
        if ($this->certificateRepository->detachCertificateFile($media_id, $app_id)) {
            return response()->jsonSuccess(trans('events.deleted'));
        }

        return response()->jsonError();
    }
}
