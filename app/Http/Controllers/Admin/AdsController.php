<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Admin\AdsService;
use App\Services\Admin\PackageService;
use Illuminate\Support\Collection;

class AdsController extends BaseController
{
    protected $adsService;

    /**
     * AdsController constructor
     * @param AdsService $adsService
     */
    public function __construct(AdsService $adsService, PackageService $packageService)
    {
        $this->adsService = $adsService;
        $this->packageService = $packageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type=null)
    {
        $all_ads = $this->adsService->fetchAllAds();
        $collection = collect($all_ads);
        if($type == 'inactive')
        {
            // $filtered = $collection->whereIn('is_blocked',1);
            $filtered = $collection->filter(function($ad){
                return $ad->is_blocked == 1;
            });
            $ads = $filtered->all();
            $this->setPageTitle('Inactive Ads', '');
            return view('admin.ads.index', compact('ads'));
        }else if($type == 'active'){

            $filtered = $collection->filter(function($ad){
                    return $ad->is_blocked == 0;
            });
            $ads = $filtered->all();
            $this->setPageTitle('Active Ads', '');
            return view('admin.ads.index', compact('ads'));
        }
        
        $ads = $all_ads;
        $this->setPageTitle('Ads', '');
        return view('admin.ads.index', compact('ads'));
        
        
    }

    public function getAllAdsMessages(){
        $messages = $this->adsService->fetchAllAdsMessages();

        $this->setPageTitle('Messages', 'List of all messages');
        return view('admin.ads.ads_messages', compact('messages'));
    }

    public function getAllAdsReports(){
        $reports = $this->adsService->fetchAllAdsReports();

        $this->setPageTitle('Ads Reports', 'List of all ads reports');
        return view('admin.ads.ads_reports', compact('reports'));
    }

    public function updateStatus(Request $request){
        $ad = $this->adsService->updateAdStatus($request->ad_id,$request->is_blocked);

        if ($ad) {
            return response()->json(array('message'=>'Advert status successfully updated'));
        }
    }

    public function showAdImages(){
        $images = $this->adsService->fetchGalleryImages();
        
        $this->setPageTitle('Ads images', 'List of ad images');
        return view('admin.ads.ads_images', compact('images'));
    }

    public function viewAd($id)
    {
        $single_ad = $this->adsService->fetchAdById($id);
    
        $add_on_details = $single_ad->packages()->where('package_type','=','add_on')->get();
        foreach ($add_on_details as $package_detail) {
            $add_on_detail = $this->packageService->fetchPackageById($package_detail->package_id);
            $package_detail->add_on_name = $add_on_detail->name;
        }
        $messages = $this->adsService->fetchMessagesByAdId($id);
        $reports = $this->adsService->fetchReportsByAdId($id);

        $ad_name = $single_ad->title;
        $this->setPageTitle('Ads', $ad_name);
        return view('admin.ads.ad_view',compact('single_ad','add_on_details','messages','reports'));
    }

    public function viewAdMessage($id)
    {
        $single_ad_msg = $this->adsService->fetchAdMessageById($id);
        $single_ad = $this->adsService->fetchAdById($single_ad_msg->ad_id);
        $ad_title = $single_ad->title;
        $this->setPageTitle($ad_title, $single_ad_msg->subject);
        return view('admin.ads.ad_message_view',compact('single_ad_msg','ad_title'));
    }

    public function viewAdReport($id)
    {
        $single_ad_report = $this->adsService->fetchReportDetailsById($id)[0];

        $ad_title = $single_ad_report->ad->title;
        $ad_uniqueID = $single_ad_report->ad->unique_id;
        $this->setPageTitle('Report Details',$ad_title);
        return view('admin.ads.ad_report_view',compact('single_ad_report','ad_title', 'ad_uniqueID'));
    }
}