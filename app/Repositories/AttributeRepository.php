<?php
namespace App\Repositories;

use App\Models\Attribute;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AttributeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class AttributeRepository
 *
 * @package \App\Repositories
 */
class AttributeRepository extends BaseRepository implements AttributeContract
{
    use UploadAble;

    /**
     * AttributeRepository constructor.
     * @param Attribute $model
     */
    public function __construct(Attribute $model)
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
    public function listAttributes(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function filterableAttributes(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort)->where('is_filterable','1');
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findAttributeById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return attribute|mixed
     */
    public function createAttribute(array $params)
    {
        try {
            $collection = collect($params);

            $attribute = new Attribute;
            $attribute->colname = $collection['colname'];
            $attribute->label = $collection['label'];
            $attribute->field_type = $collection['field_type'];
            $attribute->popup_vals = $collection['popup_vals'];
            $status = $collection->has('status') ? 1 : 0;
            $is_filterable = $collection->has('is_filterable') ? 1 : 0;
            $is_required = $collection->has('is_required') ? 1 : 0;
            $attribute->status = $status;
            $attribute->is_filterable = $is_filterable;
            $attribute->is_required = $is_required;

            $attribute->save();

            return $attribute;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAttribute(array $params)
    {
        $attribute = $this->findAttributeById($params['id']);
        $collection = collect($params)->except('_token');
        $attribute->colname = $collection['colname'];
        $attribute->label = $collection['label'];
        $attribute->field_type = $collection['field_type'];
        $attribute->popup_vals = $collection['popup_vals'];
        $status = $collection->has('status') ? 1 : 0;
        $is_filterable = $collection->has('is_filterable') ? 1 : 0;
        $is_required = $collection->has('is_required') ? 1 : 0;
        $attribute->status = $status;
        $attribute->is_filterable = $is_filterable;
        $attribute->is_required = $is_required;
        
        $attribute->save();

        return $attribute;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteAttribute($id)
    {
        $attribute = $this->findAttributeById($id);

        $attribute->delete();

        return $attribute;
    }


}