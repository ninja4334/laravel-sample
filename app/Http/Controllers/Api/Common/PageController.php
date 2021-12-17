<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Common\PageCreateRequest;
use App\Http\Requests\Common\PageUpdateRequest;
use App\Repositories\Contracts\PageRepositoryContract;
use Exception;

class PageController extends ApiController
{
    /**
     * @var PageRepositoryContract
     */
    protected $pageRepository;

    /**
     * @param PageRepositoryContract $pageRepository
     */
    public function __construct(PageRepositoryContract $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Get all pages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $pages = $this->pageRepository->paginate();

        return response()->json($pages);
    }

    /**
     * Get the page by id.
     *
     * @param int $page_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $page_id)
    {
        $page = $this->pageRepository->find($page_id);

        if (!$page) {
            return response()->jsonNotFound();
        }

        return response()->json($page);
    }

    /**
     * Create a new page.
     *
     * @param PageCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PageCreateRequest $request)
    {
        try {
            $result = $this->pageRepository->create($request->all());

            return response()->jsonSuccess(trans('events.created'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Update a page by id.
     *
     * @param int               $page_id
     * @param PageUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $page_id, PageUpdateRequest $request)
    {
        try {
            $result = $this->pageRepository->update($request->all(), $page_id);

            return response()->jsonSuccess(trans('events.updated'), $result);
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }

    /**
     * Delete a page by id.
     *
     * @param int $page_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $page_id)
    {
        $page = $this->pageRepository->find($page_id);

        if ($page->is_system) {
            return response()->jsonForbidden(trans('errors.permission_denied.delete_page'));
        }

        try {
            $this->pageRepository->delete($page_id);

            return response()->jsonSuccess(trans('events.deleted'));
        } catch (Exception $e) {
            return response()->jsonError($e);
        }
    }
}
