<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\BaseInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

abstract class BaseRepository implements BaseInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return string
     */
    public abstract function getModelClass(): string;

    /**
     * @param int $id
     * @param array $relationships
     * @return mixed
     */
    public function getOneById(int $id, array $relationships = [])
    {
        return $this->model->with($relationships)->findOrFail($id);
    }

    /**
     * @param string $slug
     * @param array $relationships
     * @return mixed
     */
    public function getOneBySlug(string $slug, array $relationships = [])
    {
        return $this->model->with($relationships)->where(['slug' => $slug])->first();
    }

    /**
     * @param array $ids
     * @return \Illuminate\Support\Collection
     */
    public function getByIds(array $ids): Collection
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->get();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes)
    {
        return $this->model->whereId($id)->update($attributes);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param int $limit
     * @param array $columns
     * @param array $relationships
     * @return mixed
     */
    public function paginate(int $limit, array $columns = ['*'], array $where = [], array $relationships = [])
    {
        return $this->model->select($columns)->where($where)->latest()->with($relationships)->paginate($limit ?? config('data.limit', 20));
    }

    /**
     * @return Collection
     */
    public function getWithDepth() : Collection
    {
        return $this->model->withDepth()->defaultOrder()->get();
    }

    /**
     * @param array $where
     * @param array $columns
     * @param array $relationships
     * @param int $limit
     * @return mixed
     */
    public function getList(array $where = null, array $columns = ['*'], int $limit = null, array $relationships = [])
    {
        $query = $this->model->select($columns);

        if($where){
            foreach($where as $key => $value){
                if (gettype($value) === 'array'){
                    $query->where($key, $value[1], $value[0]);
                }else{
                    $query->where($key, $value);
                }

            }
        }
        if (!empty($limit)){
            $query->limit($limit);
        }

        if ($limit == 1){
            return $query->with($relationships)->first();
        }

        return $query->with($relationships)->get();
    }

    /**
     * @return mixed
     */
    public function resizeImage()
    {
        return $this->model->resizeImage;
    }

    /**
     * @param string $file
     * @param array $resizeImage
     * @param int $id
     * @param string $nameModule
     * @return string
     */
    public function removeImageResize(string $file,array $resizeImage = null,int $id = null, string $nameModule)
    {
        $img_path = pathinfo($file, PATHINFO_DIRNAME);
        if (!empty($resizeImage) && !empty($id)){
            foreach ($resizeImage as $item){
                $array_resize_ = str_replace($img_path.'/','/public/'.$nameModule.'/'.$item[0].'x'.$item[1].'/'.$id.'-',$file);
                $array_resize_ = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
                Storage::delete($array_resize_);
            }
        }
        return true;
    }

    /**
     * @param string $file
     * @param array $resizeImage
     * @param int $id
     * @param string $nameModule
     * @return string
     */
    public function saveFileUpload(string $file,array $resizeImage = null,int $id = null, string $nameModule)
    {
        $fileNameWithoutExtension = urldecode(pathinfo($file, PATHINFO_FILENAME));
        $fileName = $fileNameWithoutExtension. '.webp';

        if (!empty($resizeImage) && !empty($id)){
            foreach ($resizeImage as $item){
                $thumbnail = Image::make(asset($file))->fit($item[0], $item[1])->encode('webp', 75);
                $thumbnailPath = 'storage/'.$nameModule.'/'.$item[0].'x'.$item[1].'/' .$id.'-'. $fileName;
                Storage::makeDirectory('public/'.$nameModule.'/'.$item[0].'x'.$item[1].'/');
                $thumbnail->save($thumbnailPath);
            }
        }

        return urldecode($file);
    }
}
