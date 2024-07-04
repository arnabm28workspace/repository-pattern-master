<?php
namespace App\Repositories;

use App\Models\CategoryForm;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CategoryFormContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Arr;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class CategoryFormRepository extends BaseRepository implements CategoryFormContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(CategoryForm $model)
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
    public function listForms(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findFormById(int $id)
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
    public function findFormByCategoryId(int $id)
    {
        try {
            $fields = $this->model::where('category_id','=',$id)->get();
            return $fields;

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createCategoryForm(array $params)
    {
        try {
            $collection = collect($params);

            $category_form = $this->model;
            $category_form->name = $collection['form_name'];
            $category_form->status = $collection['status'];
            $category_form->category_id = $collection['category_type'];
            $category_form->field_values = $collection['field_array'];
            
            $category_form->save();

            return $category_form->id;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategoryForm(array $params)
    {
        $category_form = $this->findFormById($params['id']);
        $collection = collect($params);
        $category_form->name = $collection['form_name'];
        $category_form->status = $collection['status'];
        $category_form->category_id = $collection['category_type'];
        $category_form->field_values = $collection['field_array'];
        $category_form->save();

        return $category_form->id;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateCategoryFormStatus(array $params){
        $category = $this->findFormById($params['id']);
        $collection = collect($params);
        $category->status = $collection['check_status'];
        $category->save();

        return $category;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteForm($id)
    {
        $form = $this->findFormById($id);

        $form->delete();

        return $form;
    }

}