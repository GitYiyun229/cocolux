<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public $table = "setting";
    protected $guarded = ['id'];
    const SETTING_TYPE_TEXT = 0;
    const SETTING_TYPE_TEXTAREA = 1;
    const SETTING_TYPE_IMAGE = 2;
    const SETTING_TYPE_EDITOR = 3;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const SETTING_TYPE = [
        self::SETTING_TYPE_TEXT => 'Text',
        self::SETTING_TYPE_TEXTAREA => 'TextArea',
        self::SETTING_TYPE_IMAGE => 'Image',
        self::SETTING_TYPE_EDITOR => 'Editor',
    ];
}
