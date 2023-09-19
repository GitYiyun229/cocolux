<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface BaseInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string;

    /**
     * @param int $id
     * @param array $relationships
     * @return mixed
     */
    public function getOneById(int $id, array $relationships = []);

    /**
     * @param string $slug
     * @param array $relationships
     * @return mixed
     */
    public function getOneBySlug(string $slug, array $relationships = []);

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @param int $limit
     * @param array $column
     * @param array $where
     * @param array $relationships
     * @return mixed
     */
    public function paginate(int $limit, array $column = ['*'], array $where = [], array $relationships = []);

    /**
     * @return Collection
     */
    public function getWithDepth(): Collection;

    /**
     * @param array $where
     * @param array $column
     * @param array $relationships
     * @param int $limit
     * @return mixed
     */
    public function getList(array $where, array $column = ['*'], int $limit, array $relationships = []);

    /**
     * @return Collection
     */
    public function resizeImage();

    /**
     * @param string $file
     * @param array $resizeImage
     * @param int $id
     * @param string $nameModule
     * @return mixed
     */
    public function removeImageResize(string $file, array $resizeImage, int $id, string $nameModule);

    /**
     * @param string $file
     * @param array $resizeImage
     * @param int $id
     * @param string $nameModule
     * @return mixed
     */
    public function saveFileUpload(string $file, array $resizeImage , int $id, string $nameModule);
}
