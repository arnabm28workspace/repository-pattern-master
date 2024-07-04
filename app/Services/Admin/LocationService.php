<?php

namespace App\Services\Admin;

use App\Contracts\CountryContract;
use App\Contracts\CityContract;
use Auth;

class LocationService
{
    protected $countryRepository;
    protected $cityRepository;
    
    /**
     * class LocationService constructor
     */
    public function __construct(CountryContract $countryRepository, CityContract $cityRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Fetch List of Location
     * @return mixed
     */
    public function fetchLocations() {
        return $this->countryRepository->listCountries('order', 'asc');
    }

    public function fetchCountryCity(){
        $countries = $this->countryRepository->listActiveCountries();
        $countries = $countries->map(function($country) {
            $city_list = $country->city_list()->where('country_id','=',$country->id)->get();
            $city_array = [];
            foreach ($city_list as $city) {
                array_push($city_array, $city->name);
            }
            $city_string = implode(',', $city_array);
            $country['city_list'] = $city_string;

            return $country;
        });

        return $countries;
    }

    /**
     * Fetch individual Location
     * @param int $id
     * @return mixed
     */
    public function fetchLocationById($id) {
        //return $this->countryRepository->findCountryById($id);
        $data['country'] = $this->countryRepository->findCountryById($id);
        $cities = $this->cityRepository->fetchCitiesByCountryId($id);

        $city = array();
        foreach($cities as $c){
            array_push($city, $c->name);
        }

        $data['cities'] = $city;
        return $data;
    }

    /**
     * Save Location information
     * @param int $id
     * @return mixed
     */
    public function createLocation($request) {
        $params = $request->except('_token');
        return $this->countryRepository->createCountry($params);
    }

    /**
     * Update Location info
     * @param Request $request
     * @return mixed
     */
    public function updateLocation($request) {
        $params = $request->except('_token');
        return $this->countryRepository->updateCountry($params);
    }

    /**
     * Delete a Location
     * @param int $id
     * @return mixed
     */
    public function deleteLocation($id) {
        return $this->countryRepository->deleteCountry($id);
    }

    /**
     * Fetch Location by Country code
     * @param int $id
     * @return mixed
     */
    public function fetchLocationByCountryCode($code) {
        return $this->countryRepository->fetchLocationByCountryCode($code);
    }

    /**
     * Update status of a country
     * @param int $id
     * @return mixed
     */
    public function updateCountryStatus($id,$check_status){
        $params = array("id"=>$id,"check_status"=>$check_status);

        $country = $this->countryRepository->updateCountryStatus($params);

        return $country;
    }
}