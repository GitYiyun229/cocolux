<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const METHOD_PAY_0 = 0;
    const METHOD_PAY_1 = 1;
    const METHOD_PAY_2 = 2;

    const IS_HOME = 1;
    const IS_NOT_HOME = 0;

    const HAS_TOC = 1;
    const NOT_HAS_TOC = 0;

    public $resizeImage = ['lager' => [600,600],'resize'=>[400,400],'small'=>[100,100]];

    protected $appends = [
        'image_resize',
        'format_date_created',
        'image_change_url'
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

    public function getImageChangeUrlAttribute()
    {
        return str_replace('https://cdn.cocolux.com','/images/cdn_images',$this->image);
    }

    public function getFormatDateCreatedAttribute(){
        $carbonDate = Carbon::parse($this->created_at);
        return $carbonDate->format('d/m/Y H:i:s');
    }
}
