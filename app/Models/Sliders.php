<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $resizeImage = ['lager' => [700,400], 'resize' => [412,236]];

    protected $appends = [
        'image_resize',
    ];

    protected $guarded = ['id'];

    public function getImageResizeAttribute()
    {
        $img_path = pathinfo($this->image, PATHINFO_DIRNAME);
        $array_resize_ = str_replace($img_path.'/','/storage/slider/larger/'.strtotime($this->updated_at).'-',$this->image);
        $array_resize = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
        if ($array_resize){
            return $array_resize;
        }else{
            return null;
        }
    }
}
