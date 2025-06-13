<?php

namespace Modules\Users\Repositories;

use App\Models\Assignments;
use App\Models\Calendar;
use App\Models\Countries;
use App\Models\ExpirationTime;
use App\Models\GroupsUsers;
use App\Models\Languages;
use App\Models\ModulesUsers;
use App\Models\Passwords;
use App\Models\Projects;
use App\Models\Records;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Users\Dto\UsersDto;

class UsersRepositories
{
    public function getAllUsers($params)
    {
        $users = Users::with(['countries', 'expirationTime'])  // Превентивно ги вчитуваме релациите
        ->where('users.deleted', 0)
            ->select([
                'users.id',
                'users.name',
                'users.surname',
                'users.username',
                'users.email',
                'users.active',
                'users.id_expiration_time'
            ])
            ->withCount(['records' => function ($query) {
                    $query->where('deleted', 0);
                }
            ])
        ;

        // Филтрирање според внесените параметри
        if (isset($params['id'])) {
            $users->where('users.id', 'like', '%' . $params['id'] . '%');
        }
        if (isset($params['name'])) {
            $users->where('users.name', 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['surname'])) {
            $users->where('users.surname', 'like', '%' . $params['surname'] . '%');
        }
        if (isset($params['username'])) {
            $users->where('users.username', 'like', '%' . $params['username'] . '%');
        }
        if (isset($params['email'])) {
            $users->where('users.email', 'like', '%' . $params['email'] . '%');
        }

        // Пребарување преку users_countries (many-to-many)
        if (isset($params['id_country'])) {
            $users->whereHas('countries', function ($query) use ($params) {
                $query->where('_countries.id', $params['id_country']);
            });
        }

        if (isset($params['id_expiration_time'])) {
            $users->where('users.id_expiration_time', '=', $params['id_expiration_time']);
        }

        // Активен / Деактивиран корисник
        if (isset($params['active']) && empty($params['deactivated'])) {
            $users->where('users.active', '=', $params['active']);
        }
        if (isset($params['deactivated']) && empty($params['active'])) {
            $users->where('users.active', '=', 0);
        }

        // Пагинација и броење
        $listing = config('users.pagination');
        if (isset($params['listing'])) {
            $listing = $params['listing'] == 'a' ? $users->count() : $params['listing'];
        }

        // Сортирање
        $sort = $params['sort'] ?? 'DESC';
        $order = $params['order'] ?? 'id';
        if (in_array($order, ['projects', 'records'])) {
            $order = $order . '_count';  // Додај count за динамичките колони
        }
        $users->orderBy($order, $sort);

        return $users->paginate($listing);
    }

    public function getUserById($id)
    {
        $user = Users::where('id', '=', $id)->first();
        if ($user) {
            return $user;
        }
        return null;
    }

    public function getRecordById($id)
    {
        return Records::with(
            'countries',
            'assignments',
            'activities',
            'projects',
            'insertedByUser',
            'updatedByUser',
            'approvedByUser')->find($id);
    }

    public function getActivities($id_project)
    {
        $project = Projects::with('activities')->orderBy('name','ASC')->find($id_project);
        return $project ? $project->activities : collect();
    }

    public function getAssignments($id_project)
    {
        return Assignments::where('project', '=', $id_project)->orderBy('name','ASC')->get();
    }
    public function updateRecord($id_record, $data)
    {
        //dd($data);
        $record = Records::find($id_record);
        $date= Carbon::createFromFormat('d.m.Y', $data['date_'])->startOfDay()->format('Y-m-d H:i:s');
        $year= Carbon::createFromFormat('d.m.Y', $data['date_'])->format('Y');

        $lockrecord=isset($data['lockrecord'])?1:0;
        $approved=isset($data['approvedby'])?1:0;

        $dateofapproval=($approved==1)?now():null;
        $approvedby=($approved==1)?Auth::id():null;

        if ($record)

        $record->lockrecord = $lockrecord;
        $record->approvedby = $approvedby;
        $record->dateofapproval = $dateofapproval;
        $record->year = $year;
        $record->date = $date;
        $record->id_country = $data['id_country'];
        $record->project = $data['id_project'];
        $record->assignment = $data['id_assignment'];
        $record->activity = $data['id_activity'];
        $record->duration = $data['duration'];
        $record->note = $data['note'];
        $record->updatedby  = Auth::id();

        if ($record->save()) {
            return $record;
        }

        return null;
    }

