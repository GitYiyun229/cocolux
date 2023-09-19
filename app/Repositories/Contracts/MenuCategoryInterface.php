<?php

namespace App\Repositories\Contracts;

interface MenuCategoryInterface extends BaseInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

}
