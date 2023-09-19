<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    const ROLE_ADMIN = 0;
    const ROLE_CONTENT = 1;

    const TYPE_ROLE = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_CONTENT => 'Content',
    ];

    protected $dates = ['birthday'];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