    public function storeRecord($data)
    {
        //dd($data);
        $date= Carbon::createFromFormat('d.m.Y', $data['date_'])->startOfDay()->format('Y-m-d H:i:s');
        $year= Carbon::createFromFormat('d.m.Y', $data['date_'])->format('Y');

        $lockrecord=isset($data['lockrecord'])?1:0;
        $approved=isset($data['approvedby'])?1:0;

        $dateofapproval=($approved==1)?now():null;
        $approvedby=($approved==1)?Auth::id():null;

        $record = Records::create([

        'lockrecord' => $lockrecord,
        'approvedby' => $approvedby,
        'dateofapproval' => $dateofapproval,
        'year' => $year,
        'date' => $date,
        'id_country' => $data['id_country'],
        'project' => $data['id_project'],
        'assignment' => $data['id_assignment'],
        'activity' => $data['id_activity'],
        'duration' => $data['duration'],
        'note' => $data['note'],
        'insertedby'  =>  $data['id_user'],
        'updatedby'  => Auth::id(),
    ]);
        return $record;
    }


    public function getRecordsByIdUser($id_user, $params): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $year = $params['year'] ?? date('Y');
        $month = $params['month'] ?? date('m');


        $records = Records::with('activities', 'assignments', 'projects', 'countries')
            ->leftJoin('calendar', function ($join) {
                $join->on(DB::raw('DATE(records.date)'), '=', DB::raw('DATE(calendar.date)'));
            })
            ->leftJoin('projects', 'projects.id', '=', 'records.project')
            ->select('records.*', 'calendar.lock_ as locket_year', 'projects.name as project_name')
            ->where('records.insertedby', $id_user)
            ->where('records.deleted', 0);

        // Филтрирање по држава (ако е различно од 'all')
        if (isset($params['id_country']) && $params['id_country'] !== 'all') {
            $records->where('records.id_country', '=', $params['id_country']);
        }

        // Филтрирање по година (секогаш се бара одредена година)
        $records->where('records.year', '=', $year);

        // Филтрирање по месец (ако month не е 'all')
        if  ($month !== 'all') {
            //dd($month);
            $records->whereRaw('MONTH(records.date) = ?', [$month]);
        }
        // Конверзија и филтрирање по опсег на датуми (само делот Y-m-d)
        if (isset($params['date_from']) && isset($params['date_to'])) {
            $dateFrom = Carbon::createFromFormat('d.m.Y', $params['date_from'])->format('Y-m-d');
            $dateTo = Carbon::createFromFormat('d.m.Y', $params['date_to'])->format('Y-m-d');

            $records->whereRaw('DATE(records.date) BETWEEN ? AND ?', [$dateFrom, $dateTo]);
        } elseif (isset($params['date_from'])) {
            $dateFrom = Carbon::createFromFormat('d.m.Y', $params['date_from'])->format('Y-m-d');
            $records->whereRaw('DATE(records.date) >= ?', [$dateFrom]);
        } elseif (isset($params['date_to'])) {
            $dateTo = Carbon::createFromFormat('d.m.Y', $params['date_to'])->format('Y-m-d');
            $records->whereRaw('DATE(records.date) <= ?', [$dateTo]);
        }
        // Пресметка на lock и approved
        $lock = $records->clone()->where('lockrecord', 0)->exists() ? 0 : 1;
        $approved = $records->clone()->whereNull('approvedby')->exists() ? 0 : 1;

        // Пагинација и броење
        $listing = config('users.pagination_records');
        if (isset($params['listing'])) {
            $listing = $params['listing'] == 'a' ? $records->count() : $params['listing'];
        }

        // Сортирање
        if (!isset($params['sort']) && !isset($params['order'])) {
            $records->orderBy('records.id', 'DESC');
        } else {
            if($params['order']=='project'){
            $records->orderBy('project', $params['sort'] );}
            else{$records->orderBy($params['order'], $params['sort'] );}
        }

        $result = $records->paginate($listing);

        // Додавање на lock и approved на резултатот
        $result->lock = $lock;
        $result->approved = $approved;

