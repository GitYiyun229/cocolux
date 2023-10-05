<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
//    use HasFactory;

    protected $appends = [
        'is_new',
        'brand'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'parent_id');
    }

    public function getIsNewAttribute()
    {
        $product = $this->product;
        if ($product) {
            return $product->is_new;
        } else {
            return null;
        }
    }

    public function getBrandAttribute()
    {
        $product = $this->product;
        if ($product) {
            return $product->brand;
        } else {
            return null;
        }
    }
}
