<?php

namespace Modules\Activities\Repositories;

use App\Models\Activities;
use App\Models\Records;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Modules\Activities\Dto\ActivitiesDto;

class ActivitiesRepositories
{
    public function getAllActivities($params)
    {
        $query = Activities::where('deleted', 0)
            ->select([
                'id',
                'name',
                'type',
                'deleted',
                'dateinserted',
                'insertedby',
                'dateupdated',
                'updatedby',
            ])
            ->withCount(['projects' => function ($query) {
                $query->where('deleted', 0);
            },
                'records' => function ($query) {
                $query->where('deleted', 0);
            }
            ])

        ;


        // Филтрирање според параметри
        $filterableFields = ['id', 'name'];
        foreach ($filterableFields as $field) {
            if (isset($params[$field])) {
                $query->where($field, 'like', '%' . $params[$field] . '%');
            }
        }

        // Pagination
        $listing = $params['listing'] ?? config('activities.pagination');
        if ($listing === 'a') {
            $listing = $query->count();
        }
        // Сортирање
        $sort = $params['sort'] ?? 'DESC';
        $order = $params['order'] ?? 'id';
        if (in_array($order, ['projects', 'records'])) {
            $order = $order . '_count';  // Додај count за динамичките колони
        }
        $query->orderBy($order, $sort);

        return $query->paginate($listing);
    }

    public function storeActivity($activitysDto)
    {
        $activity= Activities::create([
            'name' => $activitysDto->name,
            'type' => $activitysDto->type,
            'insertedby' => Auth::id(),
            'updatedby' => Auth::id(),
            'deleted' => 0,
        ]);
        return $activity;

    }

    public function updateActivity($id, ActivitiesDto $data)
    {
        $activity = Activities::where('id', '=', $id)->first();

        if($activity) {
            $activity->type = $data->type;
            $activity->name = $data->name;
            $activity->updatedby = Auth::id();
            if ($activity->save()) {
                return $activity;
            }
        }
        return null;
    }

    public function checkIfActivityExist($id): bool
    {
        return Activities::where('id', $id)->exists();
    }
    public function checkIfActivityExistInRecords($id): bool
    {
        return Records::where('activity', $id)->count() > 0;
    }
    public function checkIfActivityExistInProjects($id): bool
    {
        return Activities::where('id', $id)->whereHas('projects')->exists();
    }
    public function deleteActivity($id): bool
    {
        $activity = Activities::find($id);
        if (!$activity) {
            return false;  // Враќа false ако записот не постои
        }
        return $activity->delete();
    }
    public function getActivityById($id)
    {
        return Activities::with('projects')
        ->where('id', $id)
        ->first();
    }
    public function getUserById($id)
    {
        $return= Users::where('id', '=', $id)->first();
        if ($return){
            return $return;
        }
        return null;
    }

}
