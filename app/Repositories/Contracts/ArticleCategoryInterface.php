<?php

namespace App\Repositories\Contracts;

interface ArticleCategoryInterface extends BaseInterface
{
    public function updateTreeRebuild($root, $data);
}
