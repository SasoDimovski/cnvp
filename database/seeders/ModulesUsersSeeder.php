<?php

namespace Database\Seeders;

use App\Models\ModulesUsers;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ModulesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulesUsers::insert([
            ['module_id' => 1,'user_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['module_id' => 2,'user_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['module_id' => 1,'user_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['module_id' => 3,'user_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['module_id' => 4,'user_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['module_id' => 5,'user_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
