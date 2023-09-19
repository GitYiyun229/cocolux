<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticlesCategories extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_PROMOTION = 1;
    const TYPE_ARTICLE = 0;

    protected $guarded = ['id'];

    public function articles()
    {
        return $this->belongsTo(Article::class, 'id', 'category_id');
    }
}
