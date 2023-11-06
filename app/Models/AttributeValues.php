<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValues extends Model
{
    protected $table = 'attribute_values';
    protected $guarded = ['id'];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const IS_HOME = 1;
    const IS_NOT_HOME = 0;

    public function category()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
