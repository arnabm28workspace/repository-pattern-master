<?php

namespace App\Services\Site;

use App\Contracts\CategoryFormContract;
use App\Contracts\CategoryContract;
use App\Contracts\CountryContract;
use App\Contracts\AdsContract;
use App\Contracts\AdSearchContract;
use App\Contracts\AdsImageContract;
use App\Contracts\AdsMessagesContract;
use App\Contracts\AdMessageReplyContract;
use App\Contracts\AdsReportsContract;
use App\Contracts\CityContract;
use App\Contracts\PackageContract;
use App\Contracts\PaymentContract;
use App\Contracts\AdDetailsContract;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use App\Models\Setting;
use Log;

class AdsService
{
    protected $categoryRepository;
    protected $countryRepository;
    protected $adsRepository;
    protected $adSearchRepository;
    protected $adsImageRepository;
    protected $adsMessagesRepository;
    protected $adMessageReplyRepository;
    protected $adsReportRepository;
    protected $adDetailsRepository;
    protected $cityRepository;
    protected $packageRepository;
    protected $paymentRepository;

    /**
     * class AdsService constructor
     */
    public function __construct(CategoryFormContract $categoryFormRepository, CategoryContract $categoryRepository, CountryContract $countryRepository, AdsContract $adsRepository,AdSearchContract $adSearchRepository, AdsImageContract $adsImageRepository,AdsMessagesContract $adsMessagesRepository,AdMessageReplyContract $adMessageReplyRepository,AdsReportsContract $adsReportRepository, CityContract $cityRepository,PackageContract $packageRepository, PaymentContract $paymentRepository, AdDetailsContract $adDetailsRepository)
    {
        $this->categoryFormRepository = $categoryFormRepository;
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository = $countryRepository;
        $this->adsRepository = $adsRepository;
        $this->adSearchRepository = $adSearchRepository;
        $this->adsImageRepository = $adsImageRepository;
        $this->adsMessagesRepository = $adsMessagesRepository;
        $this->adMessageReplyRepository = $adMessageReplyRepository;
        $this->adsReportRepository = $adsReportRepository;
        $this->adDetailsRepository = $adDetailsRepository;
        $this->cityRepository = $cityRepository;
        $this->packageRepository = $packageRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Fetch List of ads
     * @return mixed
     */
    public function fetchAllAds(){
        $filters = $_GET;
        $filter_keys = array();

        foreach ($filters as $key => $value) {
            if($value!=''){
                array_push($filter_keys, $key);
            }
        }

        $ads = array();
        $allAds = array();

        $categories = $this->categoryRepository->listActiveCategories();
        $countries = $this->countryRepository->listActiveCountries();
        $ads = $this->adsRepository->fetchAllAds();

        if(count($filter_keys)>0){

            if(count($filter_keys)==1){
                foreach ($ads as $ad) {
                    if($ad[$filter_keys[0]]==$filters[$filter_keys[0]]){
                        array_push($allAds, $ad);
                    }
                }
            }else if(count($filter_keys)==2){
                foreach ($ads as $ad) {
                    if($ad[$filter_keys[0]]==$filters[$filter_keys[0]] && $ad[$filter_keys[1]]==$filters[$filter_keys[1]]){
                        array_push($allAds, $ad);
                    }
                }
            }
        }else{
            $allAds = $ads;
        }

        return array("categories"=>$categories, "countries"=>$countries,"ads"=>$allAds);
    }

    /**
     * Fetch List of ads
     * @return mixed
     */
    public function fetchAds($search_terms=[]){

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

        $categories = $this->categoryRepository->listActiveCategories();
        $countriesDatas = $this->countryRepository->listActiveCountries();
        $allads = $this->adsRepository->getAds($match_terms);

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

        $featuredAds = $allads->filter(function($ad, $key) {
            
            $basicPackage = $ad->packages->where('package_type', 'basic_package')->first();
        
            if($basicPackage->expiry_date >= Carbon::now()->toDateString()){
                $addons = $ad->packages->where('package_type', 'add_on');
                $is_highlighted = $addons->filter(function($package) {
                    return $package->expiry_date >= Carbon::now()->toDateString() && $package->package->name == "Highlighted";
                });
                $ad->is_highlight = !empty($is_highlighted->all())?true:false;

                $ad->is_new = Carbon::parse($ad->created_at)->diffInDays(Carbon::now()) < Setting::get('new_ad_duration') ? true:false;
                
                return $basicPackage->package_id == 2;
            }
        })->values();

        $standardAds = $allads->filter(function($ad, $key) {
            $basicPackage = $ad->packages->where('package_type', 'basic_package')->first();

            if($basicPackage->expiry_date >= Carbon::now()->toDateString()){
                
                $addons = $ad->packages->where('package_type', 'add_on');
                $is_highlighted = $addons->filter(function($package) {
                    return $package->expiry_date >= Carbon::now()->toDateString() && $package->package->name == "Highlighted";
                });
                $ad->is_highlight = !empty($is_highlighted->all())?true:false;

                $ad->is_new = Carbon::parse($ad->created_at)->diffInDays(Carbon::now()) < Setting::get('new_ad_duration') ? true:false;

                return $basicPackage->package_id == 1;
            }
        })->values();

        return array("categories" => $categories, "countries" => $countries, "cities" => $cities, "featuredAds" => $featuredAds, 'standardAds' => $standardAds);
    }

    /**
     * Fetch List of ads after search
     * @return mixed
     */
    public function fetchAdsBySearch($search_terms){
        //$category = $this->categoryRepository->findBySlug($search_terms['category']);
        //$country = $this->countryRepository->findCountryBySlug($search_terms['country']);
        
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
        }
        
        $city = ucfirst($search_terms['city']);
        if (!empty($search_terms['city'])){
            if ($category = $this->categoryRepository->findBySlug($search_terms['city'])){
                $cityId = $category->id;
            } else{
                $cityId = '-1';
            }
        }

        if (!empty($search_terms['category'])){
            if ($category = $this->categoryRepository->findBySlug($search_terms['category'])){
                $categoryId = $category->id;
            } else{
                $categoryId = '-1';
            }
        }

        $match_terms = array();
        //if(!empty($country)){
        if (!empty($search_terms['country'])){
            //$match_terms['country_id'] = $country->id;
            $match_terms['country_id'] = $countryId;
            $match_terms['country_city'] = !empty($countryCity)?$countryCity:'';
            $match_terms['country_category'] = !empty($country_category)?$country_category:'';
        } 
        if(!empty($city)){
            $match_terms['city'] = $city;
            $match_terms['city_id'] = $cityId;
        }
        //if(!empty($category)){
        if (!empty($search_terms['category'])){
            //$match_terms['category_id'] = $category->id;
            $match_terms['category_id'] = $categoryId;
        }

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

        $allads = $this->adsRepository->getAds($match_terms);
        $ads = $allads->filter(function($ad, $key) use ($match_terms){
            /* if(count($match_terms) > 0){
                foreach ($match_terms as $key => $value) {
                    if ($ad->$key !== $value) {
                        return false;
                    }
                }
            } */
            $addons = $ad->packages->where('package_type', 'add_on');
            $is_highlighted = $addons->filter(function($package) {
                return $package->expiry_date >= Carbon::now()->toDateString() && $package->package->name == "Highlighted";
            });
            $ad->is_highlight = !empty($is_highlighted->all())?true:false;
            return true;
        })->values();

        $allAds = $ads->filter(function($ad, $key) {
            
            $basicPackage = $ad->packages->where('package_type', 'basic_package')->first();
            if($basicPackage->expiry_date >= Carbon::now()->toDateString()){
                
                $ad->is_new = Carbon::parse($ad->created_at)->diffInDays(Carbon::now()) < Setting::get('new_ad_duration') ? true:false;
                $ad->package_type = $basicPackage->package_id == 1 ? 'standard':'featured';
                return $ad;
            }
        })->values();

        $allAds = collect($allAds)->paginate(10);
        if(!empty($search_terms['country']) && !empty($search_terms['city']) && !empty($search_terms['category']) && !empty($search_terms['search_from']) && $search_terms['search_from'] == 'search' && $allAds->count() > 0) {
            $adSearchDetails = $this->adSearchRepository->storeSearchData($search_terms);
            \Session::forget('search_from');
        }

        return array("categories" => $categories, "countries" => $countries, 'cities' => $cities, "ads" => $allAds);
    }

