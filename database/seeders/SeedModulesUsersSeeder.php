<?php

namespace Database\Seeders;

use App\Models\ModulesUsers;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedModulesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulesUsers::insert([
            ['id_module' => 1,'id_user' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_module' => 2,'id_user' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_module' => 1,'id_user' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_module' => 3,'id_user' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_module' => 4,'id_user' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_module' => 5,'id_user' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
