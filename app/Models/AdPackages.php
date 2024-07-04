<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdPackages;

class AdPackages extends Model
{
    protected $table = 'ad_packages';

	protected $fillable = [
	   'ad_id', 'package_id','price','duration', 'expire_date', 'package_type'
	];

	public function ad()
    {
        return $this->belongsTo('App\Models\Ads','ad_id','id');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package','package_id','id');
    }
}
