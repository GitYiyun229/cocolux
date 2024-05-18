<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    //    use HasFactory;
    public function Store()
    {
        return $this->hasMany(Store::class, 'district', 'code');
    }
}
