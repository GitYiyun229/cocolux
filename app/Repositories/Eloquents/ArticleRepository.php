<?php

namespace App\Repositories\Eloquents;

use App\Models\Article;
use App\Repositories\Contracts\ArticleInterface;

class ArticleRepository extends BaseRepository implements ArticleInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Article';
    }

    /**
     * @param array $data
     * @return mixed
     */
//    public function store(array $data)
//    {
//        if (\request()->hasFile('image')) {
//            $data['image'] = $this->saveFileUpload($data['image'], 'images');
//        }
//
//        return $this->create($data);
//    }
}
