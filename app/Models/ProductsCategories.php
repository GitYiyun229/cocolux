<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ProductsCategories extends Model
{

    use NodeTrait;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $guarded = ['id', '_lft', '_rgt'];
    public function products()
    {
        return $this->hasMany(Product::class,'category_path');
    }

//    public function children()
//    {
//        return $this->hasMany(ProductsCategories::class, 'parent_id');
//    }
//
//    public function parent()
//    {
//        return $this->belongsTo(ProductsCategories::class, 'parent_id');
//    }
}
