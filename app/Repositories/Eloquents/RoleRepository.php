<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
use App\Repositories\Contracts\RoleInterface;

class RoleRepository extends BaseRepository implements RoleInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Role';
    }
}
