<?php

namespace App\Repositories\Eloquents;

use App\Models\ProductsCategories;
use App\Repositories\Contracts\ProductCategoryInterface;

class ProductCategoryRepository extends BaseRepository implements ProductCategoryInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\ProductsCategories';
    }
}
