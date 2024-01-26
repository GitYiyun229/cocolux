<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionItem extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];

    public function promotion()
    {
        return $this->hasOne(Promotions::class, 'id', 'promotion_id');
    }

    public function productOption()
    {
        return $this->hasOne(ProductOptions::class, 'sku', 'sku')->whereNotNull('slug')->whereNotNull('sku');
    }

    public function productOptionNotFlash()
    {
        $now = Carbon::now();
        $product_flash = PromotionItem::select('sku')->where('applied_start_time', '<=', $now)->where('applied_stop_time', '>', $now)
            ->where('type','flash_deal')->pluck('sku')->toArray();

        return $this->hasOne(ProductOptions::class, 'sku', 'sku')->whereNotNull('slug')->whereNotIn('sku',$product_flash);
    }
}
