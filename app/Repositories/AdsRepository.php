<?php
namespace App\Repositories;

use App\Models\Ads;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AdsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;

/**
 * Class AdsRepository
 *
 * @package \App\Repositories
 */
class AdsRepository extends BaseRepository implements AdsContract
{
    use UploadAble;

    /**
     * PackageRepository constructor.
     * @param Package $model
     */
    public function __construct(Ads $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAds(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function vipAds(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort)->where('is_vip','1');
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function myAds(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return Ads::with('images', 'category', 'country', 'packages', 'payment')->where('user_id', Auth::user()->id)->where('is_payment', true)->orderBy('id', 'DESC')->get();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findAdsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return ads|mixed
     */
    public function createAds(array $params)
    {
        try {
            $adData = array();
            $collection = collect($params);

            $documents = $collection['document'];

            $ads = new Ads;
            $ads->unique_id = $collection['unique_id'];
            $ads->user_id = $collection['user_id'];
            $ads->title = $collection['title'];
            $ads->slug = '';
            $ads->description = $collection['description'];
            $ads->category_id = $collection['category_id'];
            $ads->country_id = $collection['country_id'];
            $ads->city = $collection['city'];
            $ads->type = $collection['type'];
            $ads->email = $collection['email'];
            $ads->phone = $collection['phone'];
            $ads->website = $collection['website'];
            $ads->price = $collection['price'];
            $ads->views = 0;
            $ads->is_blocked = 0;
            $ads->is_payment = false;

            $ads->save();

            $adData= array("ads"=>$ads,
                    "collection"=>$collection);

            return $adData;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAds(array $params)
    {
        $ads = $this->findAdsById($params['id']);
        $collection = collect($params)->except('_token');
        $ads->unique_id = $collection['unique_id'];
        //$ads->user_id = $collection['user_id'];
        $ads->title = $collection['title'];
        $ads->description = $collection['description'];
        $ads->category_id = $collection['category_id'];
        $ads->country_id = $collection['country_id'];
        $ads->city = $collection['city'];
        $ads->type = $collection['type'];
        $ads->price = $collection['price'];
        $ads->email = $collection['email'];
        $ads->phone = $collection['phone'];
        $ads->website = $collection['website'];
        $ads->is_blocked = 0;

        $ads->save();

        $adData= array("ads"=>$ads,
                "collection"=>$collection);

        return $adData;

    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteAds($id)
    {
        $ads = $this->findAdsById($id);

        $ads->delete();

        return $ads;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function uploadAdImage(array $params)
    {
        try {
            $collection = collect($params);
            $image = null;
            if ($collection->has('file') && ($params['file'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['file'], 'posts');
            }
            
            return $image;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function fetchAllAds(){
        $ads = array();
        $adDatas = Ads::with('images')->with('category')->with('country')->with('packages')->with('payment')->orderBy('id', 'DESC')->get();

        foreach($adDatas as $ad){
            if(count($ad->packages)>0 && $ad->packages[0]->expiry_date>= \Carbon\Carbon::now()->toDateString()){
                array_push($ads, $ad);
            }
        }

        return $ads;
    }

    /**
     * @return mixed
     */
    public function getAds($params=[])
    {
        $query = Ads::with('images', 'category', 'country', 'packages', 'payment')->where('is_blocked', 0)->where('is_payment', true);
        
        if (isset($params) && collect($params)->has('country_id')){
            $query->Where(function ($query) use ($params){
                $query->where('country_id', $params['country_id'])
                    ->orWhere('city', $params['country_city'])
                    ->orWhere('category_id', $params['country_category']);
            });
        }
        if (isset($params) && collect($params)->has('city')){
            $query->Where(function ($query) use ($params){
                $query->where('city', $params['city'])
                    ->orWhere('category_id', $params['city_id']);
            });
        }
        if (isset($params) && collect($params)->has('category_id')) {
            $query->Where(function ($query) use ($params){
                $query->where('category_id', $params['category_id']);
            });
        }

        $ads = $query->orderBy('id', 'DESC')->get();
        //dd($query->orderBy('id', 'DESC')->toSql());
        return $ads;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateAdStatus(array $params){
        $ads = $this->findAdsById($params['id']);
        $collection = collect($params)->except('_token');
        $ads->is_blocked = $collection['is_blocked'];
        $ads->save();

        return $ads;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAdPaymentStatus(array $params){
        $ads = $this->findAdsById($params['id']);
        $collection = collect($params)->except('_token');
        $ads->is_payment = $collection['is_payment'];
        $ads->save();

        return $ads;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetchAdsByUser($id,string $order = 'id', string $sort = 'desc', array $columns = ['*']){
        
        return Ads::with('images', 'category', 'country', 'packages', 'payment')->where('user_id',$id)->get();
    }

    /**
     * @param string slug
     * @return mixed
     */
    public function getAdDetails($slug){
        Ads::where('slug',$slug)->increment('views');

        return Ads::with('images')->with('category')->with('country')->with('packages')->with('payment')->with('ad_details')->where('slug',$slug)->get();
    }

    /**
     * @param string slug
     * @return mixed
     */
    public function getAdPreview($slug){
        return Ads::with('images')->with('category')->with('country')->with('packages')->with('payment')->with('ad_details')->where('slug',$slug)->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getAdDetailsById($id){
        return Ads::with('images')->with('category')->with('country')->with('packages')->with('payment')->with('ad_details')->where('id',$id)->get();
    }

    /**
     * Fetch messages by user id
     */
    public function fetchMessagesByUserId(){
        $user_id = auth()->user()->id;
        $allMessages = array();
        $ads = auth()->user()->ads()->get();
        foreach ($ads as $key=>$ad) {
            $message = [];
            $message = $ad->messages()->get();
            if(count($message)>0)
            {
                array_push($allMessages, $message);
            }
        }
        
        return $allMessages;
        
    }

}