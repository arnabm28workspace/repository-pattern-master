<?php
namespace App\Repositories;

use App\Models\AdDetails;
use App\Contracts\AdDetailsContract;
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
class AdDetailsRepository extends BaseRepository implements AdDetailsContract
{
    use UploadAble;

    /**
     * PackageRepository constructor.
     * @param Package $model
     */
    public function __construct(AdDetails $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function storeAdDetails(array $params)
    {
    	$ratesArr = array();
    	$collection = $params['collection'];
    	$ad_id = $params['ads']->id;
    	foreach($collection as $key=>$value){
    	    if($key!='country_id' && $key!='city' && $key!='category_id' && $key!='title' && $key!='description' && $key!='phone' && $key!='email' && $key!='website' && $key!='document' && $key!='unique_id' && $key!='user_id' && $key!='type' && $key!='id' && $key!='price') {
    	        
    	        if($key=='incall' || $key=='outcall' || $key=='time'){
    	            $type = 'rate';
    	            $data['key'] = $key;
    	            $data['val'] = $value;
    	            array_push($ratesArr, $data);
    	        }else{
    	            //$type = 'normal';
    	            if(is_array($value)){
    	                $adDetails = new $this->model;
    	                $adDetails->ad_id = $ad_id;
    	                $adDetails->key = $key;
    	                $adDetails->type = "normal";
    	                $adDetails->value = implode(', ', $value);
    	                $adDetails->save();
    	            }else{
    	                if($value!=''){
    	                    $adDetails = new $this->model;
    	                    $adDetails->ad_id = $ad_id;
    	                    $adDetails->key = $key;
    	                    $adDetails->type = "normal";
    	                    $adDetails->value = $value;
    	                    $adDetails->save();
    	                }
    	            }
    	        }
    	        
    	    }
    	}
    	if(!empty($ratesArr))
    	{
    	    $arrval = json_encode($ratesArr);
    	    $adDetails = new $this->model;
    	    $adDetails->ad_id = $ad_id;
    	    $adDetails->key = "rates";
    	    $adDetails->type = "rate";
    	    $adDetails->value = $arrval;
    	    $adDetails->save();

    	}

    	return $adDetails;
    }

    public function updateAdDetails(array $params)
    {
    	$collection = $params['collection'];
    	$ad_id = $params['ads']->id;
    	$this->model::where("ad_id",$ad_id)->delete();
    	$ratesArr = array();
    	foreach($collection as $key=>$value){
    	    if($key!='country_id' && $key!='city' && $key!='category_id' && $key!='title' && $key!='description' && $key!='phone' && $key!='email' && $key!='website' && $key!='document' && $key!='unique_id' && $key!='user_id' && $key!='type' && $key!='id' && $key!='price') {
    	        
    	        if($key=='incall' || $key=='outcall' || $key=='time'){
    	            $type = 'rate';
    	            $data['key'] = $key;
    	            $data['val'] = $value;
    	            array_push($ratesArr, $data);
    	        }else{
    	            //$type = 'normal';
    	            if(is_array($value)){
    	                $adDetails = new $this->model;
    	                $adDetails->ad_id = $ad_id;
    	                $adDetails->key = $key;
    	                $adDetails->type = "normal";
    	                $adDetails->value = implode(', ', $value);
    	                $adDetails->save();
    	            }else{
    	                if($value!=''){
    	                    $adDetails = new $this->model;
    	                    $adDetails->ad_id = $ad_id;
    	                    $adDetails->key = $key;
    	                    $adDetails->type = "normal";
    	                    $adDetails->value = $value;
    	                    $adDetails->save();
    	                }
    	            }
    	        }
    	        
    	    }
    	}
    	if(!empty($ratesArr))
    	{
    	    $arrval = json_encode($ratesArr);
    	    $adDetails = new $this->model;
    	    $adDetails->ad_id = $ad_id;
    	    $adDetails->key = "rates";
    	    $adDetails->type = "rate";
    	    $adDetails->value = $arrval;
    	    $adDetails->save();
    	}

		return !empty($adDetails) ? $adDetails:true;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCustomFieldValue($id,$key){
        return $this->model::where('ad_id',$id)->where('key',$key)->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getRatesValue($id){
        return $this->model::where('ad_id',$id)->where('type','rate')->get();
    }
}