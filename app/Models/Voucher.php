<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const VOUCHER_TYPE = 1;
    const VOUCHER_TYPE_P = 2;

    protected $appends = [
      'total_using_voucher',
        'time_end_voucher',
        'progressbar'
    ];

    public function items()
    {
        return $this->hasOne(VoucherItem::class,'voucher_id')->whereColumn('can_used_times','!=','used_times');
    }

    public function getTotalUsingVoucherAttribute()
    {
        $voucher_item = $this->items;
        if ($voucher_item) {
            return $voucher_item->can_used_times - $voucher_item->used_times;
        } else {
            return 0;
        }
    }

    public function getTimeEndVoucherAttribute()
    {
        $end_date = new \DateTime($this->end_date);
        $start_date = new \DateTime($this->start_date);

        $difference = $end_date->diff($start_date);

        return $difference->format('%a');
    }

    public function getProgressbarAttribute()
    {
        $voucher_item = $this->items;
        if ($voucher_item) {
            $progressbar = ($voucher_item->used_times/$voucher_item->can_used_times)*100;
            return $progressbar;
        } else {
            return 0;
        }

    }
}
