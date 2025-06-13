<?php

namespace Modules\Users\Services;

use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;
use App\Services\ServicesAssignedModules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Modules\Users\Dto\UsersDto;
use Modules\Users\Emails\UsersRegistrationMail;
use Modules\Users\Repositories\UsersAdministrationRepositories;
use Modules\Users\Repositories\UsersRepositories;

class UsersServices
{
    protected ?string $classPath;
    public function __construct(public UsersRepositories $usersRepositories, public UsersAdministrationRepositories $usersAdministrationRepositories, public ServicesAssignedModules $servicesAssignedModules)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function index($lang,$params): array
    {
        $users = $this->usersRepositories->getAllUsers($params);
        $id_lang= $this->usersRepositories->getLanguagesByLang($lang)->id;
        $countries = $this->usersRepositories->getAllCountries();
        $expiration_time = $this->usersRepositories->getAllExpirationTime();
        $assignModules= $this->servicesAssignedModules->getUserModuleIds(Auth::id(),$id_lang);
//dd($assignModules);
        return ['data' => [
            'users' => $users,
            'countries' => $countries,
            'expiration_time' => $expiration_time,
            'assignModules' => $assignModules,
        ]];
    }

    public function create(): array
    {
        $countries = $this->usersRepositories->getAllCountries();
        $expiration_time = $this->usersRepositories->getAllExpirationTime();
        $assignCountries = array();
        return ['data' => [
            'countries' => $countries,
            'expiration_time' => $expiration_time,
            'assignCountries' => $assignCountries,
        ]];
    }

    public function store($countries,UsersDto $usersDto): ResponseError|ResponseSuccess
    {
        $path = 'users/';

        //CREATE PICTURE NAME
        $picture_name = '';
        if (!empty($usersDto->picture)) {
            $extension = strtolower($usersDto->picture->getClientOriginalExtension());
            $picture_name = date('Ymd_His') . '_'.Str::random(3) .'.'. $extension;
        }

        // STORE USER
        $user = $this->usersRepositories->storeUser($usersDto,$picture_name);
        if (!$user) {
            return new ResponseError('method: storeUser($data,$picture_name)',  $this->classPath,[]);
        }
        $countries = $this->usersRepositories->storeCountries($countries,$user->id);

        if (!$countries) {
            return new ResponseError('storeCountries($countries,$user->id)',  $this->classPath,[]);
        }


        // STORE PICTURE
        if ($user && !empty($usersDto->picture)) {
            Storage::disk('publish')->makeDirectory($path . $user->id, 0777, true);
            $image = ImageManager::imagick()->read($usersDto->picture);
            $image_tn = ImageManager::imagick()->read($usersDto->picture);
            $width = $image->width();
            if (($width > 1200)) {
                $image->scaleDown(width: 1200);
            }
            $image_tn = $image_tn->scaleDown(width: 300);
            $image_tn->save(Storage::disk('publish')->path($path . $user->id . '/tn_' . $picture_name));
            $image->save(Storage::disk('publish')->path($path . $user->id . '/' . $picture_name));
        }


        // CREATE AND SAVE HASH
        $uniqueHash = md5($usersDto->email . '-' . Carbon::now()->toDateTimeString());
        $hash = $this->usersRepositories->storeNewHash($uniqueHash, $user->id, 'registration', Carbon::now());
        if (!$hash) {
            return new ResponseError('method: storeNewHash()',  $this->classPath,[]);
        }

        // FUNCTIONALITY SEND EMAIL ///////////////////////////////////////////////
        if (config('users.users_send_registration_email') == 1) {
            //SEND EMAIL
            $subject = __('users.UsersController.email_subject');
            $url_mail = url("/registration?hash={$uniqueHash}");
            $sendEmail = Mail::to($usersDto->email )->send(new UsersRegistrationMail($subject, $url_mail, $user->username, $user->name, $user->surname, $user->email));
            if (!$sendEmail) {
                return new ResponseError('method: $sendEmail',  $this->classPath,[]);
            }
        }

        // FUNCTIONALITY ENABLE PASSWORD///////////////////////////////////////////////
        if (config('users.users_enable_pass_new') == 1) {
            //dd(config('users.users_enable_pass_new') );
            // SAVE PASS FOR NEW USER
            if ($usersDto->password !== null) {

                //SAVE PASSWORD IN PASSWORDS
                $password = Hash::make($usersDto->password);
                $storePasswordPasswords = $this->usersRepositories->storePasswordPasswords($user->id, $password);
                if (!$storePasswordPasswords) {
                    return new ResponseError('method: storePasswordPasswords($user->id, $password)',  $this->classPath,[]);
                }
                //SAVE PASSWORD IN USERS
                $storePasswordUsers = $this->usersRepositories->storePasswordUsers($user->id, $password);
                if (!$storePasswordUsers) {
                    return new ResponseError('method: storePasswordUsers($user->id, $password)',  $this->classPath,[]);
                }
            } else {
                $password = Hash::make(Str::random(8));
                $storePassword = $this->usersRepositories->storePasswordUsers($user->id, $password);
                if (!$storePassword) {
                    return new ResponseError('method: storePasswordUsers($user->id, $password)',  $this->classPath,[]);
                }
            }
        }

        // FUNCTIONALITY ENABLE PASSWORD///////////////////////////////////////////////
        if (config('users.users_enable_pass_new') == 0) {

            //SAVE PASSWORD IN USERS
            if ($usersDto->password !== null) {
                $password = Hash::make(Str::random(8));
                $storePassword = $this->usersRepositories->storePasswordUsers($user->id, $password);
                if (!$storePassword) {
                    return new ResponseError('method: storePasswordUsers($user->id, $password)',  $this->classPath,[]);
                }
            }

        }

        $storePrivileges = $this->usersRepositories->storePrivileges($user->id,$user->user_type);
        return new ResponseSuccess('','',['id'=>$user->id]);
    }

