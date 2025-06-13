<?php
namespace Modules\Public\Repositories;

use App\Models\Languages;
use App\Models\Records;
use App\Models\Menu;
use App\Models\RecordsGalleries;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class PublicRepository

{
    public function getAllRecords($params,$id_menu,$id_languages)
    {
        //dd($params['all']);
        $records=Records::leftJoin('modules', 'modules.id', '=', 'records.id_module')
            ->leftJoin('_languages', '_languages.id', '=', 'modules.id_language')
            ->where('records.deleted', '=', 0)
            ->where('languages.id', '=', $id_languages)
            ->select(['records.id',
                'records.id_module',
                'records.title',
                'records.active',
                'records.created_at',
                'modules.id AS module_id',
                'modules.type AS type',
                'modules.title AS module_title',
                '_languages.lang AS language_lang'])
        ;

        if(isset($params['all']) && !empty($params['all'])) {
         $all=$params['all'];
            $records->where('records.id_module', '<>', 0);
            $records->where('type', '<>', 0);
        }
       else{
            $records->where('records.id_module', '=', $id_menu);
        }
        if(isset($params['search1']) && !empty($params['search1'])) {
            $records->where('records.id', '=', $params['search1']);
        }
        if(isset($params['search2']) && !empty($params['search2'])) {
            $records->where('records.title', 'like', '%'.$params['search2'].'%');
        }
        $pageList = config('constants.pagination');
        if (isset($params['pageList']) && !empty($params['pageList'])) {
            $pageList = $params['pageList'];
            if ($params['pageList'] == 'all') {
                $pageList  =   $records->count();
            }
        }
        if(!isset($params['sort']) && empty($params['sort'])&&!isset($params['order']) && empty($params['order'])) {
            $records->orderBy('records.id', 'DESC');
        }else{
            $records->orderBy($params['order'], $params['sort'], "UTF-8");
        }
        return $records->paginate($pageList);
    }

    public function getRecordsById($id)

    {
        if($id) {
            $records = Records::leftJoin('modules', 'modules.id', '=', 'records.id_module')
                ->where('records.id', '=', $id)
                ->select(['records.id',
                    'records.id_menu',
                    'records.title',
                    'records.slug',
                    'records.subtitle',
                    'records.intro',
                    'records.text',
                    'records.picture_file',
                    'records.active',
                    'records.deleted',
                    'records.created_at',
                    'records.updated_at',
                    'modules.slug AS module_slug',
                    'modules.title AS module_title'])
                ->first();

            return $records;
        }
        return null;
    }


    public function getRecordsGalleriesById($id)

    {
        if($id) {
            $records = RecordsGalleries::where('records_galleries.id', '=', $id)
                ->select(['records_galleries.id',
                    'records_galleries.id_records',
                    'records_galleries.id_galleries'])
                ->first();
            return $records;
        }
        return null;
    }
    public function storeRecords($data, $pictures_name)

    {

        date_default_timezone_set("Europe/Skopje");
        $date=date("Y-m-d H:i:s");
        $language=Languages::where('lang', '=', $data['lang'])->first();
        $id_language=$language->id;
        // dd($data['id_menu']);
        $slug= $this->slugConvertor($data['title']);
        //dd($slug);
        if (isset($data['publish'])) {
            $publish = 1;
        }else{ $publish = 0;}
        if (isset($data['main'])) {
            $main = 1;
        }else{ $main = 0;}
        if (isset($data['cover'])) {
            $cover = 1;
        }else{ $cover= 0;}
        if (isset($data['zeva'])) {
            $zeva = 1;
        }else{ $zeva= 0;}
        if (isset($data['cmpe'])) {
            $cmpe = 1;
        }else{ $cmpe= 0;}
        if (isset($data['stop_nasilstvo'])) {
            $stop_nasilstvo = 1;
        }else{ $stop_nasilstvo= 0;}

        $id = Records::insertGetId([
            'id_menu' => $data['id_menu'],
            'title' => $data['title'],
            'slug' => $slug,
            'subtitle' => $data['subtitle'],
            'intro' => $data['intro'],
            'text' => $data['text'],
            'publish' => $publish,
            'main' => $main,
            'cover' => $cover,
            'views' => 0,
            'zeva' => $zeva,
            'cmpe' => $cmpe,
            'stop_nasilstvo' => $stop_nasilstvo,
            'picture_file' => $pictures_name,
            'picture_description' => $data['picture_description'],
            'created_at' => $date,
            'updated_at' =>$date
        ]);
        $records = $this->getRecordsById($id);
        return $records;
    }

    public function updateRecords($id, $data, $pictures_name)

    {
        $records = $this->getRecordsById($id);

        if ($records) {
            date_default_timezone_set("Europe/Skopje");
            $slug= $this->slugConvertor($data['title']);
            $records->title = $data['title'];
            $records->slug = $slug;
            $records->subtitle = $data['subtitle'];
            $records->intro = $data['intro'];
            $records->text = $data['text'];
            $records->picture_file = $pictures_name;
            $records->picture_description = $data['picture_description'];
            if (isset($data['publish'])) {
                $publish = 1;
            }else{ $publish = 0;}
            if (isset($data['main'])) {
                $main = 1;
            }else{ $main = 0;}
            if (isset($data['cover'])) {
                $cover= 1;
            }else{ $cover = 0;}
            if (isset($data['zeva'])) {
                $zeva = 1;
            }else{ $zeva= 0;}
            if (isset($data['cmpe'])) {
                $cmpe = 1;
            }else{ $cmpe= 0;}
            if (isset($data['stop_nasilstvo'])) {
                $stop_nasilstvo = 1;
            }else{ $stop_nasilstvo= 0;}
            $records->publish = $publish;
            $records->main = $main;
            $records->cover = $cover;
            $records->zeva = $zeva;
            $records->cmpe = $cmpe;
            $records->stop_nasilstvo = $stop_nasilstvo;
            $records->updated_at = date("Y-m-d H:i:s");
            $records->created_at = $data['created_at'];
            return $records->save();
        }
        return null;
    }





    public function deleteRecords($id)
    {
        $records = $this->getRecordsById($id);
        if($records) {
           // $records =Records::where('id', '=', $id)->delete();
            $records->deleted = 1;
            //dd($records);
            return $records->save();
        }
        return null;
    }

    public function deleteRecordsGalleries($id)

    {
        $records = $this->getRecordsGalleriesById($id);
        if($records) {
            $records =RecordsGalleries::where('id', '=', $id)->delete();
            //$records->deleted = 1;
            //dd($records);
            return $records;
        }

        return null;



    }

    public function deletePicture($id)

    {

        $records = $this->getRecordsById($id);



        if($records) {

            // $records =Records::where('id', '=', $id)->delete();

            $records->picture_file = '';

            //dd($records);

            return $records->save();

        }

        return null;



    }





    public function getExportRecords($params,$id_menu,$id_languages)

    {

//dd($params);

        //dd($lang);

        $records=Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')

            ->leftJoin('languages', 'languages.id', '=', 'menu.id_language')

            ->where('records.deleted', '=', 0)

            ->where('languages.id', '=', $id_languages)

            ->select(['records.id',

                'menu.title AS menu_title',

                'records.title',

                'records.slug',

                'records.subtitle',

                'records.intro',

                'records.text',



                'records.publish',

                'records.main',

                'records.cover',

                'records.views',



                'records.created_at',

                'records.updated_at',



                'languages.lang AS language_lang'])

        ;

        // dd($params['pageList']);



        if(isset($params['search1']) && !empty($params['search1'])) {

            $records->where('records.id', '=', $params['search1']);

        }

        if(isset($params['search2']) && !empty($params['search2'])) {

            $records->where('records.title', 'like', '%'.$params['search2'].'%');

        }

        if(isset($params['search3']) && !empty($params['search3'])) {

            $records->where('records.id_language', '=', $params['search3']);

        }





        $pageList = config('constants.pagination');

        if (isset($params['pageList']) && !empty($params['pageList'])) {

            $pageList = $params['pageList'];

            if ($params['pageList'] == 'a') {

                $pageList  =   $records->count();

            }

        }

        if(!isset($params['sort']) && empty($params['sort'])&&!isset($params['order']) && empty($params['order'])) {

            $records->orderBy('records.id', 'DESC');

        }else{

            $records->orderBy($params['order'], $params['sort'], "UTF-8");

        }



        return $records->paginate($pageList);



    }

    public function slugConvertor($string)

    {

//dd($lang);



            $tr = array(

                "A" => "a", "B" => "b", "C" => "v", "D" => "d", "E" => "e", "F" => "f", "G" => "g", "H" => "h",

                "I" => "i", "J" => "j", "K" => "k", "L" => "l", "M" => "m", "N" => "n", "O" => "o", "P" => "p",

                "Q" => "q", "R" => "r", "S" => "s", "T" => "t", "U" => "u", "V" => "v", "W" => "w", "X" => "x",

                "Y" => "y", "Z" => "z", "&#39;" => "", "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d",

                "Е" => "e", "Ж" => "zh", "З" => "z", "И" => "i",

                "Й" => "j", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",

                "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",

                "У" => "u", "Ф" => "f", "Х" => "kh", "Ц" => "c", "Ч" => "ch",

                "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "y", "Ь" => "",

                "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",

                "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo",

                "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",

                "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p",

                "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f",

                "х" => "kh", "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "sch",

                "ъ" => "", "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu",

                "я" => "ya", " " => "-", "." => "", "," => "", "/" => "-",

                ":" => "", ";" => "", "—" => "", "–" => "-", "„" => "", "“" => "",

                "љ" => "lj", "њ" => "nj", "ѕ" => "dz", "ѓ" => "gj", "ќ" => "kj", "ј" => "j",

                "Љ" => "lj", "Њ" => "nj", "Ѕ" => "dz", "Ѓ" => "gj", "Ќ" => "kj", "Ј" => "j",

                "/" => "", "%" => "", "`" => "",

                "'" => "", "(" => "", ")" => "",

                "ѐ" => "e", "Ѐ" => "E", "!" => "", "ѝ" => "i", "Ѝ" => "i", '"' => "",

                'Џ' => "dzh", 'џ' => "dzh", '’' => "", "&" => "", '+' => "", "=" => "", "_" => "", "ë" => "e", "ç" => "c"

            );



            $string=strtr($string,$tr);


        return $string;

    }



    public function getAllRecordsMainPublic($params,$id_languages)
    {
        $records=Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')
            ->leftJoin('_languages', '_languages.id', '=', 'menu.id_language')
            ->where('records.deleted', '=', 0)
            ->where('records.active', '=', 1)
            ->where('_languages.id', '=', $id_languages)
            ->with('children')
            ->select(['records.id',
                'records.id_menu',
                'records.title',
                'records.subtitle',
                'records.slug',
                'records.picture_file',
                'records.active',
                'records.created_at',
                'records.updated_at',
                'records.views',
                'menu.id AS menu_id',
                'menu.slug AS menu_slug',
                'menu.title AS menu_title'])
        ;
        if(isset($params['search1']) && !empty($params['search1'])) {
            $records->where('records.title', 'like', '%'.$params['search1'].'%');
            $records->where('records.subtitle', 'like', '%'.$params['search1'].'%');
        }
        if(isset($params['zeva']) && !empty($params['zeva'])) {
            $records->where('records.zeva', '=',$params['zeva']);
        }
        if(isset($params['cmpe']) && !empty($params['cmpe'])) {
            $records->where('records.cmpe', '=',$params['cmpe']);
        }
        if(isset($params['stop_nasilstvo']) && !empty($params['stop_nasilstvo'])) {
            $records->where('records.stop_nasilstvo', '=',$params['stop_nasilstvo']);
        }
        $pageList = config('constants.pagination');
        if (isset($params['pageList']) && !empty($params['pageList'])) {
            $pageList = $params['pageList'];
            if ($params['pageList'] == 'all') {
                $pageList  =   $records->count();
            }
        }
        if(!isset($params['sort']) && empty($params['sort'])&&!isset($params['order']) && empty($params['order'])) {
            $records->orderBy('records.id', 'DESC');
        }else{
            $records->orderBy($params['order'], $params['sort'], "UTF-8");
        }
        return $records->paginate($pageList);
    }



    public function getAllRecordsCoverPublic($params,$id_languages)

    {
        //dd($id_languages);
        $records=Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')
            ->leftJoin('_languages', '_languages.id', '=', 'menu.id_language')
            ->where('records.deleted', '=', 0)
            ->where('records.active', '=', 1)
            ->where('_languages.id', '=', $id_languages)
            ->select(['records.id',
                'records.id_menu',
                'records.title',
                'records.slug',
                'records.picture_file',
                'records.active',
                'menu.id AS menu_id',
                'menu.slug AS menu_slug',
                'menu.title AS menu_title'])
        ;
        if(isset($params['search1']) && !empty($params['search1'])) {
            $records->where('records.title', 'like', '%'.$params['search1'].'%');
        }
        if(isset($params['zeva']) && !empty($params['zeva'])) {
            $records->where('records.zeva', '=',$params['zeva']);
        }
        if(isset($params['cmpe']) && !empty($params['cmpe'])) {
            $records->where('records.cmpe', '=',$params['cmpe']);
        }
        if(isset($params['stop_nasilstvo']) && !empty($params['stop_nasilstvo'])) {
            $records->where('records.stop_nasilstvo', '=',$params['stop_nasilstvo']);
        }
        $pageList = config('constants.pagination');
        if (isset($params['pageList']) && !empty($params['pageList'])) {
            $pageList = $params['pageList'];
            if ($params['pageList'] == 'all') {
                $pageList  =   $records->count();
            }
        }
        if(!isset($params['sort']) && empty($params['sort'])&&!isset($params['order']) && empty($params['order'])) {
            $records->orderBy('records.id', 'DESC');
        }else{
            $records->orderBy($params['order'], $params['sort'], "UTF-8");
        }
        return $records->paginate($pageList);
    }

    public function storeUser($data)
    {
        //dd($data);

        $user = Users::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'username' => $data['email'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'edb' => $data['edb'],
            'user_type' => 1,
            'active' => 0,
        ]);

        Records::create([
            'id_user' => $user->id,
            'id_module' => 11,
        ]);

        return $user;

    }

    public function getRecordsByIdPublic($id)

    {

        if($id) {

            $records = Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')

                ->where('records.id', '=', $id)

                ->where('records.deleted', '=', 0)

                ->where('records.publish', '=', 1)

                ->select(['records.id',

                    'records.id_menu',

                    'records.title',

                    'records.slug',

                    'records.subtitle',

                    'records.intro',

                    'records.text',

                    'records.picture_file',

                    'records.picture_description',

                    'records.main',

                    'records.cover',

                    'records.publish',

                    'records.deleted',

                    'records.views',

                    'records.created_at',

                    'records.updated_at',

                    'menu.id AS menu_id',

                    'menu.slug AS menu_slug',

                    'menu.type AS menu_type',

                    'menu.title AS menu_title'])



                ->first();



           // dd($records);

            return $records;

        }

        return null;

    }



    public function getRecordsByIdMenuPublic($params,$id_languages,$id_menu)

    {

        //dd($params);

        $records=Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')

            ->leftJoin('languages', 'languages.id', '=', 'menu.id_language')

            ->where('records.deleted', '=', 0)

            ->where('records.publish', '=', 1)

            ->where('languages.id', '=', $id_languages)

            ->with('children')

            ->select(['records.id',

                'records.id_menu',

                'records.title',

                'records.subtitle',

                'records.slug',

                'records.intro',

                'records.text',

                'records.picture_file',

                'records.picture_description',

                'records.main',

                'records.cover',

                'records.publish',

                'records.views',

                'records.zeva',

                'records.cmpe',

                'records.stop_nasilstvo',

                'records.created_at',

                'records.updated_at',

                'menu.id AS menu_id',

                'menu.type AS type',

                'menu.title AS menu_title',

                'menu.slug AS menu_slug',

                'languages.lang AS language_lang'])

        ;



        if(isset($params['all']) && !empty($params['all'])) {



            if(isset($params['search1']) && !empty($params['search1'])) {

                //dd($params['search1']);

                //$records->where('records.publish', '=', 1);

               // $records->where('records.id_menu', '<>', 0);

                $records->where('type', '<>', 0);

                $records->where('records.title', 'like', '%'.$params['search1'].'%');

                $records->orWhere('records.intro', 'like', '%'.$params['search1'].'%');

                $records->orWhere('records.text', 'like', '%'.$params['search1'].'%');

            }



            elseif(isset($params['zeva']) && !empty($params['zeva'])) {

                $records->where('records.zeva', '=',1);

            }

            elseif(isset($params['cmpe']) && !empty($params['cmpe'])) {



                $records->where('records.cmpe', '=',1);

            }

            elseif(isset($params['stop_nasilstvo']) && !empty($params['stop_nasilstvo'])) {

                $records->where('records.stop_nasilstvo', '=',1);

            }

            elseif(isset($params['site']) && !empty($params['site'])) {

                $records->where('records.id_menu', '>', 0);

                $records->where('records.id_menu', '<>', 40);

                $records->where('records.id_menu', '<>', 47);

                $records->where('records.id_menu', '<>', 48);

                $records->where('records.id_menu', '<>', 49);

                $records->where('records.id_menu', '<>', 50);

                $records->where('records.id_menu', '<>', 51);

                $records->where('records.id_menu', '<>', 52);

                $records->where('records.id_menu', '<>', 53);

                $records->where('records.id_menu', '<>', 54);

                $records->where('type', '<>', 0);

            }

/*            else

            {

                $records->where('records.id_menu', '<', 0);

            }*/

        }

        else{

            $records->where('records.id_menu', '=', $id_menu);

        }







        $pageList = config('constants.pagination');

        if (isset($params['pageList']) && !empty($params['pageList'])) {

            $pageList = $params['pageList'];

            if ($params['pageList'] == 'all') {

                $pageList  =  $records->count();

            }

        }



        $records->orderBy('records.created_at', 'DESC');

        $records->orderBy('records.id', 'DESC');



        //dd($records->toSql());

        //dd($records->paginate($pageList));

        return $records->paginate($pageList);



    }

    public function getRecordsPovolnosti($params,$id_languages,$id_menu)

    {

        //dd($params);

        $records=Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')

            ->leftJoin('languages', 'languages.id', '=', 'menu.id_language')

            ->where('records.deleted', '=', 0)

            ->where('records.publish', '=', 1)

            ->where('languages.id', '=', $id_languages)

            ->with('children')

            ->select(['records.id',

                'records.id_menu',

                'records.title',

                'records.intro',

                'records.slug',

                'records.subtitle',

                'records.picture_file',

                'records.picture_description',

                'records.main',

                'records.cover',

                'records.publish',

                'records.views',

                'records.created_at',

                'records.updated_at',

                'menu.id AS menu_id',

                'menu.title AS menu_title',

                'menu.slug AS menu_slug',

                'languages.lang AS language_lang'])

        ;



        if(isset($params['all']) && !empty($params['all'])) {

            if(isset($params['search1']) && !empty($params['search1'])) {

                //dd($params['search1']);

                $records->where('records.id_menu', '<>', 0);

                $records->where('records.title', 'like', '%'.$params['search1'].'%');

                $records->orWhere('records.intro', 'like', '%'.$params['search1'].'%');

            }

            else

            {

                $records->where('records.id_menu', '<', 0);

            }

        }

        else{

            $records->where('records.id_menu', '>', 46);

            $records->where('records.id_menu', '<', 54);

        }







        $pageList = config('constants.pagination');

        if (isset($params['pageList']) && !empty($params['pageList'])) {

            $pageList = $params['pageList'];

            if ($params['pageList'] == 'all') {

                $pageList  =  $records->count();

            }

        }



        $records->orderBy('records.created_at', 'DESC');

        $records->orderBy('records.id', 'DESC');



        //dd($records->toSql());

        //dd($records->paginate($pageList));

        return $records->paginate($pageList);



    }

    public function getRecordsByIdCategoryPublic($id_menu, $id_languages)

    {
//dd($id_menu);
        if($id_menu) {

            $records = Records::leftJoin('menu', 'menu.id', '=', 'records.id_menu')

                ->leftJoin('languages', 'languages.id', '=', 'menu.id_language')

                ->where('records.id_menu', '=', $id_menu)

                ->where('languages.id', '=', $id_languages)

                ->where('records.deleted', '=', 0)

                ->where('records.publish', '=', 1)

                ->with('children')

                ->orderBy('records.created_at', 'DESC')

                ->orderBy('records.id', 'DESC')

                ->select(['records.id',

                    'records.id_menu',

                    'records.title',

                    'records.slug',

                    'records.subtitle',

                    'records.intro',

                    'records.text',

                    'records.picture_file',

                    'records.picture_description',

                    'records.main',

                    'records.cover',

                    'records.publish',

                    'records.deleted',

                    'records.views',

                    'records.created_at',

                    'records.updated_at',

                    'menu.id AS menu_id',

                    'menu.slug AS menu_slug',

                    'menu.title AS menu_title'])

                ->first();



//dd($records);

            return $records;

        }

        return null;

    }



    public function updateRecordViewPublic($id)

    {

        $records = $this->getRecordsById($id);

         $views=$records->views+1;

        // dd($views);

        if($records) {

            // $records =Records::where('id', '=', $id)->delete();

            $records->views = $views;

            //dd($records);

            return $records->save();

        }

        return null;



    }



    public function updateSlugRecords()

    {



        for ($i = 0; $i <= 681; $i++) {

        $records = $this->getRecordsById($i);

        //dd($records);



        if ($records) {



            $slug= $this->slugConvertor(trim($records['title']));

            $records->slug = $slug;



            $records->save();

        }



        }

        return null;

    }

    public function getLanguagesByLang($lang)
    {
        $languages=Languages::where('lang', '=', $lang)->first();
        // dd($languages);
        return $languages;
    }
    public function getAllLanguages()
    {
        $languages=Languages::where('active', '=', '1')->get();
        return $languages;
    }

    public function test()
    {

//        ===============================================================================================
        // Прво ги бришеме вредностите во полето id_country во records
//        Records::where('id_country', '>', 0)->update(['id_country' => null]);
//
//        // Потоа ги ажурираме records со id_country од users
//        DB::table('records')
//            ->join('users_countries', 'records.insertedby', '=', 'users_countries.id_user')
//            ->whereNull('records.id_country')
//            ->update([
//                'records.id_country' => DB::raw('users_countries.id_country')
//            ]);
//
//        return "Records updated successfully!";

//        ===============================================================================================
//        $users = DB::table('users')->select('id', 'id_country')->get();
//
//        $data = [];
//
//        // Подготви податоци за внесување
//        foreach ($users as $user) {
//            if ($user->id_country) {
//                $data[] = [
//                    'id_user' => $user->id,
//                    'id_country' => $user->id_country,
//                    'created_at' => now(),
//                    'updated_at' => now()
//                ];
//            }
//        }
//
//        // Внеси ги податоците во табелата users_countries
//        DB::table('users_countries')->insert($data);
//
//        return "Inserted " . count($data) . " records into users_countries.";
//        ===============================================================================================
//        DB::table('records')
//            ->whereNull('updatedby')
//            ->update([
//                'updatedby' => DB::raw('insertedby'),
//                'dateupdated' => DB::raw('IF(dateupdated IS NULL, dateinserted, dateupdated)')
//            ]);
//
//        return "Updated records where updatedby or dateupdated was null.";
//        ===============================================================================================
        //Records::where('deleted', 1)->delete();
//        ===============================================================================================
   //     Records::query()->update(['lockrecord' => 1]);
//        ===============================================================================================
    //    Records::query()->update(['approvedby' => 90]);
//        ===============================================================================================
        Records::query()->update(['dateofapproval' => '2024-12-22 22:00:00']);

//        ===============================================================================================

    }
}

