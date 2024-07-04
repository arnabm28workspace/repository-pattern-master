<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Profile;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','is_approve',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
    $this->notify(new \App\Notifications\UserEmailVerifyNotification($this));
    }

    public function sendPasswordResetNotification($token)
    {
    $this->notify(new \App\Notifications\UserResetPasswordNotification($token,$this));
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


    //hasMany relation with AdReports Model
    public function ad_reports(){
        return $this->hasMany(Payment::class,'user_id','id');
    }

    public function ads()
    {
        return $this->hasMany(Ads::class,'user_id','id');    
    }

    /**
     *
     */
    public static function countUnreadMessages()
    {
        $count_unread_messages = 0;
        $allMessages = array();
        $messages = array();
        $user_id = auth()->user()->ads();
        $ads = auth()->user()->ads()->get();
        foreach ($ads as $key=>$ad) {
            $message = [];
            $message = $ad->messages()->get();
            if(count($message)>0)
            {
                array_push($allMessages, $message);
            }
        }
        foreach ($allMessages as $key => $mymessages) {
            foreach ($mymessages as $key => $message) {
                array_push($messages, $message);
            }
        }
        foreach ($messages as $key => $value) {
            if($value->is_read == 0)
                $count_unread_messages++;
        }

        return $count_unread_messages;
    }

}
