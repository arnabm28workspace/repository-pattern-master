<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\PageService;
use App\Http\Controllers\BaseController;

class PageTypeController extends BaseController
{
    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * PageTypeController constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pagetypes = $this->pageService->fetchPageTypes();

        $this->setPageTitle('Page Types', 'List of all page types');
        return view('admin.pagetypes.index', compact('pagetypes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Page Types', 'Create Page Type');
        return view('admin.pagetypes.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191'
        ]);

        $pagetype = $this->pageService->createPageType($request);

        if (!$pagetype) {
            return $this->responseRedirectBack('Error occurred while creating page type.', 'error', true, true);
        }
        return $this->responseRedirect('admin.pagetypes.index', 'Page added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetPageType = $this->pageService->fetchPageTypeById($id);
        
        $this->setPageTitle('Page Types', 'Edit Page Type : '.$targetPageType->name);
        return view('admin.pagetypes.edit', compact('targetPageType'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191'
        ]);

        $pagetype = $this->pageService->updatePageType($request);

        if (!$pagetype) {
            return $this->responseRedirectBack('Error occurred while updating page type.', 'error', true, true);
        }
        return $this->responseRedirectBack('Page Type updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $pagetype = $this->pageService->deletePageType($id);

        if (!$pagetype) {
            return $this->responseRedirectBack('Error occurred while deleting page type.', 'error', true, true);
        }
        return $this->responseRedirect('admin.pagetypes.index', 'Page Type deleted successfully' ,'success',false, false);
    }
}
