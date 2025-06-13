<?php

namespace Modules\Records\Services;

use App\Models\Users;
use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;

use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Auth;
use Modules\Records\Repositories\RecordsRepositories;

class RecordsServices
{
    protected ?string $classPath;
    public function __construct(public RecordsRepositories $recordsRepositories)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function index( $id_user, $params): array
    {
        $calendar = $this->recordsRepositories->getAllCalendar($id_user,$params);

        $years = $this->recordsRepositories->getYears();

        $user = $this->recordsRepositories->getUserById(Auth::id());
        //dd($user);
        $lastEnteredYear = $this->recordsRepositories->lastEnteredYear();

        $assignCountries = $this->recordsRepositories->getAssignCountries(Auth::id());
        //dd($assignCountries);

        return ['data' => [
            'calendar' => $calendar,
            'user' => $user,
            'years' => $years,
            'lastEnteredYears' => $lastEnteredYear,
            'assignCountries' => $assignCountries,

        ]];
    }

    public function refreshIndex( $id_user, $params): array
    {
        $calendar = $this->recordsRepositories->getAllCalendar($id_user,$params);
        $years = $this->recordsRepositories->getYears();
        $user = $this->recordsRepositories->getUserById(Auth::id());
        $lastEnteredYear = $this->recordsRepositories->lastEnteredYear();
        $assignCountries = $this->recordsRepositories->getAssignCountries(Auth::id());
        return ['data' => [
            'calendar' => $calendar,
            'user' => $user,
            'years' => $years,
            'lastEnteredYears' => $lastEnteredYear,
            'assignCountries' => $assignCountries,
        ]];
    }

    public function editRecordDay($date,$id_country, $id_user): array
    {
        $projects = $this->recordsRepositories->getAllProjects($date);
        $activities = array();
        $assignments = array();
        $records = $this->recordsRepositories->getRecordsDay($date,$id_user,$id_country);
        $isHoliday = $this->recordsRepositories->isHoliday($date,$id_country);
//dd($isHoliday);
        return ['data' => [
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'records' => $records,
            'date' => $date,
            'id_country' => $id_country,
            'isHoliday' => $isHoliday,

        ]];
    }
    public function storeRecordDay($data): array
    {

        $this->recordsRepositories->storeRecordDay($data);

        $projects = $this->recordsRepositories->getAllProjects($data['date']);
        $activities = array();
        $assignments = array();
        $records = $this->recordsRepositories->getRecordsDay($data['date'], $data['insertedby'], $data['id_country']);
        $isHoliday = $this->recordsRepositories->isHoliday($data['date'],$data['id_country']);

        return ['data' => [

            'url_update' => $data['url_update'],
            'url_store' => $data['url_store'],
            'url_fill_dropdown' => $data['url_fill_dropdown'],
            'insertedby' => $data['insertedby'],
            'date' => $data['date'],
            'id_country' => $data['id_country'],
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'records' => $records,
            'isHoliday' => $isHoliday,


        ]];
    }
    public function updateRecordDay($id_record,$data): array
    {
        $this->recordsRepositories->updateRecordDay($id_record,$data);
        $projects = $this->recordsRepositories->getAllProjects($data['date']);
        $activities = array();
        $assignments = array();
        $records = $this->recordsRepositories->getRecordsDay($data['date'], $data['insertedby'], $data['id_country']);
        $isHoliday = $this->recordsRepositories->isHoliday($data['date'],$data['id_country']);
        return ['data' => [
            'url_update' => $data['url_update'],
            'url_store' => $data['url_store'],
            'url_fill_dropdown' => $data['url_fill_dropdown'],
            'insertedby' => $data['insertedby'],
            'date' => $data['date'],
            'id_country' => $data['id_country'],
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'records' => $records,
            'isHoliday' => $isHoliday,
        ]];
    }
    public function showRecordsDay($date,$id_country,$id_user): array
    {

        $records = $this->recordsRepositories->showRecordsDay($date,$id_user,$id_country);
//dd($records);
        return ['data' => [
            'records' => $records,
            'date' => $date,
            'id_country' => $id_country,

        ]];
    }
    public function deleteRecordsDay($date, $id_country, $id_user): ResponseSuccess|ResponseError
    {
        $return= $this->recordsRepositories->deleteRecordsDay($date, $id_country, $id_user);
        if (!$return) {
            return new ResponseError('',  '',['error_message'=>__('records.error_delete_record')]);
        }
        return new ResponseSuccess('method: deleteRecord($id)',$this->classPath,[]);
    }
    public function editRecordsWeek($date,$id_country, $id_user): array
    {
        $projects = $this->recordsRepositories->getAllProjects($date);
        $activities = array();
        $assignments = array();
        $records = $this->recordsRepositories->getRecordsWeekGroup($date,$id_user,$id_country);
        $nonWorkingDays = $this->recordsRepositories->getNonWorkingDays($date, $id_country);
//dd($records);
        return ['data' => [
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'records' => $records,
            'date' => $date,
            'id_country' => $id_country,
            'nonWorkingDays' => $nonWorkingDays,

        ]];
    }
    public function storeRecordsWeek($data): array
    {
        $this->recordsRepositories->storeRecordsWeek($data);

        $projects = $this->recordsRepositories->getAllProjects($data['date']);
        $activities = array();
        $assignments = array();
        $records = $this->recordsRepositories->getRecordsWeekGroup($data['date'], $data['insertedby'], $data['id_country']);
        $nonWorkingDays = $this->recordsRepositories->getNonWorkingDays($data['date'], $data['id_country']);
        return ['data' => [

            'url_update' => $data['url_update'],
            'url_store' => $data['url_store'],
            'url_fill_dropdown' => $data['url_fill_dropdown'],
            'insertedby' => $data['insertedby'],
            'id_country' => $data['id_country'],
            'date' => $data['date'],
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'records' => $records,
            'nonWorkingDays' => $nonWorkingDays,

        ]];
    }
    public function updateRecordsWeek($data): array
    {
        $this->recordsRepositories->updateRecordsWeek($data);

        $projects = $this->recordsRepositories->getAllProjects($data['date']);
        $activities = array();
        $assignments = array();
        $records = $this->recordsRepositories->getRecordsWeekGroup($data['date'], $data['insertedby'], $data['id_country']);
        $nonWorkingDays = $this->recordsRepositories->getNonWorkingDays($data['date'], $data['id_country']);
        //dd($nonWorkingDays);
        return ['data' => [

            'url_update' => $data['url_update'],
            'url_store' => $data['url_store'],
            'url_fill_dropdown' => $data['url_fill_dropdown'],
            'insertedby' => $data['insertedby'],
            'id_country' => $data['id_country'],
            'date' => $data['date'],
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'records' => $records,
            'nonWorkingDays' => $nonWorkingDays,

        ]];
    }

