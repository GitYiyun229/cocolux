<?php

namespace App\Repositories\Contracts;

interface ProductCategoryInterface extends BaseInterface
{

    public function updateTreeRebuild($root, $data);

}
