<?php

namespace Modules\Calendar\Repositories;

use App\Models\Countries;

use App\Models\Calendar;
use App\Models\Records;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalendarRepositories
{
    public function getAllCalendar($params)
    {
        if (!isset($params['year']) || !isset($params['id_country'])) {
            return collect();
        }

        $calendarRecords= Calendar::select([
            'calendar.id',
            'calendar.year',
            'calendar.day',
            'calendar.date',
            'calendar.lock_',
            DB::raw('IF(calendar_countries.id_country IS NOT NULL, 1, 0) AS is_holiday')
        ])
            ->leftJoin('calendar_countries', function ($join) use ($params) {
                $join->on('calendar.id', '=', 'calendar_countries.id_calendar')
                    ->where('calendar_countries.id_country', '=', $params['id_country']);
            })
            ->where('calendar.year', $params['year'])
            ->orderBy('calendar.date')
            ->get();

        $allLocked = $calendarRecords->min('lock_') == 1 ? 1 : 0;
        $calendarRecords->allLocked=$allLocked;
        return $calendarRecords;
    }


    public function getYears()
    {
        return Calendar::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->isNotEmpty() ? Calendar::select('year')->distinct()->orderBy('year', 'desc')->pluck('year') : null;
    }
    public function lastEnteredYear()
    {
        return Calendar::max('year');
    }
    public function checkYear($year)
    {
        return Calendar::where('year', $year)->exists();
    }

    public function getDefaultIdCountry()
    {
        return Countries::min('id');
    }

    public function insertHolidays($request): bool
    {
        $year = $request['year'];
        $countryId = $request['id_country'];  // Земаме id на земја
        $selectedHolidays = $request['holidays'] ?? [];
        $lockData = $request['lock'] ?? [];  // Преземи податоци од lock чекбоксовите

        // Бришење на постоечките записи за таа земја и година
        DB::table('calendar_countries')
            ->whereIn('id_calendar', function($query) use ($year) {
                $query->select('id')->from('calendar')->where('year', $year);
            })
            ->where('id_country', $countryId)
            ->delete();

        // Внесување нови записи за селектираните денови
        if (!empty($selectedHolidays)) {
            $holidays = [];

            foreach ($selectedHolidays as $calendarId => $value) {
                $holidays[] = [
                    'id_calendar' => $calendarId,
                    'id_country' => $countryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('calendar_countries')->insert($holidays);
        }
        // Постави lock_ = 1 за селектираните денови со еден SQL повик
        if (!empty($lockData)) {
            Calendar::whereIn('id', array_keys($lockData))
                ->update(['lock_' => 1]);
        }
        // Ажурирање на сите записи на lock_ = 0, освен оние што се селектирани
        Calendar::where('year', $year)
            ->whereNotIn('id', array_keys($lockData))
            ->update(['lock_' => 0]);

        return true;
    }
    public function enterYear($year): ?bool
    {

        $startDate = Carbon::create($year, 1, 1);
        $endDate = Carbon::create($year, 12, 31);
        $dates = [];

        // Внесување на сите денови во календарот
        while ($startDate->lte($endDate)) {
            $day = strtolower($startDate->format('D'));  // Ден во неделата (mon, tue, sat, sun)
            $dateString = $startDate->format('Y-m-d');

            // Внеси ден во calendar табелата
            $calendarEntry = Calendar::create([
                'year' => $year,
                'date' => $startDate->format('Y-m-d H:i:s'),
                'day' => $day,
            ]);

            // Ако е сабота, недела или е неработен ден, внеси запис во calendar_countries
           // if (in_array($day, ['sat', 'sun']) || in_array($dateString, $nonWorkingDays)) {
            if (in_array($day, ['sat', 'sun'])) {
                $dates[] = $calendarEntry->id;
            }

            $startDate->addDay();
        }

        // Сите земји што треба да бидат поврзани
        $countries = Countries::where('active', 1)->pluck('id');

        // Внес во pivot табелата calendar_countries за викенди и неработни денови
        $pivotData = [];
        foreach ($dates as $calendarId) {
            foreach ($countries as $countryId) {
                $pivotData[] = [
                    'id_calendar' => $calendarId,
                    'id_country' => $countryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Внесување на pivot податоци
        if (!empty($pivotData)) {
            DB::table('calendar_countries')->insert($pivotData);
        }

        return true;
    }

    public function getAllCountries()
    {
        $countries = Countries::where('active', '=', '1')->get();;
        if ($countries) {
            return $countries;
        }
        return null;
    }

    public function checkYearExist($year): bool
    {
        return Calendar::where('year', $year)->count() > 0;
    }
    public function checkYearIsUsed($year): bool
    {
        return Records::where('year', $year)->count() > 0;
    }

    public function deleteYear($year): bool
    {
        return DB::transaction(function () use ($year) {
            // Бришење на записи од calendar_countries поврзани со година
            DB::table('calendar_countries')
                ->whereIn('id_calendar', function ($query) use ($year) {
                    $query->select('id')
                        ->from('calendar')
                        ->where('year', $year);
                })
                ->delete();

            // Бришење на записи од calendar табелата
            return (bool) Calendar::where('year', $year)->delete();
        });
    }
}
