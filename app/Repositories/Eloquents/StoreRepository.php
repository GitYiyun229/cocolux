<?php

namespace App\Repositories\Eloquents;

use App\Models\Store;
use App\Repositories\Contracts\StoreInterface;

class StoreRepository extends BaseRepository implements StoreInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Store';
    }
}
