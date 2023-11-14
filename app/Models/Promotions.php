<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
//    use HasFactory;
protected $guarded = ['id'];
    const HOT_DEAL = 0;
    const FLASH_DEAL = 1;

    const TYPE = [
        self::HOT_DEAL => 'hot_deal',
        self::FLASH_DEAL => 'flash_deal',
    ];
}