    public function edit(String $lang, int $id): array
    {
        $user = $this->usersRepositories->getUserById($id);
        $countries = $this->usersRepositories->getAllCountries();
        $expiration_time = $this->usersRepositories->getAllExpirationTime();
        $id_language = $this->usersRepositories->getLanguagesByLang($lang)->id;
        $assignCountries = $this->usersRepositories->getAssignCountries($id);

        //dd($assignCountries);
        //++++++++++++++++++++++++++++++++++++++++++++++++++
        //ДОДЕЛЕНИ МОДУЛИ
        $assignedModulesAll = $this->usersAdministrationRepositories->assignedModulesAll($id,$id_language);
        //ДОДЕЛЕНИ МОДУЛИ ПРЕКУ МОДУЛИ
        $assignedModulesModules = $this->usersAdministrationRepositories->assignedModulesModules($id,$id_language);
        //НЕДОДЕЛЕНИ МОДУЛИ ПРЕКУ МОДУЛИ
        $unassignedModulesModules = $this->usersAdministrationRepositories->unassignedModulesModules($id,$id_language);
        //СИТЕ МОДУЛИ
        $modules = $this->usersAdministrationRepositories->allModules($id_language);
        //СИТЕ ГРУПИ
        $groups = $this->usersAdministrationRepositories->allGroups($id_language);
        //ДОДЕЛЕНИ ГРУПИ
        $assignedGroups = $this->usersAdministrationRepositories->assignedGroups($id,$id_language);
        //НЕДОДЕЛЕНИ ГРУПИ
        $unassignedGroups = $this->usersAdministrationRepositories->unassignedGroups($id,$id_language);



        //return new SuccessResponse(__('global.update_success'), ['data' => ['user' => $user, 'countries' => $countries, 'expiration_time' => $expiration_time]], ['reason' => 'user_update_success']);
        return ['data' => [
            'user' => $user,
            'countries' => $countries,
            'assignCountries' => $assignCountries,
            'expiration_time' => $expiration_time,
            'assignedModulesAll' => $assignedModulesAll,
            'assignedModulesModules' => $assignedModulesModules,
            'unassignedModulesModules' => $unassignedModulesModules,
            'assignedGroups' => $assignedGroups,
            'unassignedGroups' => $unassignedGroups,
            'modules' => $modules,
            'groups' => $groups,
        ]];
    }

