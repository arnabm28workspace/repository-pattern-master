<?php
namespace App\Repositories;

use App\Models\PageType;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PageTypeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class PageTypeRepository
 *
 * @package \App\Repositories
 */
class PageTypeRepository extends BaseRepository implements PageTypeContract
{
    use UploadAble;

    /**
     * PageTypeRepository constructor.
     * @param PageType $model
     */
    public function __construct(PageType $model)
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
    public function listPageTypes(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPageTypeById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return PageType|mixed
     */
    public function createPageType(array $params)
    {
        try {
            $collection = collect($params);
            $pagetype = new PageType;
            $pagetype->name = $collection['name'];
            $pagetype->save();

            return $pagetype;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePageType(array $params)
    {
        $pagetype = $this->findPageTypeById($params['id']);
        $collection = collect($params)->except('_token');
        $pagetype->name = $collection['name'];
        $pagetype->save();

        return $pagetype;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletePageType($id)
    {
        $pagetype = $this->findPageTypeById($id);

        $pagetype->delete();

        return $pagetype;
    }


}