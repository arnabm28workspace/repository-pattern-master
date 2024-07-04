<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BlogContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class BlogRepository extends BaseRepository implements BlogContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
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
    public function listBlogs(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBlogById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createBlog(array $params)
    {
        try {
            $collection = collect($params);
            $image = null;
            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'blogs');
            }
            $blog = new Blog;
            $blog->blog_title = $collection['name'];
            $blog->category_id = (empty($collection['category_type']))?null:$collection['category_type'];
            $blog->blog_description = $collection['description'];
            $blog->image = $image;
            $blog->status = $collection->has('status') ? true : false;
            $blog->save();

            return $blog;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlog(array $params)
    {
        $blog = $this->findBlogById($params['id']);
        $collection = collect($params)->except('_token');
        $image = $blog->image;       
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($blog->image != null) {
                $this->deleteOne($blog->image);
            }

            $image = $this->uploadOne($params['image'], 'blogs');
        }
        $blog->blog_title = $collection['name'];
        $blog->category_id = (empty($collection['category_type']))?null:$collection['category_type'];
        $blog->blog_description = $collection['description'];
        $blog->image = $image;
        $blog->status = $collection->has('status') ? true : false;
        $blog->save();

        return $blog;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBlog($id)
    {
        $blog = $this->findBlogById($id);

        if ($blog->image != null) {
            $this->deleteOne($blog->image);
        }

        $blog->delete();

        return $blog;
    }


}