    public function update($countries, $file_name_hidden, UsersDto $usersDto): ResponseSuccess|ResponseError
    {
        $id = $usersDto->id;
        $picture_name = '';
        $path = 'users/';

        // CHECK IF USER EXIST ///////////////////////////////////////////////
        $isUser = $this->usersRepositories->getUserById($id);
        if (!$isUser) {
            return new ResponseError('method: getUserById($id)',  $this->classPath,[]);
        }

        // FUNCTIONALITY PASSWORD USED ///////////////////////////////////////////////
        if ($usersDto->password !== null) {
            if (config('users.users_password_used') == 1) {
                $previousPasswords = $this->usersRepositories->previousPasswords($id);
                foreach ($previousPasswords as $hashedPassword) {
                    if (Hash::check($usersDto->password, $hashedPassword)) {
                        return new ResponseError('method: previousPasswords($id);', $this->classPath,[]);
                    }
                }
            }
        }

        if (!empty($usersDto->picture) && !empty($file_name_hidden)) {

            /*get old picture name ------------------------------------------------------------------------------------------*/
            $user = $this->usersRepositories->getUserById($id);
            $picture_name_old = (!empty($usersDto->picture) ) ? $user->picture : '';
            /*end get old picture name ------------------------------------------------------------------------------------------*/
            /*create picture name ------------------------------------------------------------------------------------------*/
            $extension = strtolower($usersDto->picture->getClientOriginalExtension());
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
            $image = ImageManager::imagick()->read($usersDto->picture);
            $image_tn = ImageManager::imagick()->read($usersDto->picture);
            $width = $image->width();
            if (($width > 1200)) {
                $image->scaleDown(width: 1200);
            }
            $image_tn = $image_tn->scaleDown(width: 300);
            $image_tn->save(Storage::disk('publish')->path($path . $user->id . '/tn_' . $picture_name));
            $image->save(Storage::disk('publish')->path($path . $user->id . '/' . $picture_name));
        }

        if (empty($usersDto->picture) && empty($file_name_hidden)) {
            $picture_name = '';
            /*get old picture name ------------------------------------------------------------------------------------------*/
            $user = $this->usersRepositories->getUserById($id);
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

        if (empty($usersDto->picture) && !empty($file_name_hidden)) {
            $picture_name = $file_name_hidden;
        }

        // UPDATE USER
        $user = $this->usersRepositories->updateUser($id, $usersDto, $picture_name);
        if (!$user) {
            return new ResponseError('method: updateUser($id, $request->all(), $picture_name)',  $this->classPath,[]);
        }

        $countries = $this->usersRepositories->updateCountries($user->id,$countries);
        if (!$countries) {
            return new ResponseError('updateCountries($user->id,$countries)',  $this->classPath,[]);
        }


        //STORE PASS
        if ($usersDto->password !== null) {
            $password = Hash::make($usersDto->password);
            $storePasswordPasswords = $this->usersRepositories->storePasswordPasswords($user->id, $password);
            if (!$storePasswordPasswords) {
                return new ResponseError('method: storePasswordPasswords($user->id, $password)',  $this->classPath,[]);
            }
            $storePasswordUsers = $this->usersRepositories->storePasswordUsers($user->id, $password);
            if (!$storePasswordUsers) {
                return new ResponseError('method: storePasswordUsers($user->id, $password)',  $this->classPath,[]);
            }
        }

        $storePrivileges = $this->usersRepositories->storePrivileges($user->id,$user->user_type);
        return new ResponseSuccess('',$this->classPath,['message_success'=>__('users.UsersServices.success_with_warnings_update_countries')]);
    }

    public function show($id): array
    {
        $user = $this->usersRepositories->getUserById($id);
        $assignCountries = $this->usersRepositories->getAssignCountries($id);
        return ['data' => [
            'user' => $user,
            'assignCountries' => $assignCountries,
        ]];

    }
    public function deleteUser($id): ResponseSuccess|ResponseError
    {
        $return= $this->usersRepositories->deleteUser($id);
        if (!$return) {
            return new ResponseError('method: deleteUser($id)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',[]);
    }

    public function sendEmailReg($id): ResponseSuccess|ResponseError
    {
        // CHECK IF USER EXIST ///////////////////////////////////////////////
        $user = $this->usersRepositories->getUserById($id);
        if (!$user) {
            return new ResponseError('method: getUserById($id)',  $this->classPath,[]);
        }
//dd($user);
        // CREATE AND SAVE HASH
        $uniqueHash = md5($user->email . '-' . Carbon::now()->toDateTimeString());
        $hash = $this->usersRepositories->storeNewHash($uniqueHash, $user->id, 'registration', Carbon::now());
        if (!$hash) {
            return new ResponseError('method: getUserById($id)',  $this->classPath,[]);
        }

        $password = Hash::make(Str::random(8));
        $storePassword = $this->usersRepositories->storePasswordUsers($user->id, $password);
        if (!$storePassword) {
            return new ResponseError('method: storePasswordUsers($user->id, $password)',  $this->classPath,[]);
        }

        //SEND EMAIL
        $subject = __('users.UsersController.email_subject');
        $url_mail = url("/registration?hash={$uniqueHash}");
        $sendEmail = Mail::to($user->email)->send(new UsersRegistrationMail($subject, $url_mail, $user->username, $user->name, $user->surname, $user->email));
        if (!$sendEmail) {
            return new ResponseError('method: $sendEmail',  $this->classPath,[]);
        }

        return new ResponseSuccess('','',[]);
    }

//  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function indexRecords($id,$params): array
    {
        $user = $this->usersRepositories->getUserById($id);
        $records = $this->usersRepositories->getRecordsByIdUser($id,$params);
        $countries = $this->usersRepositories->getAllCountries();
        $assignCountries = $this->usersRepositories->getAssignCountries($id);
        $years = $this->usersRepositories->getYears();
        return ['data' => [
            'records' => $records,
            'countries' => $countries,
            'assignCountries' => $assignCountries,
            'years' => $years,
            'user' => $user,
        ]];

    }
    public function createRecord($year,$id_user): array
    {
        $assignCountries = $this->usersRepositories->getAssignCountries($id_user);
        $projects = $this->usersRepositories->getAllProjects();
        $activities = array();
        $assignments = array();
        return ['data' => [
            'assignCountries' => $assignCountries,
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
        ]];
    }
    public function storeRecord($data): ResponseSuccess|ResponseError
    {

        $lockApproveRecords = $this->usersRepositories->storeRecord($data);
        if (!$lockApproveRecords) {
            return new ResponseError('storeRecord($data)',  $this->classPath,[]);
        }
        return new ResponseSuccess('storeRecord($data)',$this->classPath,[]);
    }
    public function editRecord($year, $id_record, $id_user): array
    {

        $record = $this->usersRepositories->getRecordById($id_record);

        $assignCountries = $this->usersRepositories->getAssignCountries($id_user);
        $projects = $this->usersRepositories->getAllProjects();
        $activities = $this->usersRepositories->getActivities($record->project);
        $assignments = $this->usersRepositories->getAssignments($record->project);

        return ['data' => [
            'record' => $record,
            'assignCountries' => $assignCountries,
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,

        ]];
    }
    public function updateRecord($id_record,$data): ResponseSuccess|ResponseError
    {

        $lockApproveRecords = $this->usersRepositories->updateRecord($id_record,$data);
        if (!$lockApproveRecords) {
            return new ResponseError('updateRecord($data)',  $this->classPath,[]);
        }
        return new ResponseSuccess('updateRecord($data)',$this->classPath,[]);
    }
    public function deleteRecord($id): ResponseSuccess|ResponseError
    {
        $return= $this->usersRepositories->deleteRecord($id);
        if (!$return) {
            return new ResponseError('method: deleteRecord($id)',  $this->classPath,[]);
        }
        return new ResponseSuccess('method: deleteRecord($id)',$this->classPath,[]);
    }
    public function showRecord($id): array
    {
        $user = $this->usersRepositories->getUserById($id);
        $record = $this->usersRepositories->getRecordById($id);
        return ['data' => [
            'user' => $user,
            'record' => $record,
        ]];

    }

    //  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function getActivities($id_project): array
    {
        $activities = $this->usersRepositories->getActivities($id_project);
        return ['data' => [
            'activities' => $activities,
        ]];
    }
    public function getAssignments($id_project): array
    {
        $assignments = $this->usersRepositories->getAssignments($id_project);
        return ['data' => [
            'assignments' => $assignments,
        ]];
    }
    public function lockApproveRecords($data): ResponseSuccess|ResponseError
    {

        $lockApproveRecords = $this->usersRepositories->lockApproveRecords($data);
        if (!$lockApproveRecords) {
            return new ResponseError('lockApproveRecords($data)',  $this->classPath,[]);
        }
        return new ResponseSuccess('lockApproveRecords($data)',$this->classPath,[]);
    }


    public function addGroupToUser( $id_user, $id_group): ResponseSuccess|ResponseError
    {
        $addGroupToUser = $this->usersRepositories->addGroupToUser( $id_user, $id_group);
        if (!$addGroupToUser) {
            return new ResponseError('method: addGroupToUser( $id_user, $id_group)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',[]);
    }
    public function removeGroupToUser(int $id_user, int $id_group): ResponseSuccess|ResponseError
    {
        $addGroupToUser = $this->usersRepositories->removeGroupToUser( $id_user, $id_group);
        if (!$addGroupToUser) {
            return new ResponseError('method: removeGroupToUser( $id_user, $id_group)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',[]);
    }


}
