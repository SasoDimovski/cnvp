<?php

namespace Modules\User\Services;

use App\Services\Responses\ErrorResponse;
use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;
use App\Services\Responses\SuccessResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Modules\User\Dto\UserDto;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Repositories\UserRepositories;

class UserServices
{
    protected ?string $classPath;
    public function __construct(public UserRepositories $userRepositories)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function edit(String $lang, int $id_module, int $id_user): array
    {
        $user = $this->userRepositories->getUserById($id_user);
        $countries = $this->userRepositories->getAllCountries();
        $expiration_time = $this->userRepositories->getAllExpirationTime();
        $assignCountries = $this->userRepositories->getAssignCountries($id_user);

        return ['data' => [
            'assignCountries' => $assignCountries,
            'user' => $user,
            'countries' => $countries,
            'expiration_time' => $expiration_time,
            ]];
    }
    public function update($countries, int $id, ?String $file_name_hidden, UserDto $userDto): ResponseError|ResponseSuccess
    {
        $picture_name = '';
        $path = 'users/';

        // CHECK IF USER EXIST ///////////////////////////////////////////////
        $isUser = $this->userRepositories->getUserById($id);
        if (!$isUser) {
            return new ResponseError('method: getUserById($id)',  $this->classPath,[]);
        }
        // FUNCTIONALITY PASSWORD USED ///////////////////////////////////////////////
        if ($userDto->password !== null) {
            if (config('config.users_password_used') == 1) {
                $previousPasswords = $this->userRepositories->previousPasswords($id);
                foreach ($previousPasswords as $hashedPassword) {
                    if (Hash::check($userDto->password, $hashedPassword)) {
                        return new ResponseError('method: previousPasswords($id);',  $this->classPath,[]);
                    }
                }
            }
        }
        // SAVE PICTURE ///////////////////////////////////////////////
        if (!empty($userDto->picture) && !empty($file_name_hidden)) {
            /*get old picture name ------------------------------------------------------------------------------------------*/
            $user = $this->userRepositories->getUserById($id);
            $picture_name_old = (!empty($userDto->picture) ) ? $user->picture : '';
            /*end get old picture name ------------------------------------------------------------------------------------------*/
            /*create picture name ------------------------------------------------------------------------------------------*/
            $extension = strtolower($userDto->picture->getClientOriginalExtension());
            $picture_name = date('Ymd_His') . '_' . Str::random(8) . '.' . $extension;
            /*end create picture name ------------------------------------------------------------------------------------------*/
            Storage::disk('publish')->makeDirectory($path.$user->id, 0777, true);
            $userDirectory = $path . $user->id;
            $filesToDelete = [$picture_name_old, 'tn_'.$picture_name_old,]; // Имена на фајловите за бришење
            foreach ($filesToDelete as $file) {
                if (Storage::disk('publish')->exists($userDirectory . '/' .$file )) {
                    Storage::disk('publish')->delete($userDirectory . '/' .$file );
                }
            }
            $image = ImageManager::imagick()->read($userDto->picture);
            $image_tn = ImageManager::imagick()->read($userDto->picture);
            $width = $image->width();
            if (($width > 1200)) {
                $image->scaleDown(width: 1200);
            }
            $image_tn = $image_tn->scaleDown(width: 300);
            $image_tn->save(Storage::disk('publish')->path($path . $user->id . '/tn_' . $picture_name));
            $image->save(Storage::disk('publish')->path($path . $user->id . '/' . $picture_name));
        }
        if (empty($userDto->picture) && empty($file_name_hidden)) {
            $picture_name = '';
            /*get old picture name ------------------------------------------------------------------------------------------*/
            $user = $this->userRepositories->getUserById($id);
            $picture_name_old = $user->picture;
            /*end get old picture name ------------------------------------------------------------------------------------------*/
            $userDirectory = $path . $user->id;
            $filesToDelete = [$picture_name_old, 'tn_'.$picture_name_old,]; // Имена на фајловите за бришење
            foreach ($filesToDelete as $file) {
                if (Storage::disk('publish')->exists($userDirectory . '/' .$file )) {
                    Storage::disk('publish')->delete($userDirectory . '/' .$file );
                }
            }
        }
        if (empty($userDto->picture) && !empty($file_name_hidden)) {
            $picture_name = $file_name_hidden;
        }
        // SAVE USER ///////////////////////////////////////////////
        $user = $this->userRepositories->updateUser($id, $userDto, $picture_name);
        if (!$user) {
            return new ResponseError('method: updateUser($id, $userDto, $picture_name)',  $this->classPath,[]);
        }

//        $countries = $this->userRepositories->updateCountries($user->id,$countries);
//        if (!$countries) {
//            return new ResponseError('updateCountries($user->id,$countries)',  $this->classPath,[]);
//        }
        //STORE PASSWORD ///////////////////////////////////////////////
        if ($userDto->password !== null) {
            $password = Hash::make($userDto->password);
            $storePasswordPasswords = $this->userRepositories->storePasswordPasswords($user->id, $password);
            if (!$storePasswordPasswords) {
                return new ResponseError('method: storePasswordPasswords($user->id, $password)',  $this->classPath,[]);
            }
            $storePasswordUsers = $this->userRepositories->storePasswordUsers($user->id, $password);
            if (!$storePasswordUsers) {
                return new ResponseError('method: storePasswordUsers($user->id, $password)',  $this->classPath,[]);
            }
        }
        return new ResponseSuccess('','',[]);
    }
}
