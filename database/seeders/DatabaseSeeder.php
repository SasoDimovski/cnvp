<?php

namespace Database\Seeders;

use App\Models\Users;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountriesSeeder::class,
            DocumentsSeeder::class,
            EmailTypeSeeder::class,
            ExpirationTimeSeeder::class,
            GroupsModulesSeeder::class,
            GroupsSeeder::class,
            GroupsUsersSeeder::class,
            LanguagesSeeder::class,
            ModulesDesignSeeder::class,
            ModulesSeeder::class,
            ModulesTypeSeeder::class,
            ModulesUsersSeeder::class,
            PasswordsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
