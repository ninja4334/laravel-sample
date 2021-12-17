<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\CertificateSaveRequest;
use App\Repositories\Contracts\AppCertificateRepositoryContract;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Services\MediaManager;
use Exception;
use SnappyPdf;

class CertificateController extends ApiController
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
     * @param AppCertificateRepositoryContract $certificateRepository
     * @param AppRepositoryContract            $appRepository
     */
    public function __construct(
        AppCertificateRepositoryContract $certificateRepository,
        AppRepositoryContract $appRepository
    ) {
        $this->certificateRepository = $certificateRepository;
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
     * Get a certificate of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $certificate = $this->certificateRepository->find($app_id);

        if (!$certificate) {
            return response()->jsonNotFound();
        }

        return response()->json(compact('certificate'));
    }

    /**
     * Save a certificate of application.
     *
     * @param int                    $app_id
     * @param CertificateSaveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(int $app_id, CertificateSaveRequest $request)
    {
        try {
            $data = $request->all();
            $data['app_id'] = $app_id;

            // Save a certificate
            $certificate = $this->certificateRepository
                ->updateOrCreate(compact('app_id'), $data);

            // Generate a certificate file
            $path = sys_get_temp_dir() . '/' . str_random() . '.pdf';
            SnappyPdf::loadView('pdf.certificate', compact('certificate'))
                ->setPaper('a4')
                ->setOptions([
                    'margin-top'    => 0,
                    'margin-left'   => 0,
                    'margin-bottom' => 0,
                    'margin-right'  => 0,
                    'dpi'           => 300
                ])
                ->save($path);

            // Upload a certificate file
            $certificateMedia = MediaManager::upload($path, 'certificate');

            // Collect the data for creating certificate entity
            $data = ['certificate_file_id' => $certificateMedia->id];

            // Save a certificate with file
            $result = $this->certificateRepository
                ->updateOrCreate(compact('app_id'), $data);

            return response()->jsonSuccess(trans('events.saved'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a certificate by application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id)
    {
        if ($this->certificateRepository->delete($app_id)) {
            return response()->jsonSuccess(trans('events.deleted'));
        }

        return response()->jsonError();
    }
}
