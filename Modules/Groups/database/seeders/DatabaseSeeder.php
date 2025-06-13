<?php

namespace Modules\Groups\Database\Seeders;

use Database\Seeders\SeedGroupsModulesSeeder;
use Database\Seeders\SeedGroupsUsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        dd('dasd');
        $this->call([
            SeedGroupsModulesSeeder::class,
            SeedGroupsUsersSeeder::class,
            SeedGroupsModulesSeeder::class,

        ]);
    }
}
