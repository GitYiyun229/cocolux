<?php

namespace App\Models;


class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable = ['name', 'display_name', 'guard_name'];
}
