<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Apps\DocumentCreateRequest;
use App\Http\Requests\Apps\DocumentUpdateRequest;
use App\Models\Media;
use App\Repositories\Contracts\AppDocumentRepositoryContract;
use App\Repositories\Contracts\AppRepositoryContract;
use App\Repositories\Criteria\AppDocumentCriteria;
use App\Services\PDForm\PDForm;
use Exception;

class DocumentController extends ApiController
{
    /**
     * @var AppRepositoryContract
     */
    protected $appRepository;

    /**
     * @var AppDocumentRepositoryContract
     */
    protected $documentRepository;

    /**
     * @param AppRepositoryContract         $appRepository
     * @param AppDocumentRepositoryContract $documentRepository
     */
    public function __construct(
        AppRepositoryContract $appRepository,
        AppDocumentRepositoryContract $documentRepository
    ) {
        $this->appRepository = $appRepository;
        $this->documentRepository = $documentRepository;

        // Check an access to application's board
        $this->middleware(function ($request, $next) {
            $app_id = $request->route('app_id');
            $app = $this->appRepository->find($app_id);

            $this->authorize('access', $app);

            return $next($request);
        });
    }

    /**
     * Get the documents of application.
     *
     * @param int $app_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $app_id)
    {
        $params = compact('app_id');

        $documents = $this->documentRepository
            ->pushCriteria(new AppDocumentCriteria($params))
            ->all();

        return response()->json(compact('documents'));
    }

    /**
     * Create a document.
     *
     * @param int                   $app_id
     * @param DocumentCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $app_id, DocumentCreateRequest $request)
    {
        try {
            // Collect data
            $attributes = $request->all();
            $attributes['app_id'] = $app_id;

            // If type is "eSignature", parse pdf file and get the fields from it
            if ($request->input('type') == 'signature') {
                $media = Media::find(array_get($attributes, 'media_id'));
                $pdForm = new PDForm($media->getAbsolutePath());
                $fields = $pdForm->parse();
                array_set($attributes, 'metadata.fields', $fields);
            }

            // Create a document
            $result = $this->documentRepository->create($attributes);

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update a document.
     *
     * @param int                   $app_id
     * @param int                   $document_id
     * @param DocumentUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $app_id, int $document_id, DocumentUpdateRequest $request)
    {
        // Check an access
        $document = $this->documentRepository->find($document_id);
        $this->authorize($document);

        try {
            // Collect data
            $attributes = $request->all();

            // If type is "eSignature", parse pdf file and get the fields from it
            if ($request->input('type') == 'signature') {
                $media = Media::find(array_get($attributes, 'media_id'));
                $pdForm = new PDForm($media->getAbsolutePath());
                $fields = $pdForm->parse();
                array_set($attributes, 'metadata.fields', $fields);
            }

            // Update a document
            $result = $this->documentRepository->update($attributes, $document_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a document.
     *
     * @param int $app_id
     * @param int $document_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $app_id, int $document_id)
    {
        // Check an access
        $document = $this->documentRepository->find($document_id);
        $this->authorize($document);

        try {
            $this->documentRepository->delete($document_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
