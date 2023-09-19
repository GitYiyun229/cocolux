<?php

namespace App\Repositories\Eloquents;

use App\Models\Menu;
use App\Repositories\Contracts\MenuInterface;

class MenuRepository extends BaseRepository implements MenuInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Menu';
    }

    /**
     * @param $file
     * @param $type
     * @return string
     */
    public function updateTreeRebuild($root = null, $data)
    {
        return $this->model->rebuildSubtree(null, $data);
    }

    public function getMenusByCategoryId($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->withDepth()->defaultOrder()->get();
    }
}
