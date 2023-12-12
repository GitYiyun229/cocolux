<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'orders';

    const STATUS_WAITING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_CANCEL = 2;

    const STATUS = [
        self::STATUS_WAITING => 'Đợi xử lý',
        self::STATUS_SUCCESS => 'Hoàn thành',
        self::STATUS_CANCEL => 'Hủy'
    ];

    protected $appends = [
        'city_name',
        'district_name',
        'ward_name',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'city','code');
    }

    public function districts()
    {
        return $this->belongsTo(Districts::class, 'district','code');
    }

    public function wards()
    {
        return $this->belongsTo(Wards::class, 'ward','code');
    }

    public function getCityNameAttribute()
    {
        $city_name = $this->cities->name;
        return $city_name;
    }

    public function getDistrictNameAttribute()
    {
        $district_name = !empty($this->districts->name)?$this->districts->name:'';
        return $district_name;
    }

    public function getWardNameAttribute()
    {
        $ward_name = !empty($this->wards)?$this->wards->name:'';
        return $ward_name;
    }
}
