<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    public function setNameAttribute($value)
	{
	    $this->attributes['name'] = $value;
	    $this->attributes['slug'] = str_slug($value);
	}

    public function city_list()
    {
        return $this->hasMany('App\Models\City','country_id','id');
    }
}
