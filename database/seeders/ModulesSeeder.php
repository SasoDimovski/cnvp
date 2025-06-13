<?php

namespace Database\Seeders;

use App\Models\Modules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modules::insert([
           /* 1*/
            [
                'id_parent'=> null,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Корисник',
                'slug'=> 'korisnik',
                'description'=> '',
                'link'=> '1/user/edit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            /* 2*/
            [
                'id_parent'=> null,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 2,
                'title'=> 'Корисници',
                'slug'=> 'korisnici',
                'description'=> '',
                'link'=> '2/users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            /* 3*/
            [
                'id_parent'=> null,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 1,
                'title'=> 'Модули',
                'slug'=> 'moduli',
                'description'=> '3/modules',
                'link'=> '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            /* 4*/
            [
            'id_parent'=> null,
            'id_language'=> 1,
            'id_modules_type'=> 1,
            'id_design_type'=> 1,
            'title'=> 'Групи',
            'slug'=> 'grupi',
            'description'=> '',
            'link'=> '4/groups',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ],
            /* 5*/
            [
            'id_parent'=> null,
            'id_language'=> 1,
            'id_modules_type'=> 1,
            'id_design_type'=> 1,
            'title'=> 'Јазици',
            'slug'=> 'jazici',
            'description'=> '',
            'link'=> '5/languages',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ],
            /* 6*/
            [
            'id_parent'=> null,
            'id_language'=> 1,
            'id_modules_type'=> 1,
            'id_design_type'=> 1,
            'title'=> 'Тест',
            'slug'=> 'test',
            'description'=> '',
            'link'=> '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
            /* 7*/
            [
                'id_parent'=> 6,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 7,
                'title'=> 'Тест 1',
                'slug'=> 'test1',
                'description'=> '',
                'link'=> '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
            ,
            /* 8*/
            [
                'id_parent'=> 6,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 3,
                'title'=> 'Тест 2',
                'slug'=> 'test2',
                'description'=> '',
                'link'=> '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
            ,
            /* 9*/
            [
                'id_parent'=> 8,
                'id_language'=> 1,
                'id_modules_type'=> 1,
                'id_design_type'=> 7,
                'title'=> 'Тест 3',
                'slug'=> 'test3',
                'description'=> '',
                'link'=> '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
            ,
            /* 9*/
            [
                'id_parent'=> null,
                'id_language'=> 1,
                'id_modules_type'=> 2,
                'id_design_type'=> 1,
                'title'=> 'Авторизација',
                'slug'=> 'avtorizacija',
                'description'=> '',
                'link'=> '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
