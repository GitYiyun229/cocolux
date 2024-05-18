<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
//    use HasFactory;
    protected $table = 'cities';
    protected $guarded = ['id'];

    public function Store()
    {
        return $this->hasMany(Store::class, 'province', 'code');
    }
}

