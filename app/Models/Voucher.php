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
}