    public function fetchMostSearchedContent()
    {
        return $this->adSearchRepository->fetchMostSearchedContent();
    }

    /**
     * Fetch the data of ads that need for details page
     * @param string $slug
     * @return mixed
     */
    public function fetchAdDetails($slug){
        $ad = $this->adsRepository->getAdDetails($slug);
        return array("ad"=>$ad[0]);
    }

    /**
     * Fetch the data of ads that need for details page
     * @param string $slug
     * @return mixed
     */
    public function fetchAdPreview($slug){
        $ad = $this->adsRepository->getAdPreview($slug);
        return array("ad"=>$ad[0]);
    }

    /**
     * Fetch list of all categories
     * @return mixed
     */
    public function fetchCategories(){
        return $this->categoryRepository->listCategories();
    }

    /**
     * Fetch list of all countries
     * @return mixed
     */
    public function fetchCountries(){
        //return $this->countryRepository->listCountries();
        $countriesDatas = $this->countryRepository->listActiveCountries();
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

        return $countries;
    }

    /**
     * Fetch list of all cities by country
     * @param int $id
     * @return mixed
     */
    public function fetchCitiesByCountry($id){
        return $this->cityRepository->fetchCitiesByCountryId($id);
    }

    /**
     * Fetch user profile data
     * @return mixed
     */
    public function fetchUserProfile(){
        return Profile::where('user_id','=',Auth::user()->id)->first();
    }

