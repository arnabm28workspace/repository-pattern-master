<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdDetails extends Model
{
    protected $table = 'ad_details';

	protected $fillable = [
	   'ad_id', 'key', 'value', 'type'
	];

	public function ad()
    {
        return $this->belongsTo('App\Models\Ads','id','ad_id');
    }
}
