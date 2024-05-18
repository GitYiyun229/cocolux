<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
//    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'stores';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function cities()
    {
        return $this->belongsTo(City::class, 'province','code');
    }
    // public function cities()
    // {
    //     return $this->belongsTo(City::class, 'province','code');
    // }

    public function districts()
    {
        return $this->belongsTo(Districts::class, 'district','code');
    }

    public function wards()
    {
        return $this->belongsTo(Wards::class, 'ward','code');
    }
}
