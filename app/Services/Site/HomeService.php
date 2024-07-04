<?php

namespace App\Services\Site;

use App\Contracts\CategoryContract;
use App\Contracts\CountryContract;
use App\Contracts\AdsContract;
use App\Contracts\AdsImageContract;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use Auth;
use Carbon\Carbon;

class HomeService
{
    protected $categoryRepository;
    protected $countryRepository;
    protected $adsRepository;
    protected $adsImageRepository;

    /**
     * class AdsService constructor
     */
    public function __construct(CategoryContract $categoryRepository, CountryContract $countryRepository, AdsContract $adsRepository, AdsImageContract $adsImageRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository = $countryRepository;
        $this->adsRepository = $adsRepository;
        $this->adsImageRepository = $adsImageRepository;
    }

    /**
     * Fetch List of datas showing in home page
     * @return mixed
     */
    public function fetchAllDatas($search_terms=[]){

        $match_terms = array();
        if (!empty($search_terms['country'])){
            if ($country = $this->countryRepository->findCountryBySlug($search_terms['country'])){
                $countryId = $country->id;
            } else{
                $countryId = '-1';
                $countryCity = ucfirst($search_terms['country']);
                if($category = $this->categoryRepository->findBySlug($search_terms['country'])){
                    $country_category = $category->id;
                } else {
                    $country_category = '-1';
                }
            }
            $match_terms['country_id'] = $countryId;
            $match_terms['country_city'] = !empty($countryCity)?$countryCity:'';
            $match_terms['country_category'] = !empty($country_category)?$country_category:'';
        }
        
        $city = ucfirst($search_terms['city']);
        if (!empty($search_terms['city'])){
            if ($category = $this->categoryRepository->findBySlug($search_terms['city'])){
                $cityId = $category->id;
            } else{
                $cityId = '-1';
            }
            $match_terms['city'] = $city;
            $match_terms['city_id'] = $cityId;
        }

        if (!empty($search_terms['category'])){
            if ($category = $this->categoryRepository->findBySlug($search_terms['category'])){
                $categoryId = $category->id;
            } else{
                $categoryId = '-1';
            }
            $match_terms['category_id'] = $categoryId;
        }

        $ads = array();
        $categories = $this->categoryRepository->listActiveCategories();
        $countriesDatas = $this->countryRepository->listActiveCountries();
        
        $cities = collect();
        foreach ($countriesDatas as $key => $country) {
            if ($country->city_list->count() > 0) {
                $country->city_list->filter(function($city) use($cities){
                    $cities->push($city);
                });
            }
        }

        $countries = array();
        foreach ($countriesDatas as $country) {
            $city_list = $country->city_list()->where('country_id','=',$country->id)->get();
            $city_array = []; // Stores the cities of corresponding country
            foreach ($city_list as $city) {
                array_push($city_array, $city->name);
            }
            $city_length = sizeof($city_array); //Length of array
            $city_display = []; // temporary array to store the cities
            $city_string = implode(',', $city_array);
            $country->city_list=$city_string;
            array_push($countries, $country);
        }

        $ads = $this->adsRepository->getAds($match_terms);
        $latestAds = $ads->filter(function($ad, $key){
            $basicPackage = $ad->packages->where('package_type', 'basic_package')->first();
            if($basicPackage->expiry_date >= Carbon::now()->toDateString()){
                $addons = $ad->packages->where('package_type', 'add_on');
                $is_highlighted = $addons->filter(function($package) {
                    return $package->expiry_date >= Carbon::now()->toDateString() && $package->package->name == "Highlighted";
                });
                $ad->is_highlight = !empty($is_highlighted->all())?true:false;
                return Carbon::parse($ad->created_at)->diffInDays(Carbon::now()) < Setting::get('new_ad_duration');
            }
        })->values();
        return array("categories" => $categories->all(), "countries" => $countries, 'cities' => $cities->all(), "ads" => $latestAds);
    }

}