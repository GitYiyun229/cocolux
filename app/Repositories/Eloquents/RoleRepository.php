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

    /**
     * Update permission of role
     * @param int $id
     * @param array $permissions
     * @return mixed
     */
    public function updatePermission(int $id, array $permissions = [])
    {
        $role = $this->model->findOrFail($id);
        return $role->syncPermissions($permissions);
    }
}
