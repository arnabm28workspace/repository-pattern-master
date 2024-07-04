<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\CategoryService;
use App\Http\Controllers\BaseController;

class CategoryController extends BaseController
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryContract $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $info = $this->categoryService->fetchCategories();
        $categories = $this->categoryService->treeList();
        $categories_info = collect();
        foreach ($categories as $key => $category) {
            
            $d = $info->filter(function($value) use($key) { 
                    return $value->id == $key;
                })->first();
            $categories_info->push(['name'=>$category, 'info'=>$d]);
        }

        $this->setPageTitle('Categories', '');
        return view('admin.categories.index', compact('categories_info'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$categories = $this->categoryService->listCategories('id', 'asc');
        $categories = $this->categoryService->treeList();
        $this->setPageTitle('Create Category', '');
        return view('admin.categories.create', compact('categories'));
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
            //'parent_id' =>  'nullable|different:id',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $category = $this->categoryService->createCategory($request);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.categories.index', 'Category added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCategory = $this->categoryService->fetchCategoryById($id);
        //$categories = $this->categoryService->listCategories();
        $categories = $this->categoryService->treeList();
        
        $this->setPageTitle('Category: '.$targetCategory->name, 'Edit Category');
        return view('admin.categories.edit', compact('categories', 'targetCategory'));
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
            'parent_id' =>  'nullable|different:id',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $category = $this->categoryService->updateCategory($request);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating category.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->categoryService->deleteCategory($id);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.categories.index', 'Category deleted successfully' ,'success',false, false);
    }

    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request){
        $category = $this->categoryService->updateCategoryStatus($request->category_id,$request->check_status);

        if ($category) {
            return response()->json(array('message'=>'Category status successfully updated'));
        }
    }
}
