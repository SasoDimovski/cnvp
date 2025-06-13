<?php

namespace Database\Seeders;

use App\Models\Passwords;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Passwords::insert([
        [
            'id_user' => 1,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'id_user' => 2,
            'username' => Hash::make('username'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],

        ]);
    }
}
