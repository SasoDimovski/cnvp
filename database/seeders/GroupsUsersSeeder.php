<?php

namespace Database\Seeders;

use App\Models\GroupsUsers;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GroupsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        GroupsUsers::insert([
            ['group_id' => 1,'user_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['group_id' => 2,'user_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }

}
