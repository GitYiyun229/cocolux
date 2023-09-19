<?php

namespace App\Repositories\Eloquents;

use App\Models\ArticlesCategories;
use App\Repositories\Contracts\ArticleCategoryInterface;

class ArticleCategoryRepository extends BaseRepository implements ArticleCategoryInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\ArticlesCategories';
    }
}
