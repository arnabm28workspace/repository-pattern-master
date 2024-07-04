<?php
namespace App\Repositories;

use App\Models\Profile;
use App\Contracts\ProfileContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;

/**
 * Class PageTypeRepository
 *
 * @package \App\Repositories
 */
class ProfileRepository implements ProfileContract
{

    /**
     * ProfileRepository constructor.
     * @param Profile $model
     */
    public function __construct(Profile $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function showProfile() {
        $user = Auth::user()->id;
        $profileDetails = Profile::where('user_id','=',$user)->first();
        return $profileDetails;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function showProfileById(int $user_id) {
        $profileDetails = Profile::where('user_id','=',$user_id)->first();
        return $profileDetails;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateorcreateProfile(array $params, int $id) {

        $collection = collect($params);
        $notification_newsletter = ($collection->has("notification_newsletter")) ? 1 : 0;
        $notification_repost = ($collection->has("notification_repost")) ? 1 : 0;
        if(!empty($collection['company_name']) && !empty($collection['company_registration_number']) && !empty($collection['company_vat_number']) && !empty($collection['post_code']) && !empty($collection['phone_number']) && !empty($collection['website_url']))
        {
            $is_profile_complete = 1;
        }else{
            $is_profile_complete = 0;
        }
        $response = Profile::updateOrCreate(['user_id'   => $id,],
            [
                'company_name' => $collection['company_name'],
                'company_registration_number' => $collection['company_registration_number'],
                'company_vat_number' => $collection['company_vat_number'],
                'post_code' => $collection['post_code'],
                'phone_number' => $collection['phone_number'],
                'notification_newsletter' => $notification_newsletter,
                'notification_repost' => $notification_repost,
                'website_url' => $collection['website_url'],
                'is_profile_complete' => $is_profile_complete
            ]);
        if($response)
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProfile(array $params, int $id) {
        $updateProfile = Profile::where('user_id',$id)->update($params);
    }

}