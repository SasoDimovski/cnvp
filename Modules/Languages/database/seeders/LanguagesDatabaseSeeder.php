<?php

namespace Modules\Languages\Database\Seeders;

use Database\Seeders\LanguagesSeeder;
use Illuminate\Database\Seeder;

class LanguagesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([

            LanguagesSeeder::class,

        ]);
    }
}
