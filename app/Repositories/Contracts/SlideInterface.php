<?php

namespace App\Repositories\Contracts;

interface SlideInterface extends BaseInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
}
