<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\Site\PageService;
use App\Services\Site\AdsService;
use App\Models\Country;
use App\Models\City;
use App\Models\Category;

class PageController extends BaseController
{
    protected $pageService;
    protected $adsService;

    /**
     * PageController constructor
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService, AdsService $adsService)
    {
        $this->pageService = $pageService;
        $this->adsService = $adsService;
    }

    /**
     * Privacy Policy Page Display 
     */
    public function index(Request $request)
    {
        try{
            if ($page = $this->pageService->findPageBySlug($request->route('page'))){
                $pageTitle = !empty($page->meta_title)?$page->meta_title:$page->cms_title;
                $this->setPageTitle($pageTitle,'');
                return view('site.home.page',compact('page'));
            }else {
                $country = Country::whereRaw('LOWER(`slug`) LIKE ? ',[trim(strtolower($request->route('page'))).'%'])->first();
                if(!empty($country)){
                    $page = $this->pageService->findPageByCountry($request->route('page'));
                }
                $selected_country = $request->route('page');
                $selected_city = '';
                $selected_category = '';
                $client_ip = $request->ip();
                if (empty($page)){
                    /* $locationInfoIP = \Location::get($client_ip);
                    $selected_country = strtolower($locationInfoIP->countryName);
                    $selected_city = strtolower($locationInfoIP->cityName); */
                }
                
                $search_terms = array('country' => $selected_country, 'city' => $selected_city, 'category' => $selected_category, 'ip_address' => $client_ip);
                $data = $this->adsService->fetchAdsBySearch($search_terms);
                
                $pageTitle = !empty($page)?(!empty($page->meta_title)?$page->meta_title:$page->cms_title):'Search';
                $this->setPageTitle($pageTitle,'');
                return view('site.ads.search',compact('data', 'selected_category', 'selected_country', 'selected_city', 'page'));
            }
        }catch(\Exception $e){
            abort(404);
        }
    }

    public function search(Request $request) {
        
        try{
            $page = null;
            $client_ip = $request->ip();
            $locationInfo = collect();
            $selected_country = $request->route('country');
            $selected_city = $request->route('city');
            $selected_category = $request->route('category');
            $locationInfo->put('country', $selected_country);
            $locationInfo->put('city', null);
            $locationInfo->put('category', null);
            if (!empty($selected_category)){
                $locationInfo->put('category', $selected_category);
            }
            
            if(!empty($selected_country) && !empty($selected_city)){
                $country = Country::whereRaw('LOWER(`slug`) LIKE ? ',[trim(strtolower($request->route('country'))).'%'])->first();
                if(!empty($country)){
                    $city = City::whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($selected_city)).'%'])->first();
                    if(!empty($city)){
                        $locationInfo->put('city', $selected_city);
                        
                        if (!empty($selected_category)){
                            $category = Category::whereRaw('LOWER(`slug`) LIKE ? ',[trim(strtolower($selected_category)).'%'])->first();
                            if (!empty($category)) {
                                $locationInfo->put('category', $selected_category);
                                $page = $this->pageService->findPage($locationInfo);
                            }
                        } else{
                            $page = $this->pageService->findPage($locationInfo);
                        }
                    }
                }
            }

            $search_terms = array('country' => $selected_country, 'city' => $selected_city, 'category' => $selected_category, 'ip_address' => $client_ip, 'search_from' => $request->session()->get('search_from'));
            
            $data = $this->adsService->fetchAdsBySearch($search_terms);

            $pageTitle = !empty($page)?(!empty($page->meta_title)?$page->meta_title:$page->cms_title):'Search';
            $this->setPageTitle($pageTitle,'');
            return view('site.ads.search',compact('data', 'selected_category', 'selected_country', 'selected_city', 'page'));
        }catch(\Exception $e){
            abort(404);
        }
    }

}
