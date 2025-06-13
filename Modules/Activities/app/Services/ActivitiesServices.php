<?php

namespace Modules\Activities\Services;


use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;
use Modules\Activities\Repositories\ActivitiesRepositories;
use Modules\Activities\Dto\ActivitiesDto;


class ActivitiesServices
{
    protected ?string $classPath;
    public function __construct(public ActivitiesRepositories $activitiesRepositories)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function index($params): array
    {
        $activities= $this->activitiesRepositories->getAllActivities($params);
        return ['data' => [
            'activities' => $activities,
        ]];
    }


    public function store(ActivitiesDto $activitiesDto): ResponseError|ResponseSuccess
    {
        // STORE ACTIVITY
        $activity = $this->activitiesRepositories->storeActivity($activitiesDto);
        if (!$activity) {
            return new ResponseError('method: storeActivities($activity->id,$activities)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',['id'=>$activity->id]);
    }

    public function show($id): array
    {
        $activity = $this->activitiesRepositories->getActivityById($id);
        $insertedby = $activity->insertedby ;
        $updatedby = $activity->updatedby;

        $updatedby = $this->activitiesRepositories->getUserById($updatedby);
        $insertedby = $this->activitiesRepositories->getUserById($insertedby);

        $insertedby = $insertedby->username ?? __('activities.ActivitiesServices.no_existing_user');
        $updatedby = $updatedby->username  ?? __('activities.ActivitiesServices.no_existing_user');

        return ['data' => [
            'activity' => $activity,
            'updatedby_' => $updatedby,
            'insertedby_' => $insertedby,
        ]];
    }

    public function edit( int $id): array
    {
        $activity = $this->activitiesRepositories->getActivityById($id);

        $insertedby = $activity->insertedby ;
        $updatedby = $activity->updatedby;

        $updatedby = $this->activitiesRepositories->getUserById($updatedby);
        $insertedby = $this->activitiesRepositories->getUserById($insertedby);

        $insertedby = $insertedby->username ?? __('activities.ActivitiesServices.no_existing_user');
        $updatedby = $updatedby->username  ?? __('activities.ActivitiesServices.no_existing_user');

        return ['data' => [
            'activity' => $activity,
            'updatedby_' => $updatedby,
            'insertedby_' => $insertedby,
        ]];
    }
    public function update(ActivitiesDto $activitiesDto): ResponseSuccess|ResponseError
    {
        $id = $activitiesDto->id;

        // CHECK IF PROJECT EXIST ///////////////////////////////////////////////
        $activity = $this->activitiesRepositories->getActivityById($id);

        if (!$activity) {
            return new ResponseError('method: getActivityById($id)',  $this->classPath,[]);
        }
        // UPDATE ACTIVITIES
        $activity = $this->activitiesRepositories->updateActivity($id, $activitiesDto);
        if (!$activity) {
            return new ResponseError('method: updateActivity($id, $request->all(), $picture_name)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',[]);
    }
    public function deleteActivity($id): ResponseSuccess|ResponseError
    {

        $return= $this->activitiesRepositories->checkIfActivityExist($id);
        if (!$return) {
            return new ResponseError('checkIfActivityExist($id)', $this->classPath, ['error_message' => __('activities.ActivitiesServices.delete_no_exist')]);
        }

        $return= $this->activitiesRepositories->checkIfActivityExistInRecords($id);
        if ($return) {
            return new ResponseError('checkIfActivityExistInRecords($id)', $this->classPath, ['error_message' => __('activities.ActivitiesServices.error_delete_activity')]);
        }

        $return= $this->activitiesRepositories->checkIfActivityExistInProjects($id);
        if ($return) {
            return new ResponseError('checkIfActivityExistInProjects($id)', $this->classPath, ['error_message' => __('activities.ActivitiesServices.delete_no_attached_projects')]);
        }

        $return= $this->activitiesRepositories->deleteActivity($id);
        if (!$return) {
            return new ResponseError('deleteActivity($id)',  $this->classPath, ['error_message' => __('activities.ActivitiesServices.deleted_error')]);
        }

        return new ResponseSuccess('deleteActivity($id)',$this->classPath,['success_message' => __('activities.ActivitiesServices.deleted')]);
    }
}
