<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\BlogContract;
use App\Contracts\CategoryContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class BlogController extends BaseController
{
    /**
     * @var BlogContract
     * @var CategoryContract
     */
    protected $blogRepository;
    protected $categoryRepository;

    /**
     * PageController constructor.
     * @param BlogContract $blogRepository
     * @param CategoryContract $categoryRepository
     */
    public function __construct(BlogContract $blogRepository, CategoryContract $categoryRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $blogs = $this->blogRepository->listBlogs();

        $this->setPageTitle('Blogs', 'List of all blogs');
        return view('admin.blogs.index', compact('blogs'));
    }
    

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categorytypes = $this->categoryRepository->listCategories();
        $this->setPageTitle('Blogs', 'Create Blog');
        return view('admin.blogs.create',compact('categorytypes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $blog = $this->blogRepository->createBlog($params);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while creating blog.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogs.index', 'Blog added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetBlog = $this->blogRepository->findBlogById($id);
        $categorytypes = $this->categoryRepository->listCategories();
        
        $this->setPageTitle('Blogs', 'Edit Blog : '.$targetBlog->blog_title);
        return view('admin.blogs.edit', compact('targetBlog','categorytypes'));
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

        $params = $request->except('_token');

        $blog = $this->blogRepository->updateBlog($params);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while updating blog.', 'error', true, true);
        }
        return $this->responseRedirectBack('Blog updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $blog = $this->blogRepository->deleteBlog($id);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while deleting blog.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogs.index', 'Blog deleted successfully' ,'success',false, false);
    }
}
