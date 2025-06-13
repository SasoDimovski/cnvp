<?php

namespace Modules\Records\Repositories;

use App\Models\Activities;
use App\Models\Assignments;
use App\Models\Calendar;
use App\Models\Countries;

use App\Models\Projects;
use App\Models\Records;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecordsRepositories
{
    public function getAllCalendar($id_user, $params)
    {
        $year = $params['year'] ?? date('Y');
        $month = $params['month'] ?? date('m');

        // Наоѓање на последната земја од users_countries за дадениот корисник
        $id_country = $params['id_country'] ?? DB::table('users_countries')
            ->where('id_user', $id_user)
            ->orderBy('id','asc')
            ->value('id_country');
//dd($id_country);
        if (!$id_country) {
            return collect();
        }

        // Пресметка на првиот и последниот ден од месецот или годинава
        if ($month === 'all') {
            $startOfMonth = Carbon::create($year, 1, 1)->startOfDay();
            $endOfMonth = Carbon::create($year, 12, 31)->endOfDay();
        } else {
            $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
            $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        }

        // Наоѓање на неделата што го содржи првиот и последниот ден
        $startOfWeek = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $records= Calendar::select([
            'calendar.id',
            'calendar.year',
            'calendar.day',
            'calendar.date',
            'calendar.lock_',
            DB::raw('IF(calendar_countries.id_country IS NOT NULL, 1, 0) AS is_holiday'),
            DB::raw('SUM(records.duration) AS total_duration')  // Пресметка на збир за секој ден
        ])
            ->leftJoin('calendar_countries', function ($join) use ($id_country) {
                $join->on('calendar.id', '=', 'calendar_countries.id_calendar')
                    ->where('calendar_countries.id_country', '=', $id_country);
            })
            ->leftJoin('records', function ($join) use ($id_user, $id_country) {
                $join->on(DB::raw('DATE(calendar.date)'), '=', DB::raw('DATE(records.date)'))
                    ->where('records.insertedby', '=', $id_user)
                    ->where('records.id_country', '=', $id_country);  // Додавање на проверка по id_country
            })
            ->whereBetween('calendar.date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->groupBy('calendar.id', 'calendar.year', 'calendar.day', 'calendar.date', 'calendar_countries.id_country')
            ->orderBy('calendar.date')
            ->get();


        $allLocked = $records->min('lock_') == 1 ? 1 : 0;
        $records->allLocked=$allLocked;
        return $records;
    }


    public function storeRecordDay($data)
    {
        // Генерирај ја неделата врз основа на датата
        $date = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfDay();
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        // Генерирај уникатен id_group за нова група ако е потребно
//        $lastGroupId = Records::where('insertedby', $data['insertedby'])
//            ->where('id_country', $data['id_country'])
//            ->where('date', $data['date'])
//            -> max('id_group') ?? 0;
//        $newGroupId = $lastGroupId + 1;


        $lastGroupId = Records::where('insertedby', $data['insertedby'])
            ->where('id_country', $data['id_country'])
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            -> max('id_group') ?? 0;
            $newGroupId = $lastGroupId + 1;

        //dd($newGroupId);
        $selectedGroupId = $newGroupId;

//        // Извлечи ги сите id_group кои веќе постојат за таа недела
//        $existingGroups = Records::where('insertedby', $data['insertedby'])
//            ->whereBetween('date', [$startOfWeek, $endOfWeek])
//            ->pluck('id_group')
//            ->unique();
//
//        // Најди ја id_group која нема запис за дадениот ден
//        $selectedGroupId = null;
//        foreach ($existingGroups as $groupId) {
//            $hasRecordForDate = Records::where('id_group', $groupId)
//                ->where('date', $date)
//                ->where('id_country', $data['id_country'])
//                ->exists();
//
//            if (!$hasRecordForDate) {
//                $selectedGroupId = $groupId;
//                break;
//            }
//        }
//
//        // Ако не постои слободна id_group, користете нова
//        if (!$selectedGroupId) {
//            $selectedGroupId = $newGroupId;
//        }




        //dd($selectedGroupId);
        // Креирај нов запис со избраната id_group
        return Records::create([
            'id_group' => $selectedGroupId,
            'id_country' => $data['id_country'],
            'project' => $data['id_project'],
            'assignment' => $data['id_assignment'],
            'activity' => $data['id_activity'],
            'duration' => $data['duration'],
            'note' => $data['note'],

            'date' => $date->format('Y-m-d H:i:s'),
            'year' => $date->format('Y'),

            'insertedby' => $data['insertedby'],
            'updatedby' => $data['insertedby'],

            'lockrecord' => 0,
            'deleted' => 0,
        ]);
    }
    public function updateRecordDay($id_record, $data)
    {
        $record = Records::find($id_record);

        if ($record && $data['id_project'] && $data['id_assignment'] && $data['id_activity']) {

            if (!$data['duration'] && empty($data['duration']) !== null) {
                return $record->delete();
            }

            $hasChanges =
                $record->id_country !== $data['id_country'] ||
                $record->project !== $data['id_project'] ||
                $record->assignment !== $data['id_assignment'] ||
                $record->activity !== $data['id_activity'] ||
                $record->note !== $data['note'] ||
                $record->duration !== $data['duration'];

            if ($hasChanges) {

                $record->id_country = $data['id_country'];
                $record->project = $data['id_project'];
                $record->assignment = $data['id_assignment'];
                $record->activity = $data['id_activity'];
                $record->note = $data['note'];
                $record->updatedby = Auth::id();
                $record->duration = $data['duration'];

                $record->save();
                return $record;
            }

        }

        return null;
    }


    public function getRecordsWeekGroup($date, $id_user, $id_country): \Illuminate\Support\Collection
    {

        // Пресметка на датумот на крајот на неделата (недела)
        $selectedDate = Carbon::createFromFormat('Y-m-d', $date);

        // Пресметка на почетокот на неделата (понеделник)
        $startOfWeek = $selectedDate->copy()->startOfWeek(Carbon::MONDAY);

        // Пресметка на крајот на неделата (недела)
        $endOfWeek = $selectedDate->copy()->endOfWeek(Carbon::SUNDAY);

        $records = Records::with([
            'activities',
            'assignments',
            'projects.assignments',
            'projects.activities'
        ])
            ->whereNotNull('id_group')
            ->where('insertedby', $id_user)
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->where('id_country', $id_country)
            ->orderBy('id', 'asc')
            ->get();

        $groupedRecords = $records->groupBy(function ($record) {
            return ($record->project ?? 'no_project') . '_' .
                ($record->activity ?? 'no_activity') . '_' .
                ($record->assignment ?? 'no_assignment') . '_' .
                ($record->id_group ?? 'no_group');
        });

        $result = $groupedRecords->map(function ($group) {
            $firstRecord = $group->first();

            $dates = $group->pluck('date')->values()->all();
            $durations = $group->pluck('duration')->values()->all();
            $note= $group->pluck('note')->values()->all();

            // Комбинирајте ги датумите и времетраењата
            $dateDurations = [];
            for ($i = 0; $i < 7; $i++) {
                $dateDurations[] = [
                    'date' => $dates[$i] ?? null,
                    'duration' => $durations[$i] ?? null,
                    'note' => $note[$i] ?? null,

                ];
            }
            return [
                //'note' => $firstRecord->note,
                'id_group' => $firstRecord->id_group,
                'id_project' => $firstRecord->project,
                'id_activity' => $firstRecord->activity,
                'id_assignment' => $firstRecord->assignment,
                'project_assignments' => $firstRecord->projects->assignments->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'name' => $assignment->name
                    ];
                }),
                'project_activities' => $firstRecord->projects->activities->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'name' => $activity->name
                    ];
                }),
                'date_durations' => $dateDurations,
            ];
        });

        return $result->values();
    }
    public function storeRecordsWeek($data)
    {
        if (!isset($data['duration']) || empty($data['duration'])) {
            return redirect()->back()->with('error', 'No durations provided.');
        }
        // Генерирај ја неделата врз основа на датата
        $date = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfDay();
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        // Генерирај уникатен id_group за овој user
        $lastGroupId = Records::where('insertedby', $data['insertedby'])
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->where('id_country', $data['id_country'])
            ->max('id_group') ?? 0;
        $newGroupId = $lastGroupId + 1;

        $year = isset($data['date']) ? Carbon::createFromFormat('Y-m-d', $data['date'])->year : null;
        $recordsToInsert = [];

        foreach ($data['duration'] as $day => $duration) {
            if (!empty($duration)) {
                $recordsToInsert[] = [
                    'id_group' => $newGroupId,
                    'insertedby' => $data['insertedby'],
                    'updatedby' => $data['insertedby'],
                    'id_country' => $data['id_country'] ?? null,
                    'date' => $day, // Земете ја датата од полето name
                    'year' => Carbon::parse($day)->year ?? $year,
                    'project' => $data['id_project'] ?? null,
                    'assignment' => $data['id_assignment'] ?? null,
                    'activity' => $data['id_activity'] ?? null,
                    'note' => $data['note'] ?? null,
                    'duration' => $duration,
                    'dateinserted' => now(),
                    'dateupdated' => now(),
                ];
            }
        }

        if (!empty($recordsToInsert)) {
            Records::insert($recordsToInsert);
        }
    }

    public function updateRecordsWeek($data): true
    {
//dd($data);
        $idGroups = explode(',', $data['id_group']); // Поделете ги `id_group` на низа

        foreach ($idGroups as $id_group) {
            $year = isset($data['date']) ? Carbon::createFromFormat('Y-m-d', $data['date'])->year : null;

            // Подготовка на податоци
            $idProject = $data['id_project' . $id_group] ?? null;
            $idAssignment = $data['id_assignment' . $id_group] ?? null;
            $idActivity = $data['id_activity' . $id_group] ?? null;
            $idCountry = $data['id_country'] ?? null;

            foreach ($data['duration' . $id_group] as $date => $duration) {


                // Најди го постоечкиот запис
                $record = Records::where('id_group', $id_group)
                    ->whereDate('date', $date)
                    ->where('id_country', $idCountry)
                    ->where('insertedby', Auth::id())
                    ->first();
                //dd($idAssignment);
                // Ако `duration` е празно или 0, избриши го записот ако постои
                if ($record && (empty($duration) || $duration == 0)) {

                    Records::where('id_group', $id_group)
                        ->whereDate('date', $date)
                        ->where('id_country', $idCountry)
                        ->where('insertedby', Auth::id())
                        ->delete();
                }


                // Провери дали нешто навистина треба да се ажурира
                elseif ($record && $duration && $idProject && $idAssignment && $idActivity &&
                    ($record->project != $idProject ||
                        $record->assignment != $idAssignment ||
                        $record->activity != $idActivity ||
                        $record->duration != $duration)
                ) {
                    // Ако има промена, ажурирај го записот

                    $record->update([
                        'project' => $idProject,
                        'assignment' => $idAssignment,
                        'activity' => $idActivity,
                        'duration' => $duration,
                        'updatedby' => Auth::id(),
                        'dateupdated' => now(),
                    ]);
                }
                // Ако записот не постои, креирај нов
                elseif (!$record && $duration && $idProject && $idAssignment && $idActivity) {

                    Records::create([
                        'id_group' => $id_group,
                        'date' => $date,
                        'year' => $year,
                        'insertedby' => Auth::id(),
                        'id_country' => $idCountry,
                        'project' => $idProject,
                        'assignment' => $idAssignment,
                        'activity' => $idActivity,
                        'duration' => $duration,
                        'dateinserted' => now(),
                        'updatedby' => Auth::id(),
                        'dateupdated' => now(),
                    ]);
                }
            }
        }
        return true;
    }




    public function storeRecordTable($data)
    {
        // Генерирај ја неделата врз основа на датата
        $date = Carbon::createFromFormat('d.m.Y', $data['date_'])->startOfDay();
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        // Генерирај уникатен id_group за нова група ако е потребно
        $lastGroupId = Records::where('insertedby', $data['id_user'])
            ->where('id_country', $data['id_country'])
            ->where('date', $data['date_'])
            -> max('id_group') ?? 0;
        $newGroupId = $lastGroupId + 1;
        //dd($newGroupId);
        // Извлечи ги сите id_group кои веќе постојат за таа недела
        $existingGroups = Records::where('insertedby', $data['id_user'])
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->pluck('id_group')
            ->unique();

        // Најди ја id_group која нема запис за дадениот ден
        $selectedGroupId = null;
        foreach ($existingGroups as $groupId) {
            $hasRecordForDate = Records::where('id_group', $groupId)
                ->where('date', $date)
                ->where('id_country', $data['id_country'])
                ->exists();

            if (!$hasRecordForDate) {
                $selectedGroupId = $groupId;
                break;
            }
        }

        // Ако не постои слободна id_group, користете нова
        if (!$selectedGroupId) {
            $selectedGroupId = $newGroupId;
        }

        $date= Carbon::createFromFormat('d.m.Y', $data['date_'])->startOfDay()->format('Y-m-d H:i:s');
        $year= Carbon::createFromFormat('d.m.Y', $data['date_'])->format('Y');

        $record = Records::create([
            'year' => $year,
            'date' => $date,
            'id_group' => $selectedGroupId,
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
    public function updateRecordTable($id_record, $data)
    {
        $record = Records::find($id_record);
        $date= Carbon::createFromFormat('d.m.Y', $data['date_'])->startOfDay()->format('Y-m-d H:i:s');
        $year= Carbon::createFromFormat('d.m.Y', $data['date_'])->format('Y');

        if ($record && $data['id_project'] && $data['id_assignment'] && $data['id_activity']) {

            $hasChanges =
                $record->year !== $year ||
                $record->date !== $date ||
                $record->id_country !== $data['id_country'] ||
                $record->project !== $data['id_project'] ||
                $record->assignment !== $data['id_assignment'] ||
                $record->activity !== $data['id_activity'] ||
                $record->note !== $data['note'] ||
                $record->duration !== $data['duration'];

            if ($hasChanges) {

                $record->year = $year;
                $record->date = $date;
                $record->id_country = $data['id_country'];
                $record->project = $data['id_project'];
                $record->assignment = $data['id_assignment'];
                $record->activity = $data['id_activity'];
                $record->note = $data['note'];
                $record->updatedby = Auth::id();
                $record->duration = $data['duration'];

                $record->save();
                return $record;
            }

        }

        return null;
    }
    public function deleteRecordTable($id): bool
    {
        $record = $this->getRecordById($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    public function getNonWorkingDays($date, $id_country): array
    {
        // Конвертирај го датумот во Carbon
            $date = Carbon::createFromFormat('Y-m-d', $date);


        // Најди ја неделата според датумот
        $startOfWeek = $date->startOfWeek()->format('Y-m-d'); // Понеделник
        $endOfWeek = $date->endOfWeek()->format('Y-m-d'); // Недела
        $year = $date->year; // Година од датумот

        // Земаме неработни денови од базата
        $holidays = Calendar::join('calendar_countries', 'calendar.id', '=', 'calendar_countries.id_calendar')
            ->where('calendar_countries.id_country', $id_country)
            ->whereBetween('calendar.date', [$startOfWeek, $endOfWeek]) // Само датумите во таа недела
            ->pluck('calendar.date') // Земаме само листа на датуми
            ->toArray(); // Конвертираме во низа

        // Форматирање на излезот
        $formattedHolidays = [];
        foreach ($holidays as $holiday) {
            $dayName = Carbon::parse($holiday)->format('D'); // Mon, Tue, Wed...
            $formattedHolidays[$dayName] = Carbon::parse($holiday)->format('Y-m-d'); // YYYY-MM-DD
        }

        return $formattedHolidays;
    }


    public function getRecordById($id)
    {
        $return= Records::with([
            'countries',
            'assignments',
            'activities',
            'projects',
            'insertedByUser',
            'updatedByUser',
            'approvedByUser',
            'calendar'
        ])
            ->leftJoin('calendar', DB::raw('DATE(records.date)'), '=', DB::raw('DATE(calendar.date)'))
            ->where('records.id', $id)
            ->select('records.*', 'calendar.lock_')
            ->first();



       // dd($return);
        return $return;
    }


    public function getYears()
    {
        return Calendar::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->isNotEmpty() ? Calendar::select('year')->distinct()->orderBy('year', 'desc')->pluck('year') : null;
    }

    public function isYearLocked($params): int
    {
        $year = $params['year'] ?? date('Y');
        $records = Calendar::select('date', 'lock_')
            ->where('year', $year)
            ->get();

        return $records->min('lock_') == 1 ? 1 : 0;
    }
    public function getLockedDaysInYear($year): array
    {
        return Calendar::where('year', $year)->where('lock_', 1)->pluck('date')->toArray();
    }
    public function lastEnteredYear()
    {
        return Calendar::max('year');
    }

    public function getUserById($id_user)
    {
        $user = Users::with('countries')->where('id', $id_user)->first();
        if ($user) {
            return $user;
        }
        return null;
    }

    public function getAssignCountries($id_user)
    {
        $user  = Users::find($id_user);
        if (!$user) {
            return null;
        }
        return $user->countries;
    }
    public function getRecordsDay($date, $id_user,$id_country): \Illuminate\Database\Eloquent\Collection
    {
        return Records::with([
            'activities',
            'assignments',
            'projects.assignments',  // Вчитај assignments поврзани со проектите
            'projects.activities'    // Вчитај activities поврзани со проектите
        ])
            ->whereDate('date', $date)
            ->where('insertedby', $id_user)
            ->where('id_country', $id_country)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function isHoliday($date, $id_country): int
    {
        $isHoliday = DB::table('calendar')
            ->join('calendar_countries', function ($join) use ($id_country) {
                $join->on('calendar.id', '=', 'calendar_countries.id_calendar')
                    ->where('calendar_countries.id_country', '=', $id_country)
                    ->where('calendar_countries.active', 1)
                    ->where('calendar_countries.deleted', 0);
            })
            ->whereDate('calendar.date', $date)
            ->exists();

        return $isHoliday ? 1 : 0; // Враќа 1 ако денот е неработен, 0 ако е работен
    }


    public function showRecordsDay($date, $id_user,$id_country): \Illuminate\Database\Eloquent\Collection
    {
        //dd($id_country);
        return Records::with([
            'activities',
            'assignments',
            'projects',
        ])
            ->leftJoin('calendar', DB::raw('DATE(records.date)'), '=', DB::raw('DATE(calendar.date)'))
            ->whereDate('records.date', $date)
            ->where('insertedby', $id_user)
            ->where('id_country', $id_country)
            ->select('records.*', 'calendar.lock_')
            ->orderBy('records.id', 'desc')
            ->get();

    }

    public function deleteRecordsDay($date, $id_country, $id_user): bool
    {
        //dd($date);
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');

        // Бришење на записите според условите
        return Records::whereDate('date', $formattedDate)
            ->where('id_country', $id_country)
            ->where('insertedby', $id_user)
            ->where('lockrecord', 0)
            ->delete();
    }
    public function deleteRecordsWeek($date, $id_country, $id_user): bool
    {
        // Форматирај го внесениот датум
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');

        // Пресметај го почетокот на неделата (6 дена пред дадениот датум)
        $startDate = Carbon::createFromFormat('Y-m-d', $date)->subDays(6)->format('Y-m-d');

        // Бришење на записите според условите
        return Records::whereBetween('date', [$startDate, $formattedDate])
            ->where('id_country', $id_country)
            ->where('insertedby', $id_user)
            ->where('lockrecord', 0)
            ->delete();
    }

    public function getRecordsTableByIdUser($id_user, $params): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $year = $params['year'] ?? date('Y');
        $month = $params['month'] ?? date('m');
        //$month = intval($month);
//dd($month);
        $records = Records::with('activities', 'assignments', 'projects', 'countries')
            ->leftJoin('calendar', function ($join) {
                $join->on(DB::raw('DATE(records.date)'), '=', DB::raw('DATE(calendar.date)'));
            })
            ->select('records.*', 'calendar.lock_ as locket_year')
            ->where('insertedby', $id_user)
            ->where('deleted', 0);

        // Филтрирање по држава (ако е различно од 'all')
        if (isset($params['id_country']) && $params['id_country'] !== 'all') {
            $records->where('records.id_country', '=', $params['id_country']);
        }

        // Филтрирање по година (секогаш се бара одредена година)
        $records->where('records.year', '=', $year);

        // Филтрирање по месец (ако month не е 'all')
        if ($month !== 'all') {

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

        // Пагинација и броење
        $listing = config('records.pagination_records');
        if (isset($params['listing'])) {
            $listing = $params['listing'] == 'a' ? $records->count() : $params['listing'];
        }

        // Сортирање
        if (!isset($params['sort']) && !isset($params['order'])) {
            $records->orderBy('records.id', 'DESC');
        } else {
            $allowedColumns = ['id', 'date', 'year'];
            $orderBy = in_array($params['order'] ?? 'id', $allowedColumns) ? $params['order'] : 'id';
            $sort = in_array(strtolower($params['sort'] ?? 'desc'), ['asc', 'desc']) ? $params['sort'] : 'desc';
            $records->orderBy($orderBy, $sort);
        }

        return $records->paginate($listing);
    }








    public function showRecordsWeek($date, $id_user, $id_country): \Illuminate\Database\Eloquent\Collection
    {
        // Пресметка на датумот на крајот на неделата (недела)
        $selectedDate = Carbon::createFromFormat('Y-m-d', $date);

        // Пресметка на почетокот на неделата (понеделник)
        $startOfWeek = $selectedDate->copy()->startOfWeek(Carbon::MONDAY);

        // Пресметка на крајот на неделата (недела)
        $endOfWeek = $selectedDate->copy()->endOfWeek(Carbon::SUNDAY);

        // Превземи ги записите што се наоѓаат во таа недела (од понеделник до недела)
        $return= Records::with([
            'activities',
            'assignments',
            'projects',
        ])
            ->leftJoin('calendar', function ($join) {
                $join->on(DB::raw('DATE(records.date)'), '=', DB::raw('DATE(calendar.date)'));
            })
            ->whereBetween(DB::raw('DATE(records.date)'), [$startOfWeek->toDateString(), $endOfWeek->toDateString()])


            ->where('insertedby', $id_user)
            ->where('id_country', $id_country)
            ->orderBy('records.date', 'desc')
            ->select('records.*', 'calendar.lock_')

            //dd($return->toSql(), $return->getBindings());
            ->get();
//dd($startOfWeek.'/ / '.$endOfWeek);
        //dd($return);
        return $return;
    }


    public function getAllProjects($date)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $startOfWeek = $date->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $formattedDate = $date->format('Y-m-d');

        return Projects::where(function ($query) use ($formattedDate, $startOfWeek) {
            $query->where('end_date', '>', $formattedDate)  // Проекти што сè уште не се завршени
            ->orWhereBetween('end_date', [$startOfWeek, $formattedDate]);  // Проекти што завршиле во тековната недела
        })
//            ->where('active', 1)
            ->where('deleted', 0)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getAllProjectsTable($year)
    {
        $startOfYear = Carbon::createFromFormat('Y', $year)->startOfYear()->format('Y-m-d');
        $endOfYear = Carbon::createFromFormat('Y', $year)->endOfYear()->format('Y-m-d');

        return Projects::where('deleted', 0)
            ->where(function ($query) use ($startOfYear, $endOfYear) {
                $query->where('end_date', '>=', $startOfYear)
                    ->orWhereNull('end_date');  // Проектите без end_date се сметаат за активни
            })
            ->orderBy('name', 'ASC')
            ->get();
    }
    public function getActivities($id_project)
    {
        $project = Projects::with('activities')->orderBy('name', 'ASC')->find($id_project);
        return $project ? $project->activities : collect();
    }
    public function getAssignments($id_project)
    {
        return Assignments::where('project', '=', $id_project)->orderBy('name', 'ASC')->get();
    }



    public function getAllCountries()
    {
        $countries = Countries::where('active', '=', '1')->get();;
        if ($countries) {
            return $countries;
        }
        return null;
    }

}
