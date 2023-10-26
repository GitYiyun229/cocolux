<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageCategories extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function pages()
    {
        return $this->hasMany(Page::class, 'page_cat_id', 'id');
    }
}
