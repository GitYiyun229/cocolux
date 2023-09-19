<?php

namespace App\Repositories\Eloquents;

use App\Models\MenuCategory;
use App\Repositories\Contracts\MenuCategoryInterface;

class MenuCategoryRepository extends BaseRepository implements MenuCategoryInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\MenuCategory';
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        if (\request()->hasFile('image')) {
            $data['image'] = $this->saveFileUpload($data['image'], 'images');
        }

        return $this->create([
            'name' =>  $data['name'],
            'slug' =>  $data['slug'],
            'parent_id' =>  $data['parent_id'] ?? 0,
            'image' =>  $data['image'] ?? null
        ]);
    }

}
