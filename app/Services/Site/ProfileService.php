<?php

namespace App\Services\Site;

use App\Contracts\ProfileContract;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class ProfileService
{
	protected $profileRepository;

	/**
     * ProfileService constructor
     */
    public function __construct(ProfileContract $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Fetch user profile information
     * @return mixed
     */
    public function fetchUserProfile(){
    	return $this->profileRepository->showProfile();
    }

    /**
     * Save user profile information
     * @param Request $request
     * @return mixed
     */
    public function updateOrStoreProfileData($request){
    	$user_id = auth()->user()->id;
        $params = $request->except('_token');

        $profileResponse = $this->profileRepository->updateorcreateProfile($params,$user_id); 

        if($profileResponse){
        	if (!is_null($params['contact_name'])){
                User::where('id', $user_id)->update(['name' => $params['contact_name']]);
            }
        }

        return $profileResponse;
    }
}