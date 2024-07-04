<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Admin\LocationService;
use PragmaRX\Countries\Package\Countries;

class CountryController extends BaseController
{
    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * CountryController constructor.
     * 
     * @param LocationService $locationService
     */
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->locationService->fetchLocations();
        foreach ($countries as $country) {
            $city_list = $country->city_list()->where('country_id','=',$country->id)->get();
            $city_array = []; // Stores the cities of corresponding country
            foreach ($city_list as $city) {
                array_push($city_array, $city->name);
            }
            $city_length = sizeof($city_array); //Length of array
            $city_display = []; // temporary array to store the cities
            $city_string = ""; // display format of city in the list
            if($city_length>5)
            {
                for ($i=0; $i < 5; $i++) { 
                    array_push($city_display, $city_array[$i]);
                }
                $city_string = implode(', ', $city_display)." <span class='badge badge-secondary'>"." +".($city_length-5)."</span>";
            }else{
                $city_string = implode(', ', $city_array);
            }
            $country['city_list']=$city_string;
        }
        
        $this->setPageTitle('Country', '');
        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Create Country', '');
        return view('admin.countries.create');
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
            'name'  =>  'required|max:255',
            'code'  =>  'required',
            'cities' => 'required',
            'order' =>  'nullable|integer|min:1'
        ]);

        //check if record exists
        $country_db = $this->locationService->fetchLocationByCountryCode($request->code);
        if(!$country_db)
        {
            $country = $this->locationService->createLocation($request);

            if (!$country) {
                return $this->responseRedirectBack('Error occurred while creating country.', 'error', true, true);
            }
            return $this->responseRedirect('admin.country.index', 'Country added successfully' ,'success',false, false);
        }else{

            return $this->responseRedirectBack('Country already exists', 'error', true, true);
        }
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
        // $targetCountry = $this->locationService->fetchLocationById($id);
        $data = $this->locationService->fetchLocationById($id);
        
        $this->setPageTitle('Country: '.$data['country']->name, 'Edit Country');
        return view('admin.countries.edit', ["targetCountry"=>$data['country'],"cities"=>implode(',', $data['cities'])]);
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
            'name'   => 'required|max:191',
            'cities' => 'required',
            'order'  => 'nullable|integer|min:1'
        ]);

        $country = $this->locationService->updateLocation($request);

        if (!$country) {
            return $this->responseRedirectBack('Error occurred while updating country.', 'error', true, true);
        }
        return $this->responseRedirectBack( 'Country updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $country = $this->locationService->deleteLocation($id);

        if (!$country) {
            return $this->responseRedirectBack('Error occurred while deleting country.', 'error', true, true);
        }
        return $this->responseRedirect('admin.country.index', 'Country deleted successfully' ,'success',false, false);
    }

    public function getCountry()
    {
        $countries = new Countries();
        $all_country = $countries->all();
        $country_response = $all_country->toJson();
        return $country_response;
    }

    public function getCitiesByCountry(Request $request)
    {
        $country_code = $request->cca2;
        $countries = new Countries();
        $all_country = $countries->all();
        $cities = $all_country->where('cca2', $country_code)
            ->first()
            ->hydrate('cities')
            ->cities;
        $city_response = $cities->toJson();
        return $city_response;

    }
    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request){
        $country = $this->locationService->updateCountryStatus($request->country_id,$request->check_status);

        if ($country) {
            return response()->json(array('message'=>'Country status successfully updated'));
        }
    }
}