    /**
     * Upload an ad image
     * @param Request $request
     * @return mixed
     */
    public function uploadImage($request){
        $params = $request->except('_token');

        return $this->adsRepository->uploadAdImage($params);
    }

    /**
     * Save an ad information
     * @param Request $request
     * @return mixed
     */
    public function createAd($request){
        $params = $request->except('_token');

        $params['unique_id'] = time();
        $params['user_id'] = auth()->user()->id;

        $adData = $this->adsRepository->createAds($params);
        $documents = $adData['collection']['document'];
        $ad_id = $adData['ads']->id;
        foreach($documents as $doc){
            if($doc!=''){
                $image_params = array();
                $image_params['ad_id'] = $ad_id;
                $image_params['image'] = $doc;
                $this->adsImageRepository->storeImage($image_params);
            }
        }
        $length_ad_collection = sizeof($adData['collection']);
        
        if($length_ad_collection>13)
        {
            $this->adDetailsRepository->storeAdDetails($adData);
        }

        return $adData['ads'];
    }

    /**
     * Fetch user's ad list
     * @return mixed
     */
    public function fetchMyAds($type){
        $ads = array();
        if($type == 'live'){
            $ads = $this->fetchUserAds();
            $ads = $ads->filter(function($ad) {
                return $ad->expired == false;
            })->all();
        }else if($type == 'expired'){
            $ads = $this->fetchUserAds();
            $ads = $ads->filter(function($ad) {
                return $ad->expired == true;
            })->all();
        }else if($type == 'draft'){
            $ads = $this->fetchDraftAds();
        } else {
            $ads = $this->fetchUserAds()->all();
        }

        return $ads;
    }

    public function fetchUserAds() {
        $ads = array();
        $package_total = 0;
        $adDatas = $this->adsRepository->myAds();

        $adDatas->each(function($ad, $key){
            $package_total = 0;
            $ad->image = $this->adsImageRepository->firstImage($ad->id);
            $packages = $ad->packages;
            $basicPackage = $ad->packages->where('package_type', 'basic_package')->first();
            $package_names = '';
            $package_names_arr = array();
            $curr_date = Carbon::now()->format('Y-m-d');

            if(count($packages)>0){
                $package_expire_date = $basicPackage->expiry_date;
            }else{
                $package_expire_date = '';
            }
            
            foreach ($packages as $p) {
                $package_total=$package_total+($p->price);
                array_push($package_names_arr, $this->packageRepository->findPackageById($p->package_id)->name);
            }

            $ad->package_total = $package_total;
            $ad->basic_package = $basicPackage->package;
            $ad->package_name_array = $package_names_arr;
            $ad->package_names = implode('/', $package_names_arr);
            $ad->package_expire_date = $package_expire_date;
            $ad->expired = $curr_date<=$package_expire_date ? false:true;
        });
        
        return $adDatas;
    }

    /**
     * Fetch user draft ad list
     * @return mixed
     */
    public function fetchDraftAds() {
        $ads = array();
        $adDatas = $this->adsRepository->fetchAdsByUser(auth()->user()->id);
        $ads = $adDatas->filter(function ($ad, $key) {
            return $ad->is_payment == false;
        })->values();
        return $ads->all();
    }

    /**
     * Fetch top most viewed ads
     * @return mixed
     */
    public function mostViewedAds() {
        $ads = array();
        $package_total = 0;
        $adDatas = $this->adsRepository->myAds()->sortByDesc('views')->take(2);
        foreach($adDatas as $ad){
            $package_total = 0;
            $ad->image = $this->adsImageRepository->firstImage($ad->id);
            $packages = $ad->packages;
            $basicPackage = $ad->packages->where('package_type', 'basic_package')->first();
            $package_names = '';
            $package_names_arr = array();
            $curr_date = \Carbon\Carbon::now()->format('Y-m-d');

            if(count($packages)>0){
                $package_expire_date = $basicPackage->expiry_date;
            }else{
                $package_expire_date = '';
            }
            
            foreach ($packages as $p) {
                $package_total=$package_total+($p->price);
                array_push($package_names_arr, $this->packageRepository->findPackageById($p->package_id)->name);
            }
            $ad->package_total = $package_total;
            $ad->basic_package = $basicPackage->package;
            $ad->package_name_array = $package_names_arr;
            $ad->package_names = implode('/', $package_names_arr);
            $ad->package_expire_date = $package_expire_date;
            $ad->expired = $curr_date<=$package_expire_date ? false:true;

            //if($package_expire_date!='' && $curr_date<=$package_expire_date){
                array_push($ads, $ad);
            //}
        }
        return $ads;
    }

