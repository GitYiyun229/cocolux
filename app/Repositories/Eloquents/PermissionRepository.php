<?php

namespace App\Repositories\Eloquents;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionInterface;

class PermissionRepository extends BaseRepository implements PermissionInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Permission';
    }
}
