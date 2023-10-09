<?php

namespace App\Repositories\Contracts;

interface RoleInterface extends BaseInterface
{
    /**
     * Update permission of role
     * @param int $id
     * @param array $permissions
     * @return mixed
     */
    public function updatePermission(int $id, array $permissions = []);
}
