<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\Admin\AdminService;
use App\Services\Admin\AdsService;
use Illuminate\Support\Collection;

class DashboardController extends BaseController
{
    /**
     * DashboardController constructor
     * @param AdsService $adsService
     * @param AdminService $adminService
     */
    public function __construct(AdsService $adsService, AdminService $adminService)
    {
        $this->adsService = $adsService;
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_users = $this->adminService->fetchUsers();
        $users = sizeof($all_users);
        $all_ads = $this->adsService->fetchAllAds();
        $collection_all_ads = collect($all_ads);
        $filtered_inactive = $collection_all_ads->filter(function($ad){
                return $ad->is_blocked == 1;
            });
        $inactive_ads = sizeof($filtered_inactive->all());
        $filtered_active = $collection_all_ads->filter(function($ad){
                return $ad->is_blocked == 0;
            });
        $active_ads = sizeof($filtered_active->all());

        return view('admin.dashboard.index', compact('users','active_ads','inactive_ads'));
    }
}
