<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class AdsImage extends Model
{
    protected $table = 'ads_images';

	protected $fillable = [
	   'ad_id', 'image'
	];

	public function ad()
    {
        return $this->belongsTo('App\Models\Ads','id','ad_id');
    }

    public function getResizeImage($size)
    {
    	$actual_image_path = $this->image;
    	$slash_position = strpos($actual_image_path,'/');
    	$start_path = substr($actual_image_path,0,$slash_position);
    	$end_path = substr($actual_image_path,$slash_position);
    	return $start_path.'/'.$size.$end_path;
    }

    public function getImageName(){
        $actual_image_path = $this->image;
        $slash_position = strpos($actual_image_path,'/');
        $end_path = substr($actual_image_path,$slash_position+1);
        return $end_path;
    }
}