    public function showRecordsWeek($date,$id_country,$id_user): array
    {
        $records = $this->recordsRepositories->showRecordsWeek($date,$id_user,$id_country);
        return ['data' => [
            'records' => $records,
            'date' => $date,
            'id_country' => $id_country,

        ]];
    }
    public function deleteRecordsWeek($date, $id_country, $id_user): ResponseSuccess|ResponseError
    {
        $return= $this->recordsRepositories->deleteRecordsWeek($date, $id_country, $id_user);
        if (!$return) {
            return new ResponseError('',  '',['error_message'=>__('records.error_delete_record')]);
        }
        return new ResponseSuccess('method: deleteRecord($id)',$this->classPath,[]);
    }


    public function indexRecordsTable($id_user,$params): array
    {
       // dd($params['year']);
        $user = $this->recordsRepositories->getUserById($id_user);
        $records = $this->recordsRepositories->getRecordsTableByIdUser($id_user,$params);
        $countries = $this->recordsRepositories->getAllCountries();
        $assignCountries = $this->recordsRepositories->getAssignCountries($id_user);
        $years = $this->recordsRepositories->getYears();
        $isYearLocked=$this->recordsRepositories->isYearLocked($params);
        return ['data' => [
            'records' => $records,
            'countries' => $countries,
            'assignCountries' => $assignCountries,
            'years' => $years,
            'user' => $user,
            'isYearLocked' => $isYearLocked
        ]];

    }
    public function createRecordTable($year,$id_user): array
    {
        $assignCountries = $this->recordsRepositories->getAssignCountries($id_user);
        $projects = $this->recordsRepositories->getAllProjectsTable($year);
        $locketDays= $this->recordsRepositories->getLockedDaysInYear($year);
        //dd($locketDays);
        $activities = array();
        $assignments = array();
        return ['data' => [
            'assignCountries' => $assignCountries,
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'locketDays' => $locketDays,
        ]];
    }
    public function storeRecordTable($data): ResponseSuccess|ResponseError
    {
        $lockApproveRecords = $this->recordsRepositories->storeRecordTable($data);
        if (!$lockApproveRecords) {
            return new ResponseError('storeRecord($data)',  $this->classPath,[]);
        }
        return new ResponseSuccess('storeRecord($data)',$this->classPath,[]);
    }
    public function editRecordTable($year,$id_record, $id_user): array
    {
        $record = $this->recordsRepositories->getRecordById($id_record);
        $assignCountries = $this->recordsRepositories->getAssignCountries($id_user);
        $projects = $this->recordsRepositories->getAllProjectsTable($year);
        $activities = $this->recordsRepositories->getActivities($record->project);
        $assignments = $this->recordsRepositories->getAssignments($record->project);
        $locketDays= $this->recordsRepositories->getLockedDaysInYear($year);
        //dd($locketDays);
        return ['data' => [
            'record' => $record,
            'assignCountries' => $assignCountries,
            'projects' => $projects,
            'activities' => $activities,
            'assignments' => $assignments,
            'locketDays' => $locketDays,

        ]];
    }
    public function updateRecordTable($id_record,$data): ResponseSuccess|ResponseError
    {
        $lockApproveRecords = $this->recordsRepositories->updateRecordTable($id_record,$data);
        if (!$lockApproveRecords) {
            return new ResponseError('updateRecord($data)',  $this->classPath,[]);
        }
        return new ResponseSuccess('updateRecord($data)',$this->classPath,[]);
    }
    public function showRecordTable($id): array
    {
        //dd($id);
        $user = $this->recordsRepositories->getUserById($id);
        $record = $this->recordsRepositories->getRecordById($id);
        return ['data' => [
            'user' => $user,
            'record' => $record,
        ]];
    }
    public function deleteRecordTable($id): ResponseSuccess|ResponseError
    {
        $return= $this->recordsRepositories->deleteRecordTable($id);
        if (!$return) {
            return new ResponseError('method: deleteRecord($id)',  $this->classPath,[]);
        }
        return new ResponseSuccess('method: deleteRecord($id)',$this->classPath,[]);
    }


    public function getActivities($id_project): array
    {
        $activities = $this->recordsRepositories->getActivities($id_project);
        return ['data' => [
            'activities' => $activities,
        ]];
    }
    public function getAssignments($id_project): array
    {
        $assignments = $this->recordsRepositories->getAssignments($id_project);
        return ['data' => [
            'assignments' => $assignments,
        ]];
    }
}
