<?php

namespace Database\Seeders;

use App\Models\GroupsUsers;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedGroupsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        GroupsUsers::insert([
            ['id_group' => 1,'id_user' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_group' => 2,'id_user' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }

}
