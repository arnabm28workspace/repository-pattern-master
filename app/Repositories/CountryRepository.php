<?php
namespace App\Repositories;

use App\Models\Country;
use App\Models\City;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CountryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CountryRepository
 *
 * @package \App\Repositories
 */
class CountryRepository extends BaseRepository implements CountryContract
{
    use UploadAble;

    /**
     * CountryRepository constructor.
     * @param Country $model
     */
    public function __construct(Country $model)
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
    public function listCountries(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCountryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Country|mixed
     */
    public function createCountry(array $params)
    {
        try {
            $collection = collect($params);
            $country = new Country;
            $country->name = $collection['name'];
            $country->flag = (empty($collection['flag']))? null:$collection['flag'];
            $country->code = $collection['code'];
            $country->order = $collection['order'];
            $cities = explode(',', $collection['cities']);
            $country->save();
            $last_id = $country->id;

            foreach ($cities as $c) {
                $city = new City;
                $city->country_id = $last_id;
                $city->name = $c;
                $city->save();
            }

            return $country;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCountry(array $params)
    {
        $country = $this->findCountryById($params['id']);
        $collection = collect($params)->except('_token');
        $country->name = $collection['name'];
        //$country->code = $collection['code'];
        //$country->cities = $collection['cities'];
        $country->order = $collection['order'];
        $cities = explode(',', $collection['cities']);
        $country->save();

        City::where('country_id', $country->id)->delete();
        foreach ($cities as $c) {

            $city = new City;
            $city->country_id = $country->id;
            $city->name = $c;
            $city->save();
        }

        return $country;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCountry($id)
    {
        $country = $this->findCountryById($id);

        $country->delete();

        return $country;
    }

    /**
     * @param $code
     * @return bool|mixed
     */
    public function fetchLocationByCountryCode($code)
    {
        $country = $this->model::where('code', '=', $code)->first();
        if($country)
        {
            return $country;
        }else{
            return 0;
        }
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function findCountryByName($name)
    {
        return $this->model::whereRaw('LOWER(name) = ?', [$name])->first();
    }

    /**
     * @param $slug
     * @return bool|mixed
     */
    public function findCountryBySlug($slug)
    {
        return $this->model::where('slug', $slug)->first();
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateCountryStatus(array $params){
        $country = $this->findCountryById($params['id']);
        $collection = collect($params)->except('_token');
        $country->status = $collection['check_status'];
        $country->save();

        return $country;
    }

    /**
     * @return mixed
     */
    public function listActiveCountries(){
        return Country::where('status','1')->orderBy('order', 'asc')->get();
    }
}