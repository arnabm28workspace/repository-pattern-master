<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageType extends Model
{
    protected $table = 'pagetypes';
    protected $fillable = [
       'name'
    ];
}
