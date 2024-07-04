<?php
namespace App\Repositories;

use App\Models\Package;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PackageContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

/**
 * Class PackageRepository
 *
 * @package \App\Repositories
 */
class PackageRepository extends BaseRepository implements PackageContract
{
    use UploadAble;

    /**
     * PackageRepository constructor.
     * @param Package $model
     */
    public function __construct(Package $model)
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
    public function listPackages(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPackageById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Category|mixed
     */
    public function createPackage(array $params)
    {
    
        try {
            $collection = collect($params);
            $image = null;
            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'packages');
            }
            $i=0;
            $price_duration_array = [];
            $package = new Package;
            $package->package_type = $collection['package_type'];
            $package->name = $collection['name'];
            $package->description = $collection['description'];
            $package->status = $collection->has('status') ? true : false; //In toggle checked means block 
            $package->image = $image;
            foreach ($collection['price'] as $price) {
                    if(!empty($collection['price'][$i]) || !empty($collection['duration'][$i]))
                    {
                        array_push($price_duration_array,['price'=>$collection['price'][$i],'duration'=>$collection['duration'][$i]]);    
                    }
                    
                $i++;
            }
            $package_id = $package->save();
            $package->package_duration_price()->createMany($price_duration_array);
            return $package;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePackage(array $params)
    {
        $package = $this->findPackageById($params['id']);
        $collection = collect($params)->except('_token');

        $image = $package->image;       
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($package->image != null) {
                $this->deleteOne($package->image);
            }

            $image = $this->uploadOne($params['image'], 'packages');
        }

        $i=0;
        $price_duration_array = [];
        $package->package_type = $collection['package_type'];
        $package->name = $collection['name'];
        $package->description = $collection['description'];
        $package->status = $collection->has('status') ? true : false; //In toggle checked means block
        $package->image = $image;
        foreach ($collection['price'] as $price) {
                if(!empty($collection['price'][$i]) || !empty($collection['duration'][$i]))
                {
                    array_push($price_duration_array,['price'=>$collection['price'][$i],'duration'=>$collection['duration'][$i]]);    
                }
                
            $i++;
        }
        $package->save();
        $package->package_duration_price()->delete();
        $package->package_duration_price()->createMany($price_duration_array);
        return $package;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletePackage($id)
    {
        $package = $this->findPackageById($id);

        $package->delete();
        $package->package_duration_price()->delete();

        return $package;
    }

    /**
     * @return mixed
     */
    public function fetchPackageWithPriceDuration(){
        $packages = Package::with('package_duration_price')->where('status','1')->get();
        $packages = $packages->filter(function($package){
                if(sizeof($package->package_duration_price()->get())>0)
                    return $package;
            });
        return $packages;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePackageStatus(array $params)
    {
        $collection = collect($params)->except('_token');
        $package = $this->findPackageById($params['id']);
        $package->status = $params['status'];
        $package->save();
        return $package;
    }
}