<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdFilter extends Model
{
    protected $table = 'ad_filters';

	protected $fillable = [
	   'ad_id', 'colname', 'val'
	];

}
