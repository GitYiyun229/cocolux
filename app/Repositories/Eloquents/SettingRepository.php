<?php

namespace App\Repositories\Eloquents;

use App\Models\Setting;
use App\Repositories\Contracts\SettingInterface;

class SettingRepository extends BaseRepository implements SettingInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Setting';
    }
}
