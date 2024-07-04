<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table = 'ads';

	protected $fillable = [
	   'title', 'description', 'unique_id', 'category_id', 'country_id', 'city', 'type','email','phone',
	   'website','user_id','slug'
	];

	//hasOne relation with User Model
	public function user(){
	    return $this->hasOne(User::class, 'id', 'user_id');
	}

	//hasOne relation with Category Model
	public function category(){
	    return $this->hasOne(Category::class, 'id', 'category_id');
	}

	//hasOne relation with Country Model
	public function country(){
	    return $this->hasOne(Country::class, 'id', 'country_id');
	}

	//hasOne relation with Package Model
	// public function package(){
	//     return $this->hasOne(Package::class, 'id', 'package_id');
	// }

	//hasMany relation with AdsImage Model
	public function images(){
	    return $this->hasMany(AdsImage::class,'ad_id','id');
	}

	//hasMany relation with AdPackages Model
	public function packages(){
	    return $this->hasMany(AdPackages::class,'ad_id','id');
	}

	//hasMany relation with Payment Model
	public function payment(){
	    return $this->hasMany(Payment::class,'ad_id','id');
	}

	//hasMany relation with AdPackages Model
	public function ad_details(){
	    return $this->hasMany(AdDetails::class,'ad_id','id');
	}

	//hasMany relation with AdMessages
	public function messages(){
		return $this->hasMany(AdMessages::class, 'ad_id', 'id');
	}

	protected static function boot(){
        parent::boot();

        static::created(function ($ad) {
            $ad->update(['slug' => $ad->title]);
        });
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        // get the slug of the latest created post
        $max = static::whereTitle($this->title)->latest('id')->skip(1)->value('slug');

        if (isset($max[-1]) && is_numeric($max[-1])) {
            return preg_replace_callback('/(\d+)$/', function ($mathces) {
                return $mathces[1] + 1;
            }, $max);
        }

        return "{$slug}-2";
    }
}
