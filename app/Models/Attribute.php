<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

	protected $fillable = [
	   'colname', 'label', 'field_type', 'popup_vals','is_filterable','is_required','status'
	];
}