<?php
namespace Modules\Record\Services;


use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Modules\Record\Dto\RecordDto;
use Modules\Record\Repositories\RecordRepository;

readonly class RecordServices
{

    public function __construct(private RecordRepository $recordRepository)
    {
    }
    public function update(int $id, ?String $file_name_hidden, RecordDto $recordDto): ResponseError|ResponseSuccess
    {

        $picture_name = '';
        $path = 'records/';
        // CHECK IF RECORD EXIST ///////////////////////////////////////////////
        $isRecord = $this->recordRepository->getRecordById($id);
        if (!$isRecord) {
            return new ResponseError('method: getRecordById($id)',  __DIR__ . '/' . class_basename(__CLASS__) . '.php',[]);
        }

        // SAVE PICTURE ///////////////////////////////////////////////
        if (!empty($recordDto->picture) && !empty($file_name_hidden)) {
            /*get old picture name ------------------------------------------------------------------------------------------*/
            $record = $this->recordRepository->getRecordById($id);
            $picture_name_old = (!empty($recordDto->picture) ) ? $record->picture : '';
            /*end get old picture name ------------------------------------------------------------------------------------------*/
            /*create picture name ------------------------------------------------------------------------------------------*/
            $extension = strtolower($recordDto->picture->getClientOriginalExtension());
            $picture_name = date('Ymd_His') . '_' . Str::random(8) . '.' . $extension;
            /*end create picture name ------------------------------------------------------------------------------------------*/
            Storage::disk('publish')->makeDirectory($path.$record->id, 0777, true);
            $userDirectory = $path . $record->id;
            $filesToDelete = [$picture_name_old, 'tn_'.$picture_name_old,]; // Имена на фајловите за бришење
            foreach ($filesToDelete as $file) {
                if (Storage::disk('publish')->exists($userDirectory . '/' .$file )) {
                    Storage::disk('publish')->delete($userDirectory . '/' .$file );
                }
            }
            $image = ImageManager::imagick()->read($recordDto->picture);
            $image_tn = ImageManager::imagick()->read($recordDto->picture);
            $width = $image->width();
            if (($width > 1200)) {
                $image->scaleDown(width: 1200);
            }
            $image_tn = $image_tn->scaleDown(width: 300);
            $image_tn->save(Storage::disk('publish')->path($path . $record->id . '/tn_' . $picture_name));
            $image->save(Storage::disk('publish')->path($path . $record->id . '/' . $picture_name));
        }
        if (empty($recordDto->picture) && empty($file_name_hidden)) {
            $picture_name = '';
            /*get old picture name ------------------------------------------------------------------------------------------*/
            $record = $this->recordRepository->getRecordById($id);
            $picture_name_old = $record->picture;
            /*end get old picture name ------------------------------------------------------------------------------------------*/
            $userDirectory = $path . $record->id;
            $filesToDelete = [$picture_name_old, 'tn_'.$picture_name_old,]; // Имена на фајловите за бришење
            foreach ($filesToDelete as $file) {
                if (Storage::disk('publish')->exists($userDirectory . '/' .$file )) {
                    Storage::disk('publish')->delete($userDirectory . '/' .$file );
                }
            }
        }
        if (empty($recordDto->picture) && !empty($file_name_hidden)) {
            $picture_name = $file_name_hidden;
        }

        // UPDATE RECORD ///////////////////////////////////////////////
        $record = $this->recordRepository->updateRecord($id, $recordDto, $picture_name);
        if (!$record) {
            return new ResponseError('method: updateRecord($id, $recordDto, $picture_name)',  __DIR__ . '/' . class_basename(__CLASS__) . '.php',[]);
        }
       return new ResponseSuccess('','',[]);
    }
    public function getRecordById($id)
    {
        if($id) {
            return $this->recordRepository->getRecordById($id);
        }
        return null;
    }
    public function getRecordByIdUser($id_user)
    {
        if($id_user) {
            return $this->recordRepository->getRecordByIdUser($id_user);
        }
        return null;
    }
    public function getDocumentByIdRecordIdModule($id_record, $id_module)
    {
        if($id_record&&$id_module) {
            return $this->recordRepository->getDocumentByIdRecordIdModule($id_record, $id_module);
        }
        return null;
    }

    public function storeDoc($id_record, $data): ResponseError|ResponseSuccess
    {
        $file = '';
        $type = '';
        $path = '';
        $size = '';

        $path_global = 'records/';

        if (!empty($data['file_doc'])) {

            /*create file name ------------------------------------------------------------------------------------------*/
            $extension= strtolower($data['file_doc']->getClientOriginalExtension());
            $file = date('Ymd_His') . '_' . Str::random(3) . '.' . $extension;
            /*end create file name ------------------------------------------------------------------------------------------*/

            /*type of file ------------------------------------------------------------------------------------------*/
            $type =$extension;
            /*-----------------------------------------------------------------------------------------------------------*/

            /*size of file ------------------------------------------------------------------------------------------*/
            $fileSizeInBytes = $data['file_doc']->getSize(); // Во бајти
            $fileSizeInKB = $fileSizeInBytes / 1024; // Во килобајти
            $fileSizeInMB = $fileSizeInBytes / 1024 / 1024; // Во мегабајти
            $size = number_format($fileSizeInKB, 3).' KB';
            /*-----------------------------------------------------------------------------------------------------------*/

            /*path of file ------------------------------------------------------------------------------------------*/
            $path=$path_global . $id_record . '/';
            /*-----------------------------------------------------------------------------------------------------------*/

            /*save file ------------------------------------------------------------------------------------------*/
            Storage::disk('publish')->makeDirectory($path_global.$id_record, 0777, true);
            $data['file_doc']->move(Storage::disk('publish')->path($path_global . $id_record . '/'), $file);
        }

        // UPDATE DOCUMENT ///////////////////////////////////////////////
        $documents = $this->recordRepository->storeDocument($file, $type, $path, $size, $data);

        if (!$documents) {
            return new ResponseError('method: updateRecord($id, $recordDto, $picture_name)',  __DIR__ . '/' . class_basename(__CLASS__) . '.php',[]);
        }
        return new ResponseSuccess('','',[]);
    }



    public function updateDoc($id_record, $id_doc, $data): ResponseError|ResponseSuccess
    {
         //dd($data['comment_doc']);
        $document=$this->recordRepository->getDocumentById($id_doc);

        //old parameters
        $file = $document->file;
        $type = $document->type;
        $size= $document->size;
        $path = $document->path;

        $path_global = 'records/';

        if (!empty($data['file_doc'])) {

            /*delete old file  ------------------------------------------------------------------------------------------*/
            if (Storage::disk('publish')->exists($path_global .'/'.$id_record .'/' .$file )) {
                Storage::disk('publish')->delete($path_global .'/'. $id_record.'/' .$file );
            }
            /*-----------------------------------------------------------------------------------------------------------*/

            /*create file name ------------------------------------------------------------------------------------------*/
            $extension= strtolower($data['file_doc']->getClientOriginalExtension());
            $file = date('Ymd_His') . '_' . Str::random(3) . '.' . $extension;
            /*-----------------------------------------------------------------------------------------------------------*/

            /*type of file ------------------------------------------------------------------------------------------*/
            $type =$extension;
            /*-----------------------------------------------------------------------------------------------------------*/

            /*size of file ------------------------------------------------------------------------------------------*/
            $fileSizeInBytes = $data['file_doc']->getSize(); // Во бајти
            $fileSizeInKB = $fileSizeInBytes / 1024; // Во килобајти
            $fileSizeInMB = $fileSizeInBytes / 1024 / 1024; // Во мегабајти
            $size = number_format($fileSizeInKB, 3).' KB';
            /*-----------------------------------------------------------------------------------------------------------*/

            /*path of file ------------------------------------------------------------------------------------------*/
            $path=$path_global . $id_record . '/';
            /*-----------------------------------------------------------------------------------------------------------*/

            /*store file ------------------------------------------------------------------------------------------*/
            Storage::disk('publish')->makeDirectory($path_global.$id_record, 0777, true);
            $data['file_doc']->move(Storage::disk('publish')->path($path_global . $id_record . '/'), $file);
            /*-----------------------------------------------------------------------------------------------------------*/

        }

        // UPDATE DOCUMENT ///////////////////////////////////////////////
        $documents = $this->recordRepository->updateDocument($id_doc, $file, $type, $size, $path, $data);
        if (!$documents) {
            return new ResponseError('method: updateDocuments($id_doc, $file, $type, $size, $path, $data)',  __DIR__ . '/' . class_basename(__CLASS__) . '.php',[]);
        }
        return new ResponseSuccess('','',[]);
    }

    public function deleteDocument($id_record, $id_doc): ResponseError|ResponseSuccess
    {
        $path = 'records/';
        $file = $this->recordRepository->getDocumentById($id_doc)->file;
        if (Storage::disk('publish')->exists($path .'/'.$id_record .'/' .$file )) {
            Storage::disk('publish')->delete($path .'/'. $id_record.'/' .$file );
        }
        $document = $this->recordRepository->deleteDocument($id_doc);

        if (!$document) {
            return new ResponseError('method: recordRepository->deleteDocument($id_doc)',  __DIR__ . '/' . class_basename(__CLASS__) . '.php',[]);
        }
        return new ResponseSuccess('','',[]);
    }

    public function showDoc($id): array
    {
        $document= $this->recordRepository->getDocumentById($id);
        return ['data' => [
            'document' => $document,
        ]];

    }


}
