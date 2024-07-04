<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\PageService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\LocationService;
use App\Http\Controllers\BaseController;

class PageController extends BaseController
{
    /**
     * @var PageService
     * @var CategoryService
     * @var LocationService
     */
    protected $pageService;
    protected $categoryService;
    protected $locationService;

    /**
     * PageController constructor.
     * @param PageService $pageService
     * @param CategoryService $categoryService
     * @param LocationService $locationService
     */
    public function __construct(PageService $pageService, CategoryService $categoryService, LocationService $locationService)
    {
        $this->pageService = $pageService;
        //$this->pagetypeRepository = $pagetypeRepository;
        $this->categoryService = $categoryService;
        $this->locationService = $locationService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = $this->pageService->fetchPages();

        $this->setPageTitle('Pages', '');
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $pagetypes = $this->pageService->fetchPageTypes();
        $categorytypes = $this->categoryService->fetchCategories();
        //$countries = $this->locationService->fetchLocations();
        $countries = $this->locationService->fetchCountryCity();
        $this->setPageTitle('Create Page', '');
        return view('admin.pages.create', compact('pagetypes','categorytypes','countries'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'title'     =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $page = $this->pageService->createPage($request);

        if (!$page) {
            return $this->responseRedirectBack('Error occurred while creating page.', 'error', true, true);
        }
        return $this->responseRedirect('admin.pages.index', 'Page added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetPage = $this->pageService->fetchPageById($id);
        $pagetypes = $this->pageService->fetchPageTypes();
        $categorytypes = $this->categoryService->fetchCategories();
        //$countries = $this->locationService->fetchLocations();
        $countries = $this->locationService->fetchCountryCity();

        $this->setPageTitle('Page: '.$targetPage->cms_title, '');
        return view('admin.pages.edit', compact('targetPage', 'pagetypes','categorytypes','countries'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $page = $this->pageService->updatePage($request);

        if (!$page) {
            return $this->responseRedirectBack('Error occurred while updating page.', 'error', true, true);
        }
        return $this->responseRedirectBack('Page updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $page = $this->pageService->deletePage($id);

        if (!$page) {
            return $this->responseRedirectBack('Error occurred while deleting page.', 'error', true, true);
        }
        return $this->responseRedirect('admin.pages.index', 'Page deleted successfully' ,'success',false, false);
    }

    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request){
        $page = $this->pageService->updatePageStatus($request->page_id,$request->check_status);

        if ($page) {
            return response()->json(array('message'=>'Page status successfully updated'));
        }
    }
}