    /**
     * Fetch ad information for the edit page
     * @param int $id
     * @return mixed
     */
    public function editAds($slug){
        $ad = $this->adsRepository->getAdDetails($slug)[0];
        $categories = $this->categoryRepository->listActiveCategories();
        $countries = array();
        $countriesDatas = $this->countryRepository->listActiveCountries();
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

        return array("ad"=>$ad,"categories"=>$categories,"countries"=>$countries);
    }

    /**
     * Update an ad information
     * @param Request $request
     * @return mixed
     */
    public function updateAd($request){
        $params = $request->except('_token');

        $adData = $this->adsRepository->updateAds($params);
        
        $ad_id = $adData['ads']->id;

        $this->adDetailsRepository->updateAdDetails($adData);

        return $adData['ads'];

    }

    /**
     * Save message sent to ad's owner
     * @param Request $request
     * @return mixed
     */
    public function createAdMessage($request){
        $params = $request->except('_token');

        return $this->adsMessagesRepository->createAdsMessage($params);
    }

    /**
     * Save message sent to ad's owner
     * @param Request $request
     * @return mixed
     */
    public function replyAdMessage($request){
        $params = $request->except('_token');

        return $this->adMessageReplyRepository->storeAdMessageReply($params);
    }

    /**
     * Save abuse report against ad
     * @param Request $request
     * @return mixed
     */
    public function createReportAgainstAd($request){
        $params = $request->except('_token');

        $params['user_id'] = auth()->user()->id;
        return $this->adsReportRepository->createAdsReport($params);
    }

    /**
     * Get category details by category id
     * @param Request $request
     * @return mixed
     */
    public function findCategoryById($id)
    {
        return $this->categoryRepository->findCategoryById($id);
    }
    
    /**
     * Get category form fields
     * @param Request $request
     * @return mixed
     */
    public function findFormByCategoryId($id)
    {
        return $this->categoryFormRepository->findFormByCategoryId($id);
    }

     /**
     * Get category form values
     * @param int $id
     * @return mixed
     */
    public function findFormValueByAdId($id,$key){
        return $this->adDetailsRepository->getCustomFieldValue($id,$key);
    }

    /**
     * Get category form values
     * @param int $id
     * @return mixed
     */
    public function findRatesValueByAdId($id){
        return $this->adDetailsRepository->getRatesValue($id);
    }

    /**
     * Get all images by ad id
     * @param int $id
     * @return mixed
     */
    public function fetchImagesByAdId($id){
        $images = array();
        $imagesDatas = $this->adsImageRepository->getImagesByAdId($id);

        foreach($imagesDatas as $image){
            $image->url = asset('storage/'.$image->image);
            $image->original_name = $image->getImageName();
            array_push($images, $image);
        }

        return $images;
    }

    /**
     * Store image while ad update
     * @param Request $request
     * @return mixed
     */
    public function updateImageForAd($request){
        $params = $request->except('_token');

        return $this->adsImageRepository->storeImage($params);
    }

    /**
     * Delete image while ad update
     * @param Request $request
     * @return mixed
     */
    public function deleteImageForAd($request){
        $params = $request->except('_token');

        return $this->adsImageRepository->deleteImage($params);
    }

    /**
     * Update The status of ads
     * @param int $id
     * @param int $is_blocked
     * @return mixed
     */
    public function updateAdStatus($id,$is_blocked){
        $params = array("id"=>$id,"is_blocked"=>$is_blocked);

        $ad = $this->adsRepository->updateAdStatus($params);

        return $ad;
    }

    /**
     * Fetch Messages by User Id
     * @return mixed
     */
    public function fetchMessagesByUserId(){
        
        return $this->adsRepository->fetchMessagesByUserId();
    }

    /**
     * Update Message Status
     */
    public function updateMessageStatus($id)
    {
        return $this->adsMessagesRepository->updateMessageStatus($id);
    }

    /**
     * Fetch Payments by User Id
     * @return mixed
     */
    public function fetchPaymentsByUserId(){
        $user_id = auth()->user()->id;    
        $allpayments = $this->paymentRepository->getPaymentListByUserId($user_id);
        $collect_all_payments = collect($allpayments);
        $payments = array();
        $all_ad_id = array();
        
        foreach ($allpayments as $payment) {
        
            array_push($all_ad_id, $payment->ad_id);
            
        }
        $all_ad_id = array_unique($all_ad_id);
        foreach ($all_ad_id as $ad_id) {
            $payments_ad = array();
            $filtered = $collect_all_payments->where('ad_id',$ad_id);
            foreach ($filtered as $filter_ad_payment) {
                array_push($payments_ad, $filter_ad_payment);
            }
            array_push($payments, $payments_ad);
        }

        return $payments;
    }

}