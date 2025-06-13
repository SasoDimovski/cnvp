<?php

namespace Modules\Projects\Repositories;

use App\Models\Activities;
use App\Models\Assignments;
use App\Models\Projects;
use App\Models\Records;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Dto\ProjectAssignmentsDto;
use Modules\Projects\Dto\ProjectsDto;

class ProjectsRepositories
{
    public function getAllProjects($params)
    {
        $query = Projects::where('deleted', 0)
            ->select([
                'id',
                'name',
                'description',
                'code',
                'type',
                'start_date',
                'end_date',
                'deleted',
                'dateinserted',
                'insertedby',
                'dateupdated',
                'updatedby',
                'active',
            ])
        ->withCount(['activities' => function ($query) {
            $query->where('deleted', 0);
        },
            'assignments' => function ($query) {
                $query->where('deleted', 0);
            },
            'records' => function ($query) {
                $query->where('deleted', 0);
            }
            ]);

        // Филтрирање според параметри
        $filterableFields = ['id', 'name', 'code'];
        foreach ($filterableFields as $field) {
            if (isset($params[$field])) {
                $query->where($field, 'like', '%' . $params[$field] . '%');
            }
        }
        // Филтрирање според timestamp полиња
        if (isset($params['start_date'])&& Carbon::hasFormat($params['start_date'], 'd.m.Y')) {
            $startDate = Carbon::createFromFormat('d.m.Y', $params['start_date'])->startOfDay()->toDateTimeString();
            $query->whereDate('start_date', '=', $startDate);
        }

        if (isset($params['end_date'])&& Carbon::hasFormat($params['end_date'], 'd.m.Y')) {
            $endDate = Carbon::createFromFormat('d.m.Y', $params['end_date'])->startOfDay()->toDateTimeString();
            $query->whereDate('end_date', '=', $endDate);
        }

        $expired=isset($params['expired'])?1:0;
        $expired_no=isset($params['expired_no'])?1:0;

        if ($expired==1 && $expired_no==0) {
            $query->where('end_date', '<', now());
        }

        if ($expired==0 && $expired_no==1) {
            $query->where('end_date', '>', now());
        }

        //dd('$params[active]:'.$active.'  /   '.'$params[deactivated]:'.$deactivated);
        // Филтрирање според `active` и `deactivated`
        $active=isset($params['active'])?1:0;
        $deactivated=isset($params['deactivated'])?1:0;

        if ($active==1 && $deactivated==0) {
            $query->where('active', 1);
        }
        if ($active==0 && $deactivated==1) {
            $query->where('active', 0);
        }


        // Pagination
        $listing = $params['listing'] ?? config('projects.pagination');
        if ($listing === 'a') {
            $listing = $query->count();
        }
        // Сортирање
        $sort = $params['sort'] ?? 'DESC';
        $order = $params['order'] ?? 'id';
        // Проверка дали се обидуваш да сортираш по assignments или activities
        if (in_array($order, ['assignments', 'activities', 'records'])) {
            $order = $order . '_count';  // Додај count за динамичките колони
        }
        $query->orderBy($order, $sort);

        return $query->paginate($listing);
    }

    public function storeProject($projectsDto)
    {
        $project= Projects::create([
            'name' => $projectsDto->name,
            'description' => $projectsDto->description,
            'code' => $projectsDto->code,
            'type' => $projectsDto->type,
            'start_date' => Carbon::createFromFormat('d.m.Y H:i:s', $projectsDto->start_date)->format('Y-m-d H:i:s'),
            'end_date' => Carbon::createFromFormat('d.m.Y H:i:s', $projectsDto->end_date)->format('Y-m-d H:i:s'),
            'insertedby' => Auth::id(),
            'updatedby' => Auth::id(),
            'active' => $projectsDto->active,
            'deleted' => 0,
        ]);
        return $project;

    }

    public function updateProject($id, ProjectsDto $data,)
    {
        $project = Projects::where('id', '=', $id)->first();

        if($project) {
            $project->name = $data->name;
            $project->description = $data->description;
            $project->type = $data->type;
            $project->code = $data->code;
            $project->start_date = Carbon::createFromFormat('d.m.Y H:i:s', $data->start_date)->format('Y-m-d H:i:s');
            $project->end_date = Carbon::createFromFormat('d.m.Y H:i:s', $data->end_date)->format('Y-m-d H:i:s');
            $project->dateinserted = $data->dateinserted;
            $project->dateupdated = $data->dateupdated;
            $project->updatedby = Auth::id();
            $project->active = $data->active;

            if ($project->save()) {
                return $project;
            }
        }
        return null;
    }
    public function updateAssignmentsDate($id, $end_date)
    {
        //dd($id);
        $updated = Assignments::where('project', '=', $id)->update(['end_date' => Carbon::createFromFormat('d.m.Y H:i:s', $end_date)->format('Y-m-d H:i:s')]);

        if($updated) {
            return Assignments::where('project', '=', $id)->get();
        }
        return null;
    }
    public function deleteProject($id)
    {
        $return = $this->getProjectById($id);
        if(!$return) {
            return null;
        }
        $return =Projects::where('id', '=', $id)->delete();
        if(!$return) {
            return null;
//          $users->deleted = 1;
//          return $users->save();
        }
        $records = Assignments::where('project', $id)->count();
        if ($records > 0) {
            Assignments::where('project', $id)->delete();
        }
        return $return;
    }
    public function getProjectById($id)
    {
        $return= Projects::where('id', '=', $id)->first();
        if ($return){
            return $return;
        }
        return null;
    }
    public function getUserById($id)
    {
        $return= Users::where('id', '=', $id)->first();
        if ($return){
            return $return;
        }
        return null;
    }

