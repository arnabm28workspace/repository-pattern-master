<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	public $timestamps = false;
    protected $table = 'payments';
    protected $fillable = ['amount','user_id','package_id','payment_intent_id','payment_customer_id','paid_on','renew_on','ad_id','payment_info'];

	public function ad()
    {
        return $this->belongsTo(Ads::class,'ad_id','id');
    }

	//hasOne relation with Ads Model
	public function user(){
	    return $this->hasOne(User::class, 'id', 'user_id');
	}
}
