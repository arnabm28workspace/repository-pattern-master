<?php
namespace App\Repositories;

use App\Models\Page;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PageContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class PageRepository
 *
 * @package \App\Repositories
 */
class PageRepository extends BaseRepository implements PageContract
{
    use UploadAble;

    /**
     * PageRepository constructor.
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPages(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPageById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPageBySlug($slug)
    {
        return $this->model::where([
                                ['cms_slug','=',$slug],
                                ['status','=',1],
                                ['page_type', '=', 'Top Level']
                                ])->first();
    }

    public function findPageByCountry($slug) {
        return $this->model::where([
            ['country', $slug],
            ['page_type', 'Location']
            ])
            ->whereNull('city')
            ->whereNull('category')
            ->first();
    }

    public function findPage($params) {
        
        /* $query = $this->model::where([
            ['country', $params['country']],
            ['page_type', 'Location']
            ]); */
        $query = $this->model->where([
            ['status', true]
            ]);
        
        if($params->has('category') && !is_null($params['category'])){
            $query->where('page_type', 'Categories');
        } else{
            $query->where('page_type', 'Location');
        }

        if ($params->has('country') && !is_null($params['country'])) {
            $query->where('country', $params['country']);
            
            if(is_null($params['city']) && is_null($params['category'])){
                $query->where('city', null)->where('category', null);
            }
        }
        if ($params->has('city') && !is_null($params['city'])) {

            $query->Where(function ($query) use ($params){
                $query->where('city', $params['city']);
            });
            
            if(is_null($params['category'])){
                $query->where('category', null);
            }
        }
        if ($params->has('category') && !is_null($params['category'])) {
            $query->Where(function ($query) use ($params){
                $query->where('category', $params['category']);
            });
        }
        return $query->first();
    }

    /**
     * @param array $params
     * @return Page|mixed
     */
    public function createPage(array $params)
    {
        try {
            $collection = collect($params);
            $image = null;
            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'pages');
            }
            //Slug Name by title
            $slug_name = str_slug($collection['title']);
            $page = $this->model;
            $page->cms_name = $collection['name'];
            $page->cms_title = $collection['title'];
            $page->cms_slug = $slug_name;
            $page->cms_description = $collection['description'];
            $page->meta_title = $collection['meta_title'];
            $page->meta_keyword = $collection['meta_keyword'];
            $page->meta_description = $collection['meta_description'];
            $page->page_type = $collection['page_type'];
            if ($collection['page_type'] != "Top Level"){
                $page->category = (empty($collection['category_type']) || $collection['page_type'] != 'Categories')?null:$collection['category_type'];
                $page->country = (empty($collection['country']))?null:$collection['country'];
                $page->city = (empty($collection['city']))?null:$collection['city'];
            }
            $page->image = $image;
            $page->status = $collection->has('status') ? true : false;
            $page->save();

            return $page;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePage(array $params)
    {
        $page = $this->findPageById($params['id']);
        $collection = collect($params)->except('_token');
        $image = $page->image;
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($page->image != null) {
                $this->deleteOne($page->image);
            }

            $image = $this->uploadOne($params['image'], 'pages');
        }
        $slug_name = str_slug($collection['title']);
        $page->cms_name = $collection['name'];
        $page->cms_title = $collection['title'];
        $page->cms_slug = $slug_name;
        $page->cms_description = $collection['description'];
        $page->meta_title = $collection['meta_title'];
        $page->meta_keyword = $collection['meta_keyword'];
        $page->meta_description = $collection['meta_description'];
        $page->page_type = $collection['page_type'];
        if ($collection['page_type'] != "Top Level"){
            $page->category = (empty($collection['category_type']) || $collection['page_type'] != 'Categories')?null:$collection['category_type'];
            $page->country = (empty($collection['country']))?null:$collection['country'];
            $page->city = (empty($collection['city']))?null:$collection['city'];
        }
        $page->image = $image;
        $page->status = $collection->has('status') ? true : false;
        $page->save();

        return $page;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletePage($id)
    {
        $page = $this->findPageById($id);

        if ($page->image != null) {
            $this->deleteOne($page->image);
        }

        $page->delete();

        return $page;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updatePageStatus(array $params){
        $page = $this->findPageById($params['id']);
        $collection = collect($params)->except('_token');
        $page->status = $collection['check_status'];
        $page->save();

        return $page;
    }


}