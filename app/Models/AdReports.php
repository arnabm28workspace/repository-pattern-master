<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdReports extends Model
{
    protected $table = 'ad_reports';

	protected $fillable = [
	   'ad_id', 'user_id', 'reason'
	];

	public function ad()
    {
        return $this->belongsTo(Ads::class,'ad_id','id');
    }

	//hasOne relation with User Model
	public function user(){
	    return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
