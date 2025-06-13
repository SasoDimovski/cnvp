<?php

namespace Database\Seeders;

use App\Models\ModulesType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ModulesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulesType::insert([
            ['title' => 'Модул', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Привилегија', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
