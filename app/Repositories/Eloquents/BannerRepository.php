<?php

namespace App\Repositories\Eloquents;

use App\Models\Banners;
use App\Repositories\Contracts\BannerInterface;

class BannerRepository extends BaseRepository implements BannerInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Banners';
    }

}
