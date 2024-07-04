<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePriceTime extends Model
{
    protected $table = 'package_duration_price';
    protected $fillable = [
       'package_id', 'price', 'duration'
    ];
    public function package()
    {
        return $this->belongsTo('App\Models\Package','id','package_id');
    }
}
