<?php

namespace Database\Seeders;

use App\Models\GroupsModules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedGroupsModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupsModules::insert([
            ['id_group' => 1,'id_module' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_group' => 1,'id_module' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_group' => 1,'id_module' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_group' => 1,'id_module' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_group' => 1,'id_module' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['id_group' => 2,'id_module' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
