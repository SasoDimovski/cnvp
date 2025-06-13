<?php


namespace Modules\Public\Services;

use Modules\Public\Repositories\PublicRepository;

class PublicServices
{

    private PublicRepository $publicRepository;

    public function __construct(PublicRepository $publicRepository)
    {
        $this->publicRepository = $publicRepository;
    }

    public function getAllRecords($params,$id_menu,$id_languages)
    {
        $records = $this->publicRepository->getAllRecords($params,$id_menu,$id_languages);
        return $records;
    }
    public function getAllRecordsMainPublic($params,$id_languages)
    {
        $records = $this->publicRepository->getAllRecordsMainPublic($params,$id_languages);
        return $records;
    }
    public function getLanguagesByLang($lang)
    {
        if($lang) {
            return $this->publicRepository->getLanguagesByLang($lang);
        }
        return null;
    }


    public function getAllRecordsCoverPublic($params,$id_languages)
    {
        $records = $this->publicRepository->getAllRecordsCoverPublic($params,$id_languages);
        return $records;
    }
    public function storeUser($data)
    {
        return $this->publicRepository->storeUser($data);
    }

    public function getRecordsByIdMenuPublic($params,$id_languages,$id_menu)
    {
        $records = $this->publicRepository->getRecordsByIdMenuPublic($params,$id_languages,$id_menu);
        return $records;
    }
    public function getRecordsPovolnosti($params,$id_languages,$id_menu)
    {
        $records = $this->publicRepository->getRecordsPovolnosti($params,$id_languages,$id_menu);
        return $records;
    }
    public function getRecordsById($id)
    {
        if($id) {
            $records = $this->publicRepository->getRecordsById($id);
            return $records;
        }
        return null;
    }

    public function getRecordsByIdPublic($id)
    {
        if($id) {
            $records = $this->publicRepository->getRecordsByIdPublic($id);
            return $records;
        }
        return null;
    }

    public function getRecordsByIdCategoryPublic($id_menu, $id_languages)
    {
        if($id_menu) {
            $records = $this->publicRepository->getRecordsByIdCategoryPublic($id_menu, $id_languages);
            return $records;
        }
        return null;
    }

    public function storeRecords($data, $pictures_name)
    {
        if($data) {
            $records =  $this->publicRepository->storeRecords($data, $pictures_name);
            return $records;
        }
        return null;
    }

    public function updateRecords($id, $data, $pictures_name)
    {
        if($id && $data) {
            $records =  $this->publicRepository->updateRecords($id, $data, $pictures_name);
            return $records;
        }
        return null;
    }

    public function deleteRecords($id)
    {
        $records = $this->publicRepository->getRecordsById($id);

        if($records) {
            $records = $this->publicRepository->deleteRecords($id);
            return $records;
        }
        return null;
    }

    public function deleteRecordsGalleries($id)
    {
        $records = $this->publicRepository->getRecordsGalleriesById($id);

        if($records) {
            $records = $this->publicRepository->deleteRecordsGalleries($id);
            return $records;
        }
        return null;
    }
    public function deletePicture($id)
    {
        $records = $this->publicRepository->getRecordsById($id);

        if($records) {
            $records = $this->publicRepository->deletePicture($id);
            return $records;
        }
        return null;
    }


    public function getExportRecords($params,$id_menu,$lang)
    {
        if($params) {
            $records =  $this->publicRepository->getExportRecords($params,$id_menu,$lang);
            return $records;
        }
        return null;
    }
    public function getMenuById($id_menu)
    {
        $records = $this->publicRepository->getMenuById($id_menu);
        return $records;
    }
    public function getAllLanguages()
    {
        $records = $this->publicRepository->getAllLanguages();
        return $records;
    }

    public function updateRecordViewPublic($id)
    {
        $records = $this->publicRepository->updateRecordViewPublic($id);
        return $records;
    }

    public function updateSlugRecords()
    {
        $records = $this->publicRepository->updateSlugRecords();
        return $records;
    }
    public function test()
    {
        $records = $this->publicRepository->test();
        return $records;
    }

}
