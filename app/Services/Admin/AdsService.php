<?php

namespace App\Services\Admin;

use App\Contracts\AdsContract;
use App\Contracts\AdsImageContract;
use App\Contracts\AdsMessagesContract;
use App\Contracts\AdsReportsContract;
use App\Contracts\PackageContract;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdsService
{
	protected $adsRepository;
    protected $adsImageRepository;
    protected $adsMessagesRepository;
    protected $adsReportRepository;
    protected $packageRepository;

    /**
     * class AdsService constructor
     */
    public function __construct(AdsContract $adsRepository, AdsImageContract $adsImageRepository,AdsMessagesContract $adsMessagesRepository, AdsReportsContract $adsReportRepository, PackageContract $packageRepository)
    {
        $this->adsRepository = $adsRepository;
        $this->adsImageRepository = $adsImageRepository;
        $this->adsMessagesRepository = $adsMessagesRepository;
        $this->adsReportRepository = $adsReportRepository;
        $this->packageRepository = $packageRepository;
    }

    /**
     * Fetch Ad by id
     * @return mixed
     */
    public function fetchAdById($id){
        $adData = $this->adsRepository->getAdDetailsById($id)[0];

        $packages = $adData->packages;

        $package_name = '';
        $package_expire_date = '';
        $add_on_name = '';
        $add_on_expire_date = '';
        foreach ($packages as $p) {
            if($p->package_type=='basic_package'){
                $package_name = $this->packageRepository->findPackageById($p->package_id)->name;
                $package_expire_date = $p->expiry_date;
            }

            if($p->package_type=='add_on'){
                $add_on_name = $this->packageRepository->findPackageById($p->package_id)->name;
                $add_on_expire_date = $p->expiry_date;
            }
        }

        $adData->package_name = $package_name;
        $adData->package_expire_date = $package_expire_date;
        $adData->add_on_name = $add_on_name;
        $adData->add_on_expire_date = $add_on_expire_date;

        return $adData;
    }


    /**
     * Fetch List of All Ads
     * @return mixed
     */
    public function fetchAllAds(){
    	$ads = array();
    	$adDatas = $this->adsRepository->listAds();

        foreach($adDatas as $ad){
            $ad->image = $this->adsImageRepository->firstImage($ad->id);
            $packages = $ad->packages;

            $package_name = '';
            $package_expire_date = '';
            $add_on_name = '';
            $add_on_expire_date = '';
            foreach ($packages as $p) {
                if($p->package_type=='basic_package'){
                    $package_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $package_expire_date = $p->expiry_date;
                }

                if($p->package_type=='add_on'){
                    $add_on_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $add_on_expire_date = $p->expiry_date;
                }
            }

            $ad->package_name = $package_name;
            $ad->package_expire_date = $package_expire_date;
            $ad->add_on_name = $add_on_name;
            $ad->add_on_expire_date = $add_on_expire_date;
            array_push($ads, $ad);
        }
        return $ads;
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
     * Fetch List of Ads Messages
     * @return mixed
     */
    public function fetchAllAdsMessages() {
        return $this->adsMessagesRepository->getAllMessages();
    }

    /**
     * Fetch List of Ads Reports
     * @return mixed
     */
    public function fetchAllAdsReports() {
        return $this->adsReportRepository->getAllReports();
    }

    /**
     * Fetch List of Ads Images
     * @return mixed
     */
    public function fetchAllImagesByAdId($id){
        return $this->adsImageRepository->listAdsImage($ad->id);
    }

    /**
     * Fetch Message by id
     * @param int $id
     * @return mixed
     */
    public function fetchAdMessageById($id){
        return $this->adsMessagesRepository->findAdsMessageById($id);
    }

    /**
     * Fetch List of Ads Images
     * @return mixed
     */
    public function fetchGalleryImages(){
        return $this->adsRepository->fetchAllAds();
    }

    /**
     * Fetch List of Messages by Ad Id
     * @param int $id
     * @return mixed
     */
    public function fetchMessagesByAdId($id){
        return $this->adsMessagesRepository->getAllMessagesByAdId($id);
    }

    /**
     * Fetch List of Reports by Ad Id
     * @param int $id
     * @return mixed
     */
    public function fetchReportsByAdId($id){
        return $this->adsReportRepository->getAllReportsByAdId($id);
    }

    /**
     * Fetch List of Reports by Ad Id
     * @param int $id
     * @return mixed
     */
    public function fetchReportDetailsById($id){
        return $this->adsReportRepository->getReportDetailsById($id);
    }
}