<?php

namespace Database\Seeders;

use App\Models\Groups;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Groups::insert([
            ['title' => 'Администратори', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Полуадминистратори', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
