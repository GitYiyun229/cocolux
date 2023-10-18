<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ArticlesCategories extends Model
{
    use NodeTrait;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $guarded = ['id', '_lft', '_rgt'];

    public function articles()
    {
        return $this->belongsTo(Article::class, 'id', 'category_id');
    }
}
