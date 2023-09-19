<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models as Database;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Database\User::create([
            'name' => 'Admin',
            'email' => 'manhlinh@finalstyle.com',
            'phone' => '0123456789',
            'password' => bcrypt(123456),
            'status' => Database\User::STATUS_ACTIVE,
            'type' => Database\User::ROLE_ADMIN,
            'birthday' => '2023-06-16',
            'gender' => 0,
            'address' => '33 lưu hữu phước',
        ]);
    }
}
