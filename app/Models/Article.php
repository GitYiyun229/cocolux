<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const IS_HOME = 1;
    const IS_NOT_HOME = 0;

    public $resizeImage = ['lager' => [656,440],'resize'=>[368,245],'small'=>[248,165]];

    protected $appends = [
        'image_resize',
    ];

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(ArticlesCategories::class, 'category_id', 'id');
    }

    public function getImageResizeAttribute()
    {
        $img_path = pathinfo($this->image, PATHINFO_DIRNAME);
        $array_resize = array();
        $resizeImage = $this->resizeImage;
        foreach ($resizeImage as $k => $item){
            $array_resize_ = str_replace($img_path.'/','/storage/article/'.$item[0].'x'.$item[1].'/'.$this->id.'-',$this->image);
            $array_resize[$k] = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
        }
        return $array_resize;
    }
}
