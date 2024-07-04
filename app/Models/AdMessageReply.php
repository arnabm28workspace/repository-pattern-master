<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdMessageReply extends Model
{
    protected $table = 'admessagereply';

	protected $fillable = [
	   'message_id', 'reply_message'
	];
	public function admessage()
    {
        return $this->belongsTo(AdMessages::class,'message_id','id');
    }
}
