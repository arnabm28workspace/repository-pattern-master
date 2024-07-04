<?php
namespace App\Repositories;

use App\Models\AdsImage;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AdsImageContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;


/**
 * Class AdsRepository
 *
 * @package \App\Repositories
 */
class AdsImageRepository extends BaseRepository implements AdsImageContract
{
    use UploadAble;

    /**
     * PackageRepository constructor.
     * @param Package $model
     */
    public function __construct(AdsImage $model)
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
    public function listAdsImage($ad_id,string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort)->where('ad_id',$ad_id);
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function firstImage($ad_id,string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort)->where('ad_id',$ad_id)->first();;
    }

    public function getAllImages(){
        $images = AdsImage::select("ads_images.*","ads.title")
                      ->leftjoin("ads", "ads_images.ad_id", "=", "ads.id")
                      ->get();

        return $images;
    }

    public function getImagesByAdId($id){
        return AdsImage::where('ad_id',$id)->get();
    }

    public function storeImage(array $params){
        $adsImage = new AdsImage;
        $adsImage->ad_id = $params['ad_id'];
        $adsImage->image = $params['image'];
        $adsImage->save();
        return true;
    }

    public function deleteImage(array $params){
        $ad_id = $params['ad_id'];
        $image_name = 'ads/'.$params['image'];

        AdsImage::where('ad_id',$ad_id)->where('image',$image_name)->delete();

        return true;
    }
}