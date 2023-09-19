<?php

namespace App\Repositories\Eloquents;

use App\Models\Page;
use App\Repositories\Contracts\PageInterface;

class PageRepository extends BaseRepository implements PageInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Page';
    }
}
