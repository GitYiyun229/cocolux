<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComments extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
