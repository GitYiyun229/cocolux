<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'orders_items';

    public function productOption()
    {
        return $this->hasOne(ProductOptions::class, 'id', 'product_id');
    }

}
