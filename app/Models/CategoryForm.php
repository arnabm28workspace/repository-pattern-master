<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryForm extends Model
{
    protected $table = 'category_forms';
    protected $fillable = [
       'category_id', 'field_values'
    ];

    public function category()
    {
        return $this->hasOne('App\Models\Category','id','category_id');
    }
}
