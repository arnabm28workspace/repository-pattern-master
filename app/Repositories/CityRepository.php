<?php
namespace App\Repositories;

use App\Models\City;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CityContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CityRepository
 *
 * @package \App\Repositories
 */
class CityRepository extends BaseRepository implements CityContract
{
    use UploadAble;

    /**
     * CityRepository constructor.
     * @param City $model
     */
    public function __construct(City $model)
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
    public function listCities(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        //return $this->all($columns, $order, $sort);
        $cities = City::select("cities.*","countries.name as country_name")
                      ->leftjoin("countries", "cities.country_id", "=", "countries.id")
                      ->get();

        return $cities; 
    }

    public function fetchCitiesByCountryId($id,string $order = 'id', string $sort = 'desc', array $columns = ['*']){
        return $this->all($columns, $order, $sort)->where('country_id',$id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCityById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return City|mixed
     */
    public function createCity(array $params)
    {
        try {
            $collection = collect($params);
            
            $namesArr = explode(',', $collection['name']);

            foreach($namesArr as $name){
                $city = new City;
                $city->country_id = $collection['country_id'];
                $city->name = $name;
                $city->save();
            }

            return $city;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCity(array $params)
    {
        $city = $this->findCityById($params['id']);
        $collection = collect($params)->except('_token');
        $city->country_id = $collection['country_id'];
        $city->name = $collection['name'];
        $city->save();
        return $city;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCity($id)
    {
        $city = $this->findCityById($id);

        $city->delete();

        return $city;
    }


}