<?php

namespace Database\Seeders;

use App\Models\ModulesDesign;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedModulesDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulesDesign::insert([
            ['title' => 'Дизајн 1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Дизајн 2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Дизајн 3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
