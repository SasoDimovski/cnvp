<?php

namespace Database\Seeders;

use App\Models\Modules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modules::insert([
           /* 1*/
            [
                'id_parent'=> 0,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Корисник',
                'slug'=> 'korisnik',
                'description'=> '',
                'link'=> 'user/1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            /* 2*/
            [
                'id_parent'=> 0,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Корисници',
                'slug'=> 'korisnici',
                'description'=> '',
                'link'=> 'users/2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            /* 3*/
            [
                'id_parent'=> 0,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Модули',
                'slug'=> 'moduli',
                'description'=> 'modules/3',
                'link'=> '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            /* 4*/
            [
            'id_parent'=> 0,
            'id_language'=> 1,
            'id_modules_type'=> 1,
            'id_design_type'=> 1,
            'title'=> 'Групи',
            'slug'=> 'grupi',
            'description'=> '',
            'link'=> 'groups/4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ],
            /* 5*/
            [
            'id_parent'=> 0,
            'id_language'=> 1,
            'id_modules_type'=> 1,
            'id_design_type'=> 1,
            'title'=> 'Јазици',
            'slug'=> 'jazici',
            'description'=> '',
            'link'=> 'languages/5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ],
            /* 6*/
            [
            'id_parent'=> 0,
            'id_language'=> 1,
            'id_modules_type'=> 1,
            'id_design_type'=> 1,
            'title'=> 'Документи',
            'slug'=> 'dokumenti',
            'description'=> '',
            'link'=> 'documents/6',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
            /* 7*/
            [
                'id_parent'=> 0,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Галерии',
                'slug'=> 'galerii',
                'description'=> '',
                'link'=> 'galleries/7',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
            ,
            /* 8*/
            [
                'id_parent'=> 7,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Слики',
                'slug'=> 'sliki',
                'description'=> '',
                'link'=> 'pictures/8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
