<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
//    use HasFactory;

    public function product()
    {
        return $this->hasOne(Product::class, 'parent_id', 'id');
    }
}
