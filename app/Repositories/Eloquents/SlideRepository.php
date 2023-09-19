<?php

namespace App\Repositories\Eloquents;

use App\Models\Sliders;
use App\Repositories\Contracts\SlideInterface;

class SlideRepository extends BaseRepository implements SlideInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return 'App\Models\Sliders';
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        if (\request()->hasFile('image')) {
            $data['image'] = $this->saveFileUpload($data['image'], 'images');
        }

        return $this->create($data);
    }
}
