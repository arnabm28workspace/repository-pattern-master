<?php

namespace App\Services\Admin;

use App\Contracts\PageContract;
use App\Contracts\PageTypeContract;
use Illuminate\Support\Facades\Hash;
use Auth;

class PageService
{
    protected $pageRepository;

    protected $pageTypeRepository;
    
    /**
     * class PageService constructor
     */
    public function __construct(PageContract $pageRepository, PageTypeContract $pageTypeRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->pageTypeRepository = $pageTypeRepository;
    }

    /**
     * Fetch List of PageType
     * @return mixed
     */
    public function fetchPageTypes() {
        return $this->pageTypeRepository->listPageTypes();
    }

    /**
     * Fetch individual PageType
     * @param int $id
     * @return mixed
     */
    public function fetchPageTypeById($id) {
        return $this->pageTypeRepository->findPageTypeById($id);
    }

    /**
     * Save PageType information
     * @param int $id
     * @return mixed
     */
    public function createPageType($request) {
        $params = $request->except('_token');
        return $this->pageTypeRepository->createPageType($params);
    }

    /**
     * Update PageType info
     * @param Request $request
     * @return mixed
     */
    public function updatePageType($request) {
        $params = $request->except('_token');
        return $this->pageTypeRepository->updatePageType($params);
    }

    /**
     * Delete a PageType
     * @param int $id
     * @return mixed
     */
    public function deletePageType($id) {
        return $this->pageTypeRepository->deletePageType($id);
    }

    /**
     * Fetch List of Page
     * @return mixed
     */
    public function fetchPages() {
        return $this->pageRepository->listPages();
    }

    /**
     * Fetch individual Page
     * @param int $id
     * @return mixed
     */
    public function fetchPageById($id) {
        return $this->pageRepository->findPageById($id);
    }

    /**
     * Save Page information
     * @param int $id
     * @return mixed
     */
    public function createPage($request) {
        $params = $request->except('_token');
        return $this->pageRepository->createPage($params);
    }

    /**
     * Update Page info
     * @param Request $request
     * @return mixed
     */
    public function updatePage($request) {
        $params = $request->except('_token');
        return $this->pageRepository->updatePage($params);
    }

    /**
     * Delete a Page
     * @param int $id
     * @return mixed
     */
    public function deletePage($id) {
        return $this->pageRepository->deletePage($id);
    }

    /**
     * Update status of a package
     * @param int $id
     * @return mixed
     */
    public function updatePageStatus($id,$check_status){
        $params = array("id"=>$id,"check_status"=>$check_status);

        $page = $this->pageRepository->updatePageStatus($params);

        return $page;
    }
}