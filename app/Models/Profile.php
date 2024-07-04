<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = [
       'user_id', 'company_name', 'company_registration_number','company_vat_number', 'post_code', 'phone_number','website_url','notification_newsletter','notification_repost','is_profile_complete','is_package'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
