<?php

namespace Database\Seeders;

use App\Models\ModulesDesign;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ModulesDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulesDesign::insert([
                ['title' => 'user icon, white text, info button', 'icon' =>'fas fa-user', 'button_color' =>'bg-info', 'text_color' =>'text-white', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'users icon, white text, info button', 'icon' =>'fas fa-users', 'button_color' =>'bg-info', 'text_color' =>'text-white', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'folder icon, white text, info button', 'icon' =>'far fa-folder', 'button_color' =>'bg-info', 'text_color' =>'text-white', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'file icon, white text, info button', 'icon' =>'far fa-file', 'button_color' =>'bg-info', 'text_color' =>'text-white', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'bars icon, black text, nocolor button', 'icon' =>'fas fa-bars', 'button_color' =>'bg-info', 'text_color' =>'text-white', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'circle icon, black text, nocolor button', 'icon' =>'far fa-circle', 'button_color' =>'', 'text_color' =>'text-black', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'dot-circle, black text, nocolor button', 'icon' =>'far fa-dot-circle', 'button_color' =>'', 'text_color' =>'text-black', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
