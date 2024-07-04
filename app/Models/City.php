<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

	protected $fillable = [
	   'country_id', 'name'
	];

	public function setNameAttribute($value)
	{
	    $this->attributes['name'] = $value;
	    $this->attributes['slug'] = str_slug($value);
	}

	public function country()
	{
	    return $this->belongsTo('App\Models\Country','id','country_id');
	}
}
