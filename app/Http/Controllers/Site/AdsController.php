<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Site\AdsService;
use Auth;
use Session;
use Redirect;

class AdsController extends BaseController
{
    protected $adsService;

    /**
     * SiteController constructor
     * @param AdsService $adsService
     */
    public function __construct(AdsService $adsService)
    {
        $this->adsService = $adsService;
    }

    /**
     * Display a listing of the resource.
     * * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $client_ip = $request->ip();
        $selected_category = '';
        $locationInfoIP = \Location::get($client_ip);
        $selected_country = strtolower($locationInfoIP->countryName);
        $selected_city = strtolower($locationInfoIP->cityName);
        $search_terms = array('country' => $selected_country, 'city' => $selected_city, 'category' => $selected_category);

        $data = $this->adsService->fetchAds($search_terms);
        
        $this->setPageTitle('Ad List', '');
        return view('site.ads.index',compact('data', 'selected_category', 'selected_country', 'selected_city'));
    }

    /**
     * Proces search form.
     * * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function processSearchForm(Request $request){
        $category  = !empty($request->category) ? addslashes($request->category):null;
        $country = !empty($request->country) ? addslashes($request->country):null;
        $city = !empty($request->city) ? addslashes($request->city):null;
        $search_from = !empty($request->search_from) ? addslashes($request->search_from):null;

        $request->session()->put('category', $category);
        $request->session()->put('country', $country);
        $request->session()->put('city', $city);
        $request->session()->put('search_from', $search_from);
        
        if(!is_null($category) && !is_null($country) && !is_null($city)){
            //return Redirect::to('ad-list/'.$category.'/'.$location);
            return Redirect::route('page.search', [$country, $city, $category]);
        }
        if(!is_null($category) && !is_null($country)){
            return Redirect::route('page.search', [$country, $category]);
        }
        if(!is_null($category) && !is_null($city)){
            return Redirect::route('page.search', [$city, $category]);
        }
        if(!is_null($country) && !is_null($city)){
            return Redirect::route('page.search', [$country, $city]);
        }
        if(!is_null($category)){
            return Redirect::route('page.search', [$category]);
        } else if(!is_null($country)) {
            return Redirect::route('page.search', [$country]);
        } else if(!is_null($city)) {
            return Redirect::route('page.search', [$city]);
        } else{
            return Redirect::route('page.search');
        }
    }

    /**
     * @param Request $request
     * Display the search result.
     * * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request){
        $client_ip = $request->ip();
        $selected_category = $request->session()->get('category');
        $selected_country = $request->session()->get('country');
        $selected_city = $request->session()->get('city');
        $search_terms = array('category' => $selected_category, 'country' => $selected_country, 'city' => $selected_city, 'ip_address' => $client_ip);
        $data = $this->adsService->fetchAdsBySearch($search_terms);
        $this->setPageTitle('Search', '');
        return view('site.ads.search',compact('data', 'selected_category', 'selected_country', 'selected_city'));
    }

    /**
     * Most searched content
     */
    public function fetchMostSearchedContent()
    {
        $mostSearchedContent = $this->adsService->fetchMostSearchedContent();
        return $mostSearchedContent;
    }

    /**
     * @param $key
     * Display the resource.
     * * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($key){
        try{
            $data = $this->adsService->fetchAdDetails($key);

            $this->setPageTitle($data['ad']->title, '');
            return view('site.ads.details',compact('data'));
        }catch(\Exception $e){
            abort(404);
        } 
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeAdMessage(Request $request){
        $adMessage = $this->adsService->createAdMessage($request);

        if (!$adMessage) {
            return redirect()->back()->with('error-message','Failed to post your message');
        }
        return redirect()->back()->with('success-message','Your message has been saved successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function replyAdMessage(Request $request){
        $adMessage = $this->adsService->replyAdMessage($request);

        if (!$adMessage) {
            return redirect()->back()->with('error-message','Failed to sent your message');
        }
        return redirect()->back()->with('success-message','Your message has been sent successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeReportAbuse(Request $request){
        $adReport = $this->adsService->createReportAgainstAd($request);

        if (!$adReport) {
            return redirect()->back()->with('error-message','Failed to post your report');
        }
        return redirect()->back()->with('success-message','Your report has been saved successfully');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function craeteAds(){
        $categories = $this->adsService->fetchCategories();
        $countries = $this->adsService->fetchCountries();

        $user_email = auth()->user()->email;
        $profile = $this->adsService->fetchUserProfile();

        if(!isset($profile->is_profile_complete)){
            return redirect()->back()->with('error-message','Your account is not completed yet!');
        }else if(isset($profile->is_profile_complete) && $profile->is_profile_complete==0){
            return redirect()->back()->with('error-message','Your account is not completed yet!');
        }

        $this->setPageTitle('Post Ads', '');
        return view('site.ads.create',compact('categories','countries','user_email','profile'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function dropzoneStore(Request $request){
        $image = $this->adsService->uploadImage($request);

        return response()->json(['name'=>$image]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeAds(Request $request){
        
        $ad = $this->adsService->createAd($request);

        if (!$ad) {
            return redirect()->back()->with('error-message','Failed to post ad');
        }
        //return redirect('checkout/'.$ad->id);
        return redirect()->route('checkout')->with('ad_id', $ad->id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function makePayment(Request $request) {
        if (!empty($request->ad_id)) {
            return redirect()->route('checkout')->with('ad_id', $request->ad_id);
        }
    }

    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCategoryFields(Request $request){
        $fields = $this->adsService->findFormByCategoryId($request->category_id);
        if ($fields->count() > 0 ) {
            $length = sizeof($fields);
            $flag=0;
            for($i=0; $i<$length; $i++)
            {
                if($fields[$i]->status == 1)
                {
                    $flag++;
                    $field_values = unserialize($fields[$i]->field_values);
                    return response()->json($field_values);        
                }
            }
            if($flag==0)
            {
                $field_values = [];
                return response()->json($field_values);    
            }
            
        }
        else {
            $field_values = [];
            return response()->json($field_values);
        }
    }

    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCategoryDetails(Request $request){
        $category_info = $this->adsService->findCategoryById($request->category_id);
        return $category_info;
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAds($slug){
        $data = $this->adsService->editAds($slug);

        $this->setPageTitle('Edit Ad', '');
        return view('site.ads.edit',compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAds(Request $request){
        $ad = $this->adsService->updateAd($request);

        if (!$ad) {
            return redirect()->back()->with('error-message','Failed to update your ad');
        }
        return redirect()->back()->with('success-message','Your ad has been updated successfully');
    }

    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCategoryFieldValues(Request $request){
        $values = $this->adsService->findFormValueByAdId($request->ad_id,$request->key);
        //$field_values = unserialize($fields[0]->field_values);

        return response()->json($values);
    }

    /**
     * @param request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRateValues(Request $request){
        $values = $this->adsService->findRatesValueByAdId($request->ad_id);
        //$rates = unserialize($values[0]->value);

        return response()->json($values);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function dropzoneUpdate(Request $request){
        $image = $this->adsService->uploadImage($request);

        return response()->json(['name'=>$image]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getImages($id){
        $images = $this->adsService->fetchImagesByAdId($id);

        return response()->json(['images'=>$images]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateImage(Request $request){
        $image = $this->adsService->updateImageForAd($request);

        return response()->json(['response'=>'success']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deleteImage(Request $request){
        $image = $this->adsService->deleteImageForAd($request);

        return response()->json(['response'=>'success']);
    }
}