<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    protected $table = 'payment_details';
    protected $fillable = ['payment_id','ad_id','package_id','price','duration']; 

    //hasOne relation with Package Model
	public function package(){
	    return $this->hasOne(Package::class, 'id', 'package_id');
	}

	//hasOne relation with Ad Model
	public function ad(){
	    return $this->hasOne(Ads::class, 'id', 'package_id');
	}
}
