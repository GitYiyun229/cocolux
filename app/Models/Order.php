<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'orders';

    protected $appends = [
        'city_name',
        'district_name',
    ];

    public function cities()
    {
        return $this->belongsTo(City::class, 'city','code');
    }

    public function districts()
    {
        return $this->belongsTo(Districts::class, 'district','code');
    }

    public function getCityNameAttribute()
    {
        $city_name = $this->cities->name;
        return $city_name;
    }

    public function getDistrictNameAttribute()
    {
        $district_name = $this->districts->name;
        return $district_name;
    }
}
