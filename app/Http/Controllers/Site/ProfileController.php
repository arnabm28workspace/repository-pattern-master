<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Site\ProfileService;
use App\Services\Site\AdsService;
use Auth;
use App\Models\User;
use Illuminate\Support\Collection;

class ProfileController extends BaseController
{

    protected $profileService;
    protected $adsService;
  
    /**
     * ProfileController constructor
     */
    public function __construct(ProfileService $profileService,AdsService $adsService)
    {
        $this->profileService = $profileService;
        $this->adsService = $adsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_profile = $this->profileService->fetchUserProfile();

        $this->setPageTitle('My Profile', '');
        return view('site.profile.index',['currentUserProfile'=>$user_profile,'user_email'=>auth()->user()->email,'user_name'=>auth()->user()->name]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {
        $profile = $this->profileService->updateOrStoreProfileData($request);

        if($profile){
           return redirect()->back()->with('success-message','Saved Successfully');
        }
    }

    /**
     * Fetch all the ads created by user
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchUserAds($type = ''){
        $ads = $this->adsService->fetchMyAds($type);
        $countLiveAds = count($this->adsService->fetchMyAds('live'));
        $countExpiredAds = count($this->adsService->fetchMyAds('expired'));
        $countDraftAds = count($this->adsService->fetchDraftAds());
        $totalCount = ($countLiveAds + $countExpiredAds);
        $this->setPageTitle('My Ads', '');

        if($type == 'live'){
            return view('site.profile.live',compact('ads', 'countLiveAds', 'countExpiredAds', 'countDraftAds', 'totalCount'));
        }else if($type == 'expired'){
            return view('site.profile.expired',compact('ads', 'countLiveAds', 'countExpiredAds', 'countDraftAds', 'totalCount'));
        }else if($type == 'draft'){
            return view('site.profile.draft',compact('ads', 'countLiveAds', 'countExpiredAds', 'countDraftAds', 'totalCount'));
        } else {
            return view('site.profile.ads',compact('ads', 'countLiveAds', 'countExpiredAds', 'countDraftAds', 'totalCount'));
        }
    }

    /**
     * Fetch all the messages by user id
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchUserMessages($type = ''){
        $allMessageDetails = $this->adsService->fetchMessagesByUserId();
        $messages = array();
        $messageByAdId = array();
        foreach ($allMessageDetails as $key => $mymessages) {
            foreach ($mymessages as $key => $message) {
                array_push($messages, $message);
            }
        }
        // dd($messages);
        $this->setPageTitle('My Messages', '');

        if(!empty($type))
        {
            foreach ($messages as $message) {
                if($message->ad_id == $type)
                {
                    array_push($messageByAdId, $message);
                }
            }
            $messages = $messageByAdId;
            return view('site.profile.messages',compact('messages'));
        }else{

            return view('site.profile.messages',compact('messages'));
        }
    
    }

    /**
     *
     */
    public function updateMessageStatus(Request $request)
    {
        return $this->adsService->updateMessageStatus($request->msg_id);
    }

    /**
     * Fetch all the payments created by user
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchUserPayments(){
        $payments = $this->adsService->fetchPaymentsByUserId();
        $this->setPageTitle('Payments', '');
        return view('site.profile.payments',compact('payments'));
    
    }

    /**
     * @param $key
     * Display a listing of the resource.
     * * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview($key){
        $data = $this->adsService->fetchAdPreview($key);

        $this->setPageTitle($data['ad']->title, '');
        return view('site.profile.preview',compact('data')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }

}
