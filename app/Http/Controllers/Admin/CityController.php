<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Contracts\CityContract;
use App\Contracts\CountryContract;

class CityController extends BaseController
{
    protected $cityRepository;
    protected $countryRepository;

    /**
     * CityController constructor.
     * 
     * @param CityContract $cityRepository
     */
    public function __construct(CityContract $cityRepository,CountryContract $countryRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = $this->cityRepository->listCities();

        $this->setPageTitle('City', 'List of all cities');
        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->countryRepository->listCountries();
        $this->setPageTitle('City', 'Create City');
        return view('admin.cities.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'country_id' =>  'required',
        ]);

        $params = $request->except('_token');

        $city = $this->cityRepository->createCity($params);

        if (!$city) {
            return $this->responseRedirectBack('Error occurred while creating city.', 'error', true, true);
        }
        return $this->responseRedirect('admin.cities.index', 'City has been added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = $this->cityRepository->findCityById($id);
        $countries = $this->countryRepository->listCountries();
        
        $this->setPageTitle('City', 'Edit City : '.$city->name);
        return view('admin.cities.edit', compact('city','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required|max:191',
            'country_id'  =>  'required'
        ]);

        $params = $request->except('_token');

        $city = $this->cityRepository->updateCity($params);

        if (!$city) {
            return $this->responseRedirectBack('Error occurred while updating city.', 'error', true, true);
        }
        return $this->responseRedirectBack('City has been updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $city = $this->cityRepository->deleteCity($id);

        if (!$city) {
            return $this->responseRedirectBack('Error occurred while deleting city.', 'error', true, true);
        }
        return $this->responseRedirect('admin.cities.index', 'City has been deleted successfully' ,'success',false, false);
    }
}
