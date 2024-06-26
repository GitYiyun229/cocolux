<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const IS_HOME = 1;
    const IS_NOT_HOME = 0;

    const IS_HOT = 1;
    const IS_NOT_HOT = 0;

    const IS_NEW = 1;
    const IS_NOT_NEW = 0;

    public $resizeImage = ['lager' => [600,600],'resize'=>[300,300],'small'=>[100,100]];

    protected $appends = [
        'image_resize',
        'image_change_url',
        'brand_name'
    ];

    protected $casts = [
        'attributes' => 'object',
    ];

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsToMany(ProductsCategories::class, 'products','id', 'category_path');
    }

    public function productOption()
    {
        return $this->hasMany(ProductOptions::class, 'parent_id', 'id');
    }

    public function productComment()
    {
        return $this->belongsTo(ProductComments::class, 'id', 'product_id');
    }

    public function getImageResizeAttribute()
    {
        $img_path = pathinfo($this->image, PATHINFO_DIRNAME);
        $array_resize = array();
        $resizeImage = $this->resizeImage;
        foreach ($resizeImage as $k => $item){
            $array_resize_ = str_replace($img_path.'/','/storage/product/'.$item[0].'x'.$item[1].'/'.$this->id.'-',$this->image);
            $array_resize[$k] = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
        }
        return $array_resize;
    }

    public function getImageChangeUrlAttribute()
    {
        return str_replace('https://cdn.cocolux.com','/images/cdn_images',$this->image);
    }

    public function getBrandNameAttribute()
    {
        $product = $this->attribute_path;
        if ($product) {
            $pairs = explode(',', $this->attribute_path);

            $id_brand = null;
            foreach ($pairs as $pair) {
                list($key, $value) = explode(':', $pair);

                if ($key == '19') {
                    $id_brand = $value;
                    break;
                }
            }
            $brand = AttributeValues::where('id',$id_brand)->first();
            if ($brand){
                return $brand->name;
            }else{
                return null;
            }
        } else {
            return null;
        }
    }
}
