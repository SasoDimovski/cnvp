<?php

namespace Database\Seeders;

use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Users::insert([
            [
                'name' => 'Сашо',
                'surname' => 'Димовски',
                'username' => 'password',
                'password' => Hash::make('password'),
                'email' => 'saso.dimovski@t.mk',
                'phone' => '911234567891',
                'user_type' => 1,
                'id_country' => 1,
                'id_expiration_time' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Перо',
                'surname' => 'Перовски',
                'username' => 'username',
                'password' => Hash::make('username'),
                'email' => 'saso.bass@gmail.mk',
                'phone' => '911234567891',
                'user_type' => 2,
                'id_country' => 45,
                'id_expiration_time' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
