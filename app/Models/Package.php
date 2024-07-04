<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Package extends Model
{
    use SoftDeletes;

    protected $table = 'packages';

	protected $fillable = [
	   'package_type', 'name', 'description', 'status', 'image'
	];

    public function package_duration_price()
    {
        return $this->hasMany('App\Models\PackagePriceTime','package_id','id');
    }

    public function ad_packages()
    {
        return $this->hasMany('App\Models\AdPackages','package_id','id');
    }

}
