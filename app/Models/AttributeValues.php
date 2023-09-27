<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValues extends Model
{
//    use HasFactory;
    protected $table = 'attribute_values';
    protected $guarded = ['id'];
    public function category()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