        return $result;
    }


    public function storeUser($usersDto, $picture_name)
    {
//            $active = (isset($data['active'])) ? 1  : 0;

        $user = Users::create([
            'id_user_logged' => $usersDto->id_user_logged,
            'name' => $usersDto->name,
            'surname' => $usersDto->surname,
            'username' => $usersDto->username,
            'email' => $usersDto->email,
            'address' => $usersDto->address,
            'phone' => $usersDto->phone,
            'picture' => $picture_name,
           // 'id_country' => $usersDto->id_country,
            'id_expiration_time' => $usersDto->id_expiration_time,
            'user_type' => $usersDto->user_type,
            'active' => $usersDto->active,
        ]);


        return $user;

    }

    public function storeCountries($countries, $id_user)
    {
        $user = $this->getUserById($id_user);
        if (!$user) {
            return null;
        }
        $user->countries()->sync($countries);
        return $user;
    }

    public function updateUser($id, UsersDto $data, $picture_name)
    {
        $user = Users::where('id', '=', $id)->first();

        if ($user) {
            $user->name = $data->name;
            $user->surname = $data->surname;
            $user->username = $data->username;
            $user->email = $data->email;
            $user->address = $data->address;
            //$user->id_country = $data->id_country;
            $user->phone = $data->phone;
            $user->picture = $picture_name;
            $user->id_expiration_time = $data->id_expiration_time;
            $user->user_type = $data->user_type;

            if (isset($data->password)) {
                $user->password = Hash::make($data->password);
            }
            $user->active = $data->active;

            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }

//    public function updateCountries($id_user, $countries)
//    {
//        $user = $this->getUserById($id_user);
//        if (!$user) {
//            return null;
//        }
//        $user->countries()->sync($countries);
//        return $user;
//    }
    public function updateCountries($user_id, $countries)
    {
        // 1. Земи ги сите тековни записи на user во users_countries
        $existingCountries = DB::table('users_countries')
            ->where('id_user', $user_id)
            ->pluck('id_country')
            ->toArray();

        // 2. Земи ги сите id_country кои се во records
        $countriesInRecords = DB::table('records')
            ->where('insertedby', $user_id)
            ->where('deleted', 0)
            ->pluck('id_country')
            ->toArray();

        // 3. Пресметај кои треба да се додадат
        $countriesToAdd = array_diff($countries, $existingCountries);

        // 4. Пресметај кои треба да се избришат (ако ги нема во records)
        $countriesToDelete = array_diff($existingCountries, $countries, $countriesInRecords);

        // 5. Додај нови земји во users_countries
        foreach ($countriesToAdd as $country) {
            DB::table('users_countries')->insert([
                'id_user' => $user_id,
                'id_country' => $country
            ]);
        }

        // 6. Избриши ги земјите што не се во records
        DB::table('users_countries')
            ->where('id_user', $user_id)
            ->whereIn('id_country', $countriesToDelete)
            ->delete();

        return $countries;
    }
    public function getAllProjects()
    {
        //$formattedDate = Carbon::createFromFormat('d.m.Y H:i:s', $date)->format('Y-m-d');
        return Projects::where('deleted', 0)
            ->orderBy('name','ASC')
            ->get();
    }

    public function lockApproveRecords($data): bool
    {
        try {
            $recordsData = $data['records'] ?? [];
            $approvedRecords = $data['approvedby'] ?? [];
            $userId = $data['user'];
            $date = $data['date'];

            // Ажурирање на полето lockrecord
            foreach ($recordsData as $recordId => $lockStatus) {
                Records::where('id', $recordId)->update(['lockrecord' => $lockStatus]);
            }

            // Наоѓање на сите записи за одреден корисник што се предмет на ажурирање
            $recordIds = array_keys($recordsData);
            $records = Records::whereIn('id', $recordIds)->get();

            foreach ($records as $record) {
                if (array_key_exists($record->id, $approvedRecords)) {
                    // Ако checkbox е означен -> update
                    $record->approvedby = Auth::id();
                    $record->dateofapproval = $date;
                    $record->dateupdated = $date;
                    //$record->updatedby = Auth::id();
                } else {
                    // Ако checkbox не е означен -> избриши ги полето approvedby и датумот
                    $record->approvedby = null;
                    $record->dateofapproval = null;
                    $record->dateupdated = $date;
                    //$record->updatedby = $userId;
                }

                // Чувај ги промените за секој запис
                if (!$record->save()) {
                    return false;  // Враќа false ако не успее да се зачува запис
                }
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Error updating records: ' . $e->getMessage());
            return false;  // Грешка при извршување
        }
    }


    public function storePasswordUsers($id, $password)
    {
        $user = $this->getUserById($id);
        if ($user) {
            $user->password = $password;
            return $user->save();
        }
        return null;
    }

    public function storePasswordPasswords($id, $password)
    {
        if (isset($password) && isset($id)) {
            $user = $this->getUserById($id);
            if ($user) {
                $password = Passwords::create([
                    'id_user' => $id,
                    'password' => $password]);
                if ($password) {
                    return $password;
                }
                return null;
            }
            return null;
        }
        return null;
    }

    public function previousPasswords($id_user)
    {
        $previousPasswords = Passwords::where('id_user', $id_user)->pluck('password');
        if ($previousPasswords) {
            return $previousPasswords;
        }
        return null;
    }

    public function deleteUser($id)
    {
        $user = $this->getUserById($id);
        if ($user) {

            // Избриши ги записите од users_countries
//            $user->countries()->detach();
//            Users::where('id', '=', $id)->delete();
//            if (Storage::disk('publish')->exists('users/' . $id)) {
//                Storage::disk('publish')->delete('users/' . $id);
//            }
//
//            return $user;
          $user->deleted = 1;
          return $user->save();
        }
        return null;
    }

    public function deleteRecord($id): bool
    {
        //dd($id);
        $record = $this->getRecordById($id);

        if ($record) {
            $record->deleted = 1;
            return $record->save();
        }

        return false;
    }

    public function getAllCountries()
    {
        $countries = Countries::where('active', '=', '1')->get();;
        if ($countries) {
            return $countries;
        }
        return null;
    }

    public function getYears()
    {
        return Calendar::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->isNotEmpty() ? Calendar::select('year')->distinct()->orderBy('year', 'desc')->pluck('year') : null;
    }

    public function getAssignCountries($id_user)
    {
        $user = Users::find($id_user);
        if (!$user) {
            return null;
        }
        return $user->countries;
    }

    public function getAllExpirationTime()
    {
        $expirationTime = ExpirationTime::where('active', '=', '1')->get();;
        if ($expirationTime) {
            return $expirationTime;
        }
        return null;
    }

    public function storeNewHash($hash, $id_user, $type, $date)
    {
        $user = $this->getUserById($id_user);
        if ($user) {
            $user->password_reset_hash = $hash;
            $user->password_reset_type = $type;
            $user->password_reset_hash_date = $date;
            return $user->save();
        }
        return null;
    }

    public function storePrivileges($id_user, $user_type): ?bool
    {
        $user = Users::find($id_user);
        if (!$user) {
            return false;
        }
        // Избриши ги претходните модули и групи
        $user->modules()->detach();
        $user->groups()->detach();

        // Преземи ги модулите од конфигурацијата според `user_type`
        $userTypes = config('users.user_type');
        $newModules = collect($userTypes)
            ->where('value', $user_type)
            ->first()['modules'] ?? [];

        // Додај ги модулите за корисникот
        foreach ($newModules as $moduleId) {
            ModulesUsers::create([
                'user_id' => $id_user,
                'module_id' => $moduleId,
                'active' => true,
                'deleted' => false,
            ]);
        }
        return true;
    }

    public function addGroupToUser(int $userId, int $groupId): ?GroupsUsers
    {
        $exists = GroupsUsers::where('user_id', $userId)
            ->where('group_id', $groupId)
            ->exists();

        if (!$exists) {
            // Ако не постои, внеси нов запис
            return GroupsUsers::create([
                'user_id' => $userId,
                'group_id' => $groupId,
                'active' => true,       // Дополнителни полиња при креирање
                'deleted' => false,
            ]);
        }
        return null;
    }

    public function removeGroupToUser(int $userId, int $groupId): ?int
    {
        $records = GroupsUsers::where('user_id', $userId)
            ->where('group_id', $groupId)
            ->get();

        if ($records->isNotEmpty()) {
            return GroupsUsers::where('user_id', $userId)
                ->where('group_id', $groupId)
                ->delete();
        }
        return null;

    }

    public function getLanguagesByLang($lang)
    {
        return Languages::where('lang', '=', $lang)->first();
    }

}
