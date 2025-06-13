<?php

namespace Database\Seeders;

use App\Models\EmailType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       EmailType::insert([
           ['name' => 'REQUEST FOR FORGOTTEN PASSWORD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ['name' => 'REQUEST FOR FIRS LOGIN PASSWORD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ['name' => 'SUCCESS RESET FORGOTTEN PASSWORD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ['name' => 'SUCCESS RESET EXPIRED PASSWORD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ['name' => 'SUCCESS FIRS LOGIN PASSWORD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

       ]);
    }
}
