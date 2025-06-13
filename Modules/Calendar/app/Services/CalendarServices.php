<?php

namespace Modules\Calendar\Services;

use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;

use Modules\Calendar\Repositories\CalendarRepositories;

class CalendarServices
{
    protected ?string $classPath;
    public function __construct(public CalendarRepositories $calendarRepositories)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function index($params): array
    {
        $calendar = $this->calendarRepositories->getAllCalendar($params);
        $years = $this->calendarRepositories->getYears();
        $countries = $this->calendarRepositories->getAllCountries();
        $lastEnteredYear = $this->calendarRepositories->lastEnteredYear();

//        $allLocked = $calendar['all_locked'];

        return ['data' => [
            'calendar' => $calendar,
            'countries' => $countries,
            'years' => $years,
            'lastEnteredYears' => $lastEnteredYear,
//            'allLocked' => $allLocked,
        ]];
    }

    public function newYear($year, $id_country): ResponseError|ResponseSuccess
    {

        $checkYear= $this->calendarRepositories->checkYear($year);

        if ($checkYear) {
            return new ResponseError('checkYear($year)',  $this->classPath, ['error_message'=>__('calendar.entered_year', ['year' => $year])]);
        }

        $enterYear= $this->calendarRepositories->enterYear($year);
        if (!$enterYear) {
            return new ResponseError('enterYear($year)',  $this->classPath, ['error_message'=>__('calendar.error_enter_year', ['year' => $year])]);
        }
        $getDefaultIdCountry= $this->calendarRepositories->getDefaultIdCountry();
        $id_country = !empty($id_country) ? $id_country: $getDefaultIdCountry;

        return new ResponseSuccess('newYear($year)',
            $this->classPath,
            ['success_message'=>__('calendar.success_enter_year', ['year' => $year]),
                'id_country' => $id_country]
        );
    }
    public function insertHolidays($request): ResponseSuccess|ResponseError
    {
        $insertHolidays= $this->calendarRepositories->insertHolidays($request);
        if (!$insertHolidays) {
            return new ResponseError('insertHolidays($request)',  $this->classPath, ['error_message'=>__('calendar.error_enter_holidays')]);
        }
        return new ResponseSuccess('insertHolidays($request)',
            $this->classPath,
            ['success_message'=>__('calendar.success_enter_holidays')]
        );
    }

    public function deleteYear($year): ResponseSuccess|ResponseError
    {
        $checkYearExist= $this->calendarRepositories->checkYearExist($year);

        if (!$checkYearExist) {
            return new ResponseError('checkYearExist($year)', $this->classPath, ['error_message' => __('calendar.error_year_not_found',['year'=>$year])]);
        }

        $checkYearIsUsed= $this->calendarRepositories->checkYearIsUsed($year);

        if ($checkYearIsUsed) {
            return new ResponseError('checkYearIsUsed($year)', $this->classPath, ['error_message' => __('calendar.error_year_is_used',['year'=>$year])]);
        }

        $return= $this->calendarRepositories->deleteYear($year);

        if (!$return) {
            return new ResponseError('deleteYear($id)', $this->classPath, ['error_message' => __('calendar.error_year_delete',['year'=>$year])]);
        }

        return new ResponseSuccess('deleteYear($year)', $this->classPath, ['success_message' => __('calendar.delete_success',['year'=>$year])]);
    }

}
