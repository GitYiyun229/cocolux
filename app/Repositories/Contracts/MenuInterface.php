<?php

namespace App\Repositories\Contracts;

interface MenuInterface extends BaseInterface
{
    public function updateTreeRebuild($root, $data);

    public function getMenusByCategoryId($categoryId);
}
