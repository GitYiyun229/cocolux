<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const HOME_BANNER_0 = 0;
    const HOME_BANNER_1 = 1;
    const HOME_BANNER_2 = 2;
    const HOME_BANNER_3 = 3;
    const HOME_BANNER_4 = 4;
    const HOME_BANNER_MOBILE_1 = 5;
    const HOME_BANNER_MOBILE_2 = 6;
    const HOME_BANNER_MOBILE_3 = 7;
    const HOME_PRIMARY_1 = 8;
    const HOME_PRIMARY_2 = 9;
    const HOME_POPUP = 10;
    const HOME_SUB = 11;
    const HOT_DEAL_DETAIL = 12;

    const GROUP = [
        self::HOME_BANNER_0 => 'home_v1_category_home_banner_1',
        self::HOME_BANNER_1 => 'home_v1_category_home_banner_2',
        self::HOME_BANNER_2 => 'home_v1_category_home_banner_3',
        self::HOME_BANNER_3 => 'home_v1_category_home_banner_4',
        self::HOME_BANNER_4 => 'home_v1_category_home_banner_5',
        self::HOME_BANNER_MOBILE_1 => 'home_v1_category_mobile_banner_1',
        self::HOME_BANNER_MOBILE_2 => 'home_v1_category_mobile_banner_2',
        self::HOME_BANNER_MOBILE_3 => 'home_v1_category_mobile_banner_3',
        self::HOME_POPUP => 'home_v1_popup',
        self::HOME_PRIMARY_1 => 'home_v1_primary_banner_1',
        self::HOME_PRIMARY_2 => 'home_v1_primary_banner_2',
        self::HOME_SUB => 'home_v1_sub_banner',
        self::HOT_DEAL_DETAIL => 'hot_deal_detail_banner',
    ];
}
