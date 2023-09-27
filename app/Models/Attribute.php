<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
//    use HasFactory;
    protected $table = 'attribute';
    protected $guarded = ['id'];

    public function attributeValue()
    {
        return $this->hasMany(AttributeValues::class, 'attribute_id', 'id');
    }
}
