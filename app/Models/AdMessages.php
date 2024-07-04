<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdMessages extends Model
{
    protected $table = 'ad_messages';

	protected $fillable = [
	   'ad_id', 'user_id', 'email', 'phone', 'subject', 'message', 'is_read', 'reply_message'
	];

	public function ad()
    {
        return $this->belongsTo(Ads::class,'ad_id','id');
    }

    //hasMany relation with AdMessages
    public function replies(){
    	return $this->hasMany(AdMessageReply::class, 'message_id', 'id');
    }
}
