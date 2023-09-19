<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models as Database;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Database\Setting::create([
            'key' => 'site_name',
            'name' => 'Site Name',
            'description' => 'Tên website',
            'value' => "Lẩu nấm Gia Khánh",
            'active' => Database\Setting::STATUS_ACTIVE,
            'type' => Database\Setting::SETTING_TYPE_TEXT,
        ]);
        Database\Setting::create([
            'key' => 'title',
            'name' => 'Title',
            'description' => 'Tiêu đề',
            'value' => "Lẩu nấm Gia Khánh",
            'active' => Database\Setting::STATUS_ACTIVE,
            'type' => Database\Setting::SETTING_TYPE_TEXT,
        ]);
        Database\Setting::create([
            'key' => 'logo',
            'name' => 'Logo',
            'description' => 'Logo website',
            'value' => "",
            'active' => Database\Setting::STATUS_ACTIVE,
            'type' => Database\Setting::SETTING_TYPE_IMAGE,
        ]);
        Database\Setting::create([
            'key' => 'info_contact',
            'name' => 'Thông tin liên hệ',
            'description' => 'Thông tin liên hệ',
            'value' => "",
            'active' => Database\Setting::STATUS_ACTIVE,
            'type' => Database\Setting::SETTING_TYPE_EDITOR,
        ]);
    }
}