    public function getAllActivities(): ?\Illuminate\Database\Eloquent\Collection
    {
        $return = Activities::all();
        if ($return->isEmpty()) {
            return null;
        }
        return $return;
    }

    public function getActivitiesAssignment($id_project)
    {
        $project = Projects::find($id_project);
        if (!$project) {
            return null;
        }
        return $project->activities;
    }
    public function getAssignmentByIdProject($id_project)
    {

        $assignments = Assignments::where('project', $id_project)
            ->withCount('records')  // Пресметај колку записи има во records
            ->orderBy('id', 'desc')
            ->get();

        return $assignments;
    }

    public function storeActivities($id_project, $activities)
    {
        $project = $this->getProjectById($id_project);
        if (!$project) {
            return null;
        }
        $project->activities()->sync($activities);
        return $project;
    }
//    public function updateActivities($id_project, $activities)
//    {
//        $project = $this->getProjectById($id_project);
//        if (!$project) {
//            return null;
//        }
//        $project->activities()->sync($activities);
//        return $project;
//    }
    public function updateActivities($id_project, $activities)
    {
        // 1. Земи ги сите тековни активности за дадениот проект
        $existingActivities = DB::table('projects_activities')
            ->where('id_project', $id_project)
            ->pluck('id_activity')
            ->toArray();

        // 2. Земи ги сите активности кои се во records за овој проект
        $activitiesInRecords = DB::table('records')
            ->where('project', $id_project)
            ->pluck('activity')
            ->toArray();

        // 3. Пресметај кои активности треба да се додадат
        $activitiesToAdd = array_diff($activities, $existingActivities);

        // 4. Пресметај кои активности треба да се избришат (ако ги нема во records)
        $activitiesToDelete = array_diff($existingActivities, $activities, $activitiesInRecords);

        // 5. Додај нови активности во project_activities
        foreach ($activitiesToAdd as $activity) {
            DB::table('projects_activities')->insert([
                'id_project' => $id_project,
                'id_activity' => $activity
            ]);
        }

        // 6. Избриши ги активностите што не се во records
        DB::table('projects_activities')
            ->where('id_project', $id_project)
            ->whereIn('id_activity', $activitiesToDelete)
            ->delete();

        return $activities;
    }
    public function getAssignmentById($id)
    {
        $return= Assignments::where('id', '=', $id)->first();
        if ($return){
            return $return;
        }
        return null;
    }
    public function updateAssignment($id, ProjectAssignmentsDto $data)
{
    $assignment = Assignments::where('id', '=', $id)->first();

    if($assignment) {
        $assignment->name = $data->name;
        $assignment->description = $data->description;
        $assignment->code = $data->code;
        $assignment->start_date = Carbon::createFromFormat('d.m.Y H:i:s', $data->start_date)->format('Y-m-d H:i:s');
        $assignment->end_date = Carbon::createFromFormat('d.m.Y H:i:s', $data->end_date)->format('Y-m-d H:i:s');
        $assignment->updatedby = Auth::id();

        if ($assignment->save()) {
            return $assignment;
        }
    }
    return null;
}

public function storeAssignment($assignmentsDto,$id)
{
    $project = $this->getProjectById($id);
    if (!$project) {
        return null;
    }

    $start_date = isset($assignmentsDto->start_date)
        ? Carbon::createFromFormat('d.m.Y H:i:s', $assignmentsDto->start_date)->format('Y-m-d H:i:s')
        : $project->start_date;

    $end_date = isset($assignmentsDto->end_date)
        ? Carbon::createFromFormat('d.m.Y H:i:s', $assignmentsDto->end_date)->format('Y-m-d H:i:s')
        : $project->end_date;

    $assignment= Assignments::create([
        'name' => $assignmentsDto->name,
        'description' => $assignmentsDto->description,
        'code' => $assignmentsDto->code,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'project' => $id,
        'insertedby' => Auth::id(),
        'updatedby' => Auth::id(),
        'deleted' => 0,
    ]);
    return $assignment;

}

    public function checkIfAssignmentExistInRecords($id): bool
    {
        return Records::where('assignment', $id)->count() > 0;
    }
    public function deleteAssignment($id)
    {

        $return = $this->getAssignmentById($id);
        if($return) {
            Assignments::where('id', $id)->delete();
            return $return;
        }
        return null;

    }
}
