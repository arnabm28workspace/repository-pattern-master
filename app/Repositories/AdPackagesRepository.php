<?php
namespace App\Repositories;

use App\Models\AdPackages;
use App\Contracts\AdPackagesContract;
use App\Traits\UploadAble;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;

/**
 * Class AdsRepository
 *
 * @package \App\Repositories
 */
class AdPackagesRepository extends BaseRepository implements AdPackagesContract
{
    use UploadAble;

    /**
     * AdPackagesRepository constructor.
     * @param AdPackages $model
     */
    public function __construct(AdPackages $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getPackageDetails($id){
        return $this->model::where('ad_id',$id)->where('package_type','basic_package')->where('expiry_date','>',\Carbon\Carbon::now()->toDateString())->get();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function storePaymentAdPackageDetails(array $params){
        $package_id = $params["package_id"];
        $package_duration = $params['package_duration'];
        $ad_id = $params['ad_id'];
        $package_id = $params['package_id'];
        $package_name = $params['package_name'];
        $add_on_id = $params['add_on_id'];
        $add_on_duration = $params['add_on_duration'];
        $package_amount = $params['package_amount'];
        $add_on_amount = $params['add_on_amount'];
        $add_on_arr = json_decode($params['ad_arr']);
        $renew_date = \Carbon\Carbon::now()->add($package_duration, 'day');

        if($package_id!=''){
         $adPackages = new AdPackages;
         $adPackages->ad_id = $ad_id;
         $adPackages->package_id = $package_id;
         $adPackages->price = $package_amount;
         $adPackages->duration = $package_duration;
         $adPackages->expiry_date = $renew_date;
         $adPackages->package_type = 'basic_package';
         $adPackages->save();
        }

        if(count($add_on_arr)>0){
         foreach($add_on_arr as $ad){
             $adPackages = new AdPackages;
             $adPackages->ad_id = $ad_id;
             $adPackages->package_id = $ad->id;
             $adPackages->duration = $ad->duration;
             $adPackages->price = $ad->price;
             $adPackages->expiry_date = \Carbon\Carbon::now()->add($ad->duration, 'day');;
             $adPackages->package_type = 'add_on';
             $adPackages->save();
         }
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function upgradePaymentAdPackageDetails(array $params){
        $package_id = (isset($params["package_id"]) && $params["package_id"]!='')?$params["package_id"]:0;
        $package_duration = $params['package_duration'];
        $ad_id = $params['ad_id'];
        $package_id = $package_id;
        $package_name = $params['package_name'];
        $add_on_id = $params['add_on_id'];
        $add_on_duration = $params['add_on_duration'];
        $package_amount = $params['package_amount'];
        $add_on_amount = $params['add_on_amount'];
        $pay_type = $params['pay_type'];
        $add_on_arr = json_decode($params['ad_arr']);
        $renew_date = \Carbon\Carbon::now()->add($package_duration, 'day');
        if($pay_type=='upgrade'){
         if($package_id!=0){
             AdPackages::where('ad_id',$ad_id)->where('package_type','basic_package')->delete();
             $adPackages = new AdPackages;
             $adPackages->ad_id = $ad_id;
             $adPackages->package_id = $package_id;
             $adPackages->price = $package_amount;
             $adPackages->duration = $package_duration;
             $adPackages->expiry_date = $renew_date;
             $adPackages->package_type = 'basic_package';
             $adPackages->save();
         }
        }else if($pay_type=='renew'){
         if($package_id!=0){
             $last_package = AdPackages::where('ad_id',$ad_id)->where('package_type','basic_package')->get();

             if(count($last_package)>0){
                 $r_date = \Carbon\Carbon::parse($last_package[0]->expiry_date)->add($package_duration, 'day');
             }else{
                 $r_date = $renew_date;
             }

             AdPackages::where('ad_id',$ad_id)->where('package_type','basic_package')->delete();
             $adPackages = new AdPackages;
             $adPackages->ad_id = $ad_id;
             $adPackages->package_id = $package_id;
             $adPackages->price = $package_amount;
             $adPackages->duration = $package_duration;
             $adPackages->expiry_date = $r_date;
             $adPackages->package_type = 'basic_package';
             $adPackages->save();
         }
        }
        

        if(count($add_on_arr)>0){
         AdPackages::where('ad_id',$ad_id)->where('package_type','add_on')->delete();
         foreach($add_on_arr as $ad){
             $adPackages = new AdPackages;
             $adPackages->ad_id = $ad_id;
             $adPackages->package_id = $ad->id;
             $adPackages->duration = $ad->duration;
             $adPackages->price = $ad->price;
             $adPackages->expiry_date = \Carbon\Carbon::now()->add($ad->duration, 'day');;
             $adPackages->package_type = 'add_on';
             $adPackages->save();
         }
        }

        return true;
    }

    /**
     * @param array $payment
     * @return mixed
     */
    public function getPaymentAdPackageDetails(array $payment){
        if(count($payment)>0){
         return AdPackages::with('ad')->with('package')->where('ad_id',$payment[0]->ad_id)->get();
        }else{
         return array();
        }
    } 
}