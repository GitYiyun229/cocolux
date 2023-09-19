<?php

namespace App\Repositories\Contracts;

interface ProductInterface extends BaseInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
}
