<?php

namespace Modules\Public\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Public\Http\Requests\PublicRegisterUserRequest;
use Modules\Public\Services\PublicServices;

class PublicController extends Controller
{

    public function index(Request $request,PublicServices $publicServices): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $params = $request->all();
        $lang=App::getLocale();
        $id_languages= $publicServices->getLanguagesByLang($lang);
        $languages= $publicServices->getAllLanguages();
//        $records = $publicServices->getAllRecordsMainPublic($params,$id_languages);
//        $records_cover = $publicServices->getAllRecordsCoverPublic($params,$id_languages);



        return view('public/index', compact('languages'));
    }
    public function register(PublicRegisterUserRequest $request,PublicServices $publicServices): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $data = $request->all();

        //dd($data);
        $user = $publicServices->storeUser($data);
        if (!$user) {
            return redirect(url("index"))->with('error', __('global.error', ['method' => 'storeUser', 'class' => class_basename(__CLASS__)]));
        }

        return redirect(url("index"))->with('success', __('public.index.success_registration', ['method' => 'storeUser', 'class' => class_basename(__CLASS__)]));
    }
    public function recordsPublic($lang, $id_menu, $slug_menu, PublicServices $recordServices, LanguagesServices $languagesServices,EducationServices $educationServices, MenuServices $menuServices)
    {
        if(!isset($lang) && empty($lang)) {
            $lang=App::getLocale();
        }
        $params = Input::all();
        $languages= $languagesServices->getAllLanguages();
        $id_languages= $languagesServices->getLanguagesByLang($lang)->id;

        $records = $recordServices->getRecordsByIdMenuPublic($params,$id_languages,$id_menu);
        $records_povolnosti = $recordServices->getRecordsPovolnosti($params,$id_languages,$id_menu);
        //dd($records);
        $menu_by_id =$menuServices->getMenuById($id_menu);

        $education = $educationServices->getAllEducation($params,$id_menu,$id_languages);

        /*=============================================================================================*/
        if($id_languages==1){$temp=40;}
        if($id_languages==2){$temp=40;}
        if($id_languages==3){$temp=78;}
        $records_category = $recordServices->getRecordsByIdCategoryPublic($temp, $id_languages);
        /*=============================================================================================*/
        //dd($records_category->menu_title);
        return view('public/records', compact('records','languages','records_category','education', 'menu_by_id','records_povolnosti'));
    }

    public function recordPublic($lang, $id_menu, $id,  $slug, PublicServices $publicServices, DocumentsServices $documentsServices, LanguagesServices $languagesServices, GalleriesServices $galleriesServices, PicturesServices $picturesServices)
    {
        $documents = $documentsServices->getDocumentsByIdRecordPublic($id);
        $languages= $languagesServices->getAllLanguages();
        $id_languages= $languagesServices->getLanguagesByLang($lang)->id;

        $records = $publicServices->getRecordsByIdPublic($id);
        //dd($records);
        /*=============================================================================================*/
        if($id_languages==1){$temp=40;}
        if($id_languages==2){$temp=40;}
        if($id_languages==3){$temp=40;}
        $records_category = $publicServices->getRecordsByIdCategoryPublic($temp, $id_languages);
        /*=============================================================================================*/
        $publicServices->updateRecordViewPublic($id);


        $galleries_title='';
        $pictures = array();

        $galleries_attached= $galleriesServices->getAttachGallery($id);

        if($galleries_attached){

            $galleries= $galleriesServices->getGalleriesById($galleries_attached->id_galleries);
            $galleries_title=$galleries->title;
            $pictures= $picturesServices->getPicturesByIdGallery($galleries_attached->id_galleries);


        };
        // dd($galleries_title);

        return view('public/record', compact('records', 'documents','languages','records_category','galleries_title','pictures'));
    }
    public function test(PublicServices $publicServices)
    {
        $publicServices->test();
    }
}
