<?php

namespace App\Services\Admin;

use App\Contracts\CategoryContract;
use Illuminate\Support\Facades\Hash;
use Auth;

class CategoryService
{
    protected $categoryRepository;
    
    /**
     * class CategoryService constructor
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Fetch List of Packages
     * @return mixed
     */
    public function fetchCategories() {
        return $this->categoryRepository->listCategories();
    }

    public function treeList() {
        return $this->categoryRepository->treeList();
    }

    /**
     * Fetch individual package
     * @param int $id
     * @return mixed
     */
    public function fetchCategoryById($id) {
        return $this->categoryRepository->findCategoryById($id);
    }

    /**
     * Save Package information
     * @param int $id
     * @return mixed
     */
    public function createCategory($request) {
        $params = $request->except('_token');
        return $this->categoryRepository->createCategory($params);
    }

    /**
     * Update Package info
     * @param Request $request
     * @return mixed
     */
    public function updateCategory($request) {
        $params = $request->except('_token');
        return $this->categoryRepository->updateCategory($params);
    }

    /**
     * Delete a package
     * @param int $id
     * @return mixed
     */
    public function deleteCategory($id) {
        return $this->categoryRepository->deleteCategory($id);
    }

    /**
     * Update status of a package
     * @param int $id
     * @return mixed
     */
    public function updateCategoryStatus($id,$check_status){
        $params = array("id"=>$id,"check_status"=>$check_status);

        $category = $this->categoryRepository->updateCategoryStatus($params);

        return $category;
    }
}