<?php

namespace Modules\Modules\Database\Seeders;

use Database\Seeders\SeedModulesDesignSeeder;
use Database\Seeders\SeedModulesSeeder;
use Database\Seeders\SeedModulesTypeSeeder;
use Database\Seeders\SeedModulesUsersSeeder;
use Illuminate\Database\Seeder;

class ModulesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SeedModulesSeeder::class,
            SeedModulesTypeSeeder::class,
            SeedModulesDesignSeeder::class,
            SeedModulesUsersSeeder::class,
        ]);
    }
}
