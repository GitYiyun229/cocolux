<?php

namespace App\Services;

use App\Models\Promotions;
use Carbon\Carbon;

class DealService
{
    public function isFlashSaleAvailable($flash_id = null)
    {
        $now = Carbon::now();
        if ($flash_id) {
            $flash_sale = Promotions::where(['type' => 'flash_deal', 'id' => $flash_id])
                ->where('applied_start_time', '<=', $now)
                ->where('applied_stop_time', '>', $now)
                ->select('id', 'name', 'code', 'thumbnail_url', 'applied_start_time', 'applied_stop_time', 'sort_product')->first();
        } else {
            $flash_sale = Promotions::where(['type' => 'flash_deal'])
                ->where('applied_start_time', '<=', $now)
                ->where('applied_stop_time', '>', $now)
                ->select('id', 'name', 'code', 'thumbnail_url', 'applied_start_time', 'applied_stop_time', 'sort_product')->get();
        }

        return $flash_sale;
    }

    public function isHotDealAvailable($hot_id = null)
    {
        $now = Carbon::now();
        if ($hot_id) {
            $hot_deal = Promotions::where(['type' => 'hot_deal', 'id' => $hot_id])
                ->where('applied_start_time', '<=', $now)
                ->where('applied_stop_time', '>', $now)
                ->select('id', 'name', 'code', 'thumbnail_url', 'applied_start_time', 'applied_stop_time', 'link', 'sort_product')->orderBy('id', 'DESC')->first();
        } else {
            $hot_deal = Promotions::where(['type' => 'hot_deal'])
                ->where('applied_start_time', '<=', $now)
                ->where('applied_stop_time', '>', $now)
                ->select('id', 'name', 'code', 'thumbnail_url', 'applied_start_time', 'applied_stop_time', 'link', 'sort_product')->orderBy('id', 'DESC')->get();
        }

        return $hot_deal;
    }
}
