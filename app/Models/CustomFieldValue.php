<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomField;

class CustomFieldValue extends Model
{
    protected $table = 'custom_field_values';

	protected $fillable = [
	   'customfield_id', 'value'
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }
}
