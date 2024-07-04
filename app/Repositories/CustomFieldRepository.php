<?php

namespace App\Repositories;

use App\Models\CustomField;
use App\Contracts\CustomFieldContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class CustomFieldRepository extends BaseRepository implements CustomFieldContract
{
    /**
     * CustomFieldRepository constructor.
     * @param CustomField $model
     */
    public function __construct(CustomField $model)
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
    public function listCustomFields(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCustomFieldById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Category|mixed
     */
    public function createCustomField(array $params)
    {
        try {
            $collection = collect($params);

            $status = $collection->has('status') ? true : false;

            $merge = $collection->merge(compact('status'));

            $customfield = new CustomField($merge->all());

            $customfield->save();

            return $customfield;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCustomField(array $params)
    {
        $customfield = $this->findCustomFieldById($params['id']);

        $collection = collect($params)->except('_token');

        $status = $collection->has('status') ? true : false;

        $merge = $collection->merge(compact('status'));

        $customfield->update($merge->all());

        return $customfield;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCustomField($id)
    {
        $customfield = $this->findCustomFieldById($id);

        $customfield->delete();

        return $customfield;
    }
}