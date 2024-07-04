<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomFieldValue;

class CustomField extends Model
{
    protected $table = 'custom_fields';

	protected $fillable = [
	   'name', 'type', 'status'
	];

	/**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(CustomFieldValue::class, 'customfield_id');
    }
}
