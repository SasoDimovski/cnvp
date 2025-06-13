<?php

namespace Database\Seeders;

use App\Models\GroupsModules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GroupsModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupsModules::insert([
            ['group_id' => 1,'module_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 1,'module_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['group_id' => 2,'module_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
