<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TypiCMS\NestableTrait;

class Category extends Model
{
	use NestableTrait;
	
    protected $table = 'categories';

	protected $fillable = [
	   'name', 'slug', 'description', 'parent_id', 'status', 'image'
	];

	protected $casts = [
	   'parent_id' =>  'integer',
	   'status'  =>  'boolean'
	];

	public function setNameAttribute($value)
	{
	    $this->attributes['name'] = $value;
	    $this->attributes['slug'] = str_slug($value);
	}

	public function parent()
	{
	    return $this->belongsTo(Category::class, 'parent_id');
	}

	public function children()
	{
	    return $this->hasMany(Category::class, 'parent_id');
	}
}
