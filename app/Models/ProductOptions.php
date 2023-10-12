<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
//    use HasFactory;

    protected $appends = [
        'is_home',
        'is_hot',
        'is_new',
        'brand',
        'image_first',
        'attribute_path'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'parent_id');
    }

    public function getIsHomeAttribute()
    {
        $product = $this->product;
        if ($product) {
            return $product->is_home;
        } else {
            return null;
        }
    }

    public function getIsHotAttribute()
    {
        $product = $this->product;
        if ($product) {
            return $product->is_hot;
        } else {
            return null;
        }
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

    public function getAttributePathAttribute()
    {
        $product = $this->product;
        if ($product) {
            return $product->attribute_path;
        } else {
            return null;
        }
    }

    public function getImageFirstAttribute()
    {
        $images = json_decode($this->attributes['images'], true);
        $image = isset($images[0]) ? $images[0] : null;
        return str_replace('https://cdn.cocolux.com','/images/cdn_images',$image);
    }
}
