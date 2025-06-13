<?php

namespace Modules\Reports\Services;

use App\Models\Users;
use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;


use Illuminate\Support\Facades\Auth;
use Modules\Reports\Repositories\ReportsRepositories;

class ReportsServices
{
    protected ?string $classPath;
    public function __construct(public ReportsRepositories $reportsRepositories)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function index($lang,$params): array
    {
        $users = $this->reportsRepositories->getAllUsers($lang);
        $countries = $this->reportsRepositories->getAllCountries();
        $projects = $this->reportsRepositories->getAllProjects();
        $assignments = $this->reportsRepositories->getAllAssignments();
        $activities = $this->reportsRepositories->getAllActivities();
        $years = $this->reportsRepositories->getYears();
        $type = $params['type'] ?? 1;
//dd($type);
        if ($type == 1) {
            $data = $this->reportsRepositories->getAllRecordsDetail($params);
        } elseif ($type == 2) {
            $data = $this->reportsRepositories->getAllRecordsGroup($params);
        }
        //dd( $data['records']);

        return ['data' => [
            'users' => $users,
            'countries' => $countries,
            'years' => $years,
            'projects' => $projects,
            'assignments' => $assignments,
            'activities' => $activities,
            'records' =>  $data['records']
        ]];
    }

    public function getAllRecordsExcel($params): \Illuminate\Support\Collection
    {
        $type = $params['type'] ?? 1;
        if ($type == 1) {
            $records = $this->reportsRepositories->getAllRecordsDetail($params);
        } elseif ($type == 2) {
            $records = $this->reportsRepositories->getAllRecordsGroup($params);
        }
        //dd($records['records']);
        return $records['records']->getCollection();
    }


    public function getAllRecordsPdf($params): \Illuminate\Support\Collection
    {
        $type = $params['type'] ?? 1;
        if ($type == 1) {
            $records = $this->reportsRepositories->getAllRecordsDetail($params);
        } elseif ($type == 2) {
            $records = $this->reportsRepositories->getAllRecordsGroup($params);
        }
        //dd($records['projects']);
        // Врати ги како колекција
        return collect([
            'records' => $records['records']->getCollection(),
            'users' => $records['users'],
            'projects' => $records['projects'],
            'date1' => $records['date1'],
            'date2' => $records['date2'],
            'activityDurations' => $records['activityDurations'],
            'activities' => $records['activities'],
            'projectDurations' => $records['projectDurations'],
            'approvedUsers' => $records['approvedUsers'],
            'approvalStatus' => $records['approvalStatus'],
            'totalDurationWithoutProjectFilter' => $records['totalDurationWithoutProjectFilter'],
        ]);


    }
}
