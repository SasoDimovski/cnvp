<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::table('_languages')->insert([
            ['lang' => 'mk', 'language' => 'македонски', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['lang' => 'en', 'language' => 'еnglish', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['lang' => 'sq', 'language' => 'shqip', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]]

        );
    }
}
