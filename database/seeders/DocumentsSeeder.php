<?php

namespace Database\Seeders;

use App\Models\Documents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Documents::insert([
            [
                'id_user_logged'=> 2,
                'id_module'=> 1,
                'id_record'=> 1,
                'name'=> 'Test File',
                'file'=> '_atest.xlsx',
                'type'=> 'xlsx',
                'path'=> '\jenkins-deploy\jenkins-kubernetes-deployment',
                'size'=> 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user_logged'=> 2,
                'id_module'=> 1,
                'id_record'=> 1,
                'name'=> '1 Test File',
                'file'=> '1_atest.pdf',
                'type'=> 'pdf',
                'path'=> '\jenkins-deploy\jenkins-kubernetes-deployment',
                'size'=> 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],

        ]);
    }
}
