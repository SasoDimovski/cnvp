<?php

namespace Database\Seeders;

use App\Models\ExpirationTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpirationTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpirationTime::insert([
            [
                'value' => 3,
                'name' => '3 months',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 6,
                'name' => '6 months',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 9,
                'name' => '9 months',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 12,
                'name' => '12 months',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 999,
                'name' => 'Never',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
