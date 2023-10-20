<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $table = 'attribute';
    protected $guarded = ['id'];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_TEXT = 0;
    const TYPE_SELECT = 1;
    const TYPE_EDITOR = 2;

    const TYPE = [
        self::TYPE_TEXT => 'text',
        self::TYPE_SELECT => 'select',
        self::TYPE_EDITOR => 'ckeditor',
    ];

    public function attributeValue()
    {
        return $this->hasMany(AttributeValues::class, 'attribute_id', 'id');
    }
}
