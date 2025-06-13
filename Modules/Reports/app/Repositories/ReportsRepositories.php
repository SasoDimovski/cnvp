<?php

namespace Modules\Reports\Repositories;

use App\Models\Activities;
use App\Models\Assignments;
use App\Models\Calendar;
use App\Models\Countries;

use App\Models\Languages;
use App\Models\Projects;
use App\Models\Records;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ServicesAssignedModules;

class ReportsRepositories
{
    public function getAllRecordsDetail($params): array
    {
        // Провери дали има барем еден валиден параметар за пребарување
        $hasFilters = false;

        $searchableKeys = [
            'id_user',
            'name',
            'id_country',
            'id_project',
            'id_assignment',
            'id_activity',
            'year',
            'month',
            'date_from',
            'date_to'
        ];

        foreach ($searchableKeys as $key) {
            if (isset($params[$key]) && $params[$key] !== null && $params[$key] !== '' && $params[$key] !== 'all') {
                $hasFilters = true;
                break;
            }
        }

        // Ако нема зададени параметри, врати празен резултат
        if (!$hasFilters) {
            return [
                'records' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                'users' => collect([]) // Враќаме празна колекција наместо `null`
            ];
        }

        // Иницијализација на query со врски на модели
        $query = Records::with('activities', 'assignments', 'projects', 'countries', 'insertedByUser')
            ->where('records.deleted', 0);

        $queryWithoutProjectFilter = clone $query;
        $queryWithoutProjectFilter->whereHas('activities', function ($query) {
            $query->where('type', 0);
        });


        // Мапирање на параметрите за филтрирање
        $filters = [
            'id_user' => 'records.insertedby',
            'name' => 'users.name',
            'id_country' => 'records.id_country', // Поправено
            'id_assignment' => 'records.assignment',
            'id_activity' => 'records.activity',
            'year' => 'records.year',
        ];

        foreach ($filters as $paramKey => $dbColumn) {
            if (isset($params[$paramKey]) && $params[$paramKey] !== 'all') {
                $query->where($dbColumn, $params[$paramKey]);
                $queryWithoutProjectFilter->where($dbColumn, $params[$paramKey]);
            }
        }

        if (!empty($params['id_project']) && $params['id_project'] !== 'all') {
                $query->whereIn('records.project', $params['id_project']);
        }


        // Филтрирање по месец
        if (isset($params['month']) && $params['month'] !== 'all') {
            $query->whereRaw('MONTH(date) = ?', [$params['month']]);
            $queryWithoutProjectFilter->whereRaw('MONTH(date) = ?', [$params['month']]);
        }

        // Филтрирање по опсег на датуми
        if (isset($params['date_from']) || isset($params['date_to'])) {
            $dateFrom = isset($params['date_from']) ? Carbon::createFromFormat('d.m.Y', $params['date_from'])->format('Y-m-d') : null;
            $dateTo = isset($params['date_to']) ? Carbon::createFromFormat('d.m.Y', $params['date_to'])->format('Y-m-d') : null;

            if ($dateFrom && $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo]);
                $queryWithoutProjectFilter->whereBetween('date', [$dateFrom, $dateTo]);
            } elseif ($dateFrom) {
                $query->where('date', '>=', $dateFrom);
                $queryWithoutProjectFilter->where('date', '>=', $dateFrom);
            } elseif ($dateTo) {
                $query->where('date', '<=', $dateTo);
                $queryWithoutProjectFilter->where('date', '<=', $dateTo);
            }
        }

        $totalDurationWithoutProjectFilter = $queryWithoutProjectFilter->sum('duration');

        // Пагинација и броење
        $listing = $params['listing'] ?? config('reports.pagination', 10);
        if ($listing === 'a') {
            $listing = $query->count(); // Врати го вкупниот број ако е 'a'
        }

        $sortColumn = 'records.date'; // Default колона за сортирање
        $sortOrder = 'asc'; // Default насока за сортирање


        // Сортирање
        if (isset($params['sort']) && isset($params['order'])) {

            $sortColumn = $params['order'];
            $sortOrder = strtolower($params['sort']);

            if ($sortColumn === 'name') {
                // Сортирање според `users.name`
                $query->join('users', 'records.insertedby', '=', 'users.id')
                    ->where('records.deleted', 0) // Специфицирајте ја табелата за колоната deleted
                    ->select('records.*') // Селектирај ги сите полиња од records
                  ;
                $sortColumn = 'users.name';
            }

        }

        $query->orderBy($sortColumn, $sortOrder);

        //dd($query->toSql(), $query->getBindings());
        $records=$query->paginate($listing);

        // Додадете филтрирање по типот на активност
        $queryType1 = clone $query;
        $queryType1->whereHas('activities', function ($query) {
            $query->where('type', 1); // Филтрирај ги само активностите со type = 1
        });

        // Изврши групирање по активност и сумирај duration
        $records_activities = $queryType1->get(); // Без пагинација за оваа операција

        // Групирај ги според активноста и сумирај duration
        $activityDurations = $records_activities->groupBy('activities.id')->map(function ($group) {
            return $group->sum('duration');
        });

        // Извлекување на почетната и крајната дата
        $date1 = $records->min('date'); // Почетна дата
        $date2 = $records->max('date'); // Крајна дата

        // Форматирање на датите во формат "d.m.Y"
        $date1 = $date1 ? Carbon::parse($date1)->format('d.m.Y') : null;
        $date2 = $date2 ? Carbon::parse($date2)->format('d.m.Y') : null;

        $users = $records->pluck('insertedByUser')->unique('id');
        $projects = $records->pluck('projects')->unique('id');
        $activities = $records_activities->pluck('activities')->unique('id');
        $approvedUsers = $records->whereNotNull('approvedby')->pluck('approvedByUser')->unique('id');

        // 🔹 **Филтрирање по type 0, но само за селектираните записи**
        $queryType0 = clone $query; // Правиме копија на оригиналниот query

        $queryType0->whereHas('activities', function ($query) {
            $query->where('activities.type', 0);
        });

        $records_type0 = $queryType0->get(); // Извршуваме query за селектираните записи со активности type 0

        // **Групирање по проекти и сумирање на durations**
        $projectDurations = $records_type0->groupBy('project')->map(function ($group) {
            return $group->sum('duration');
        });

        $allRecords = $query->get(); // Земи ги сите записи без пагинација

        if ($allRecords->every(fn($record) => !is_null($record->approvedby))) {
            $approvalStatus = 1; // Сите записи се одобрени
        } elseif ($allRecords->every(fn($record) => is_null($record->approvedby))) {
            $approvalStatus = 2; // Ниту еден запис не е одобрен
        } else {
            $approvalStatus = 0; // Мешано - некои се одобрени, некои не
        }
       // dd($projectDurations);





        return [
            'records' => $records,
            'users' => $users,
            'projects' => $projects,
            'date1' => $date1,
            'date2' => $date2,
            'activityDurations' => $activityDurations,
            'activities' => $activities,
            'projectDurations' => $projectDurations,
            'approvedUsers' => $approvedUsers,
            'approvalStatus' =>  $approvalStatus ,
            'totalDurationWithoutProjectFilter' => $totalDurationWithoutProjectFilter,
        ];
    }

    public function getAllUsers($lang)
    {
        $id_lang = Languages::where('lang', $lang)->value('id');

        $assignModules = (new \App\Services\ServicesAssignedModules)->getUserModuleIds(Auth::id(), $id_lang);
//dd($assignModules);
        // Основен query
        $query = Users::where('deleted', 0);

        // Ако корисникот има модул со ID 17, филтрирај го само него
        if (in_array(17, $assignModules)) {
            $query->where('id', Auth::id());
        }

        return $query->select([
            'id',
            'name',
            'surname',
            'username',
        ])->orderBy('name', 'ASC')->get();
    }
    public function getAllRecordsGroup($params):array
    {

        // Проверете дали има барем еден валиден параметар за пребарување
        $hasFilters = false;

        $searchableKeys = [
            'id_user',
            'id_country',
            'id_project',
            'id_assignment',
            'id_activity',
            'year',
            'month',
            'date_from',
            'date_to'
        ];

        foreach ($searchableKeys as $key) {
            if (isset($params[$key]) && $params[$key] !== null && $params[$key] !== '' && $params[$key] !== 'all') {
                $hasFilters = true;
                break;
            }
        }

        // Ако нема зададени параметри, врати празен резултат
        if (!$hasFilters) {
            return [
                'records' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
            ];
        }

        $query = Records::with('activities', 'assignments', 'projects', 'countries', 'insertedByUser')
            ->where('deleted', 0);

        $filters = [
            'id_user' => 'insertedby',
            'id_country' => 'records.id_country', // Поправено
            'id_assignment' => 'assignment',
            'id_activity' => 'activity',
            'year' => 'year',
        ];

        foreach ($filters as $paramKey => $dbColumn) {
            if (isset($params[$paramKey]) && $params[$paramKey] !== 'all') {
                $query->where($dbColumn, $params[$paramKey]);
            }
        }

        if (!empty($params['id_project']) && $params['id_project'] !== 'all') {
            $query->whereIn('records.project', $params['id_project']);
        }

        if (isset($params['month']) && $params['month'] !== 'all') {
            $query->whereRaw('MONTH(date) = ?', [$params['month']]);
        }

        if (isset($params['date_from']) || isset($params['date_to'])) {
            $dateFrom = isset($params['date_from']) ? Carbon::createFromFormat('d.m.Y', $params['date_from'])->format('Y-m-d') : null;
            $dateTo = isset($params['date_to']) ? Carbon::createFromFormat('d.m.Y', $params['date_to'])->format('Y-m-d') : null;

            if ($dateFrom && $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo]);
            } elseif ($dateFrom) {
                $query->where('date', '>=', $dateFrom);
            } elseif ($dateTo) {
                $query->where('date', '<=', $dateTo);
            }
        }

        $groupedResults = $query->get()->groupBy(function ($record) {
            return $record->activity . '|' . $record->assignment . '|' . $record->project . '|' . $record->id_country . '|' . $record->insertedby;
        });

        $processedResults = $groupedResults->map(function ($group) {
            $first = $group->first();

            return (object)[
                'id_country' => $first->id_country,
                'countries' => $first->countries,
                'insertedby' => $first->insertedby,
                'insertedByUser' => $first->insertedByUser,
                'activity' => $first->activity,
                'activities' => $first->activities,
                'assignment' => $first->assignment,
                'assignment_code' => $first->assignments->code ?? null,
                'assignments' => $first->assignments,
                'project' => $first->project,
                'projects' => $first->projects,
                'project_code' => $first->projects->code ?? null,
                'duration' => $group->sum('duration'),
                'year' => $group->pluck('year')->unique()->implode(', '),
                'date' => Carbon::parse($group->min('date'))->format('d.m.Y') . ' - ' . Carbon::parse($group->max('date'))->format('d.m.Y'),
            ];
        });

        if (isset($params['sort']) && isset($params['order'])) {
            $sortField = $params['order'];
            $sortDirection = strtolower($params['sort']) === 'desc' ? SORT_DESC : SORT_ASC;

            $processedResults = $processedResults->sortBy(function ($record) use ($sortField) {
                // Специјален случај за сортирање по име на корисник
                if ($sortField === 'name' && isset($record->insertedByUser)) {
                    return $record->insertedByUser->name ?? null;
                }
                if ($sortField === 'id_country' && isset($record->countries)) {
                    return $record->countries->name ?? null; // Сортирање по `name` на земјата
                }
                // Сортирање по обични полиња
                return $record->{$sortField} ?? null;
            }, SORT_REGULAR, $sortDirection === SORT_DESC);
        } else {
            // Дефолт сортирање по `duration` во опаѓачки редослед
            $processedResults = $processedResults->sortByDesc('duration');
        }


        // Пагинација и броење
        $perPage = $params['listing'] ?? config('reports.pagination', 10);
        if ($perPage === 'a') {
            $perPage = $query->count(); // Врати го вкупниот број ако е 'a'
        }


        // Pagination logic
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedResults = new LengthAwarePaginator(
            $processedResults->forPage($currentPage, $perPage)->values(),
            $processedResults->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return [
            'records' => $paginatedResults,  // Return the paginated results here
        ];
    }

    public function getAllProjects()
    {
        return Projects::where('deleted', 0)
            ->orderBy('name', 'ASC')
            ->select(['id', 'name', 'code'])
            ->get();
    }

    public function getAllCountries()
    {
        return Countries::where('deleted', 0)
            ->orderBy('name', 'ASC')
            ->select(['id', 'name'])
            ->get();
    }

    public function getAllAssignments(): \Illuminate\Database\Eloquent\Collection
    {

    return Assignments::with('projects:id,name') // Вчитуваме само потребни полиња
    ->where('deleted', 0)
        ->orderBy('name', 'ASC')
        ->get();
    }

    public function getYears()
    {
        return Calendar::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->isNotEmpty() ? Calendar::select('year')->distinct()->orderBy('year', 'desc')->pluck('year') : null;
    }

    public function getAllActivities()
    {
        return Activities::where('deleted', 0)
            ->orderBy('name', 'ASC')
            ->select(['id', 'name'])
            ->get();
    }


    public function getReportsDay($date, $id_user,$id_country): \Illuminate\Database\Eloquent\Collection
    {
        return Reports::with([
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

    public function getReportsWeekGroup($date, $id_user, $id_country): \Illuminate\Support\Collection
    {

        // Пресметка на датумот на крајот на неделата (недела)
        $selectedDate = Carbon::createFromFormat('Y-m-d', $date);

        // Пресметка на почетокот на неделата (понеделник)
        $startOfWeek = $selectedDate->copy()->startOfWeek(Carbon::MONDAY);

        // Пресметка на крајот на неделата (недела)
        $endOfWeek = $selectedDate->copy()->endOfWeek(Carbon::SUNDAY);

        $records = Reports::with([
            'activities',
            'assignments',
            'projects.assignments',
            'projects.activities'
        ])
            ->whereNotNull('id_group')
            ->where('insertedby', $id_user)
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->where('id_country', $id_country)
            ->orderBy('id', 'desc')
            ->get();

        $groupedReports = $records->groupBy(function ($record) {
            return ($record->note ?? 'no_note') . '_' .
                ($record->project ?? 'no_project') . '_' .
                ($record->activity ?? 'no_activity') . '_' .
                ($record->assignment ?? 'no_assignment') . '_' .
                ($record->id_group ?? 'no_group');
        });

        $result = $groupedReports->map(function ($group) {
            $firstRecord = $group->first();

            $dates = $group->pluck('date')->values()->all();
            $durations = $group->pluck('duration')->values()->all();

            // Комбинирајте ги датумите и времетраењата
            $dateDurations = [];
            for ($i = 0; $i < 7; $i++) {
                $dateDurations[] = [
                    'date' => $dates[$i] ?? null,
                    'duration' => $durations[$i] ?? null,
                ];
            }
            return [
                'note' => $firstRecord->note,
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


    public function showReportsDay($date, $id_user,$id_country): \Illuminate\Database\Eloquent\Collection
    {
        //dd($id_country);
        return Reports::with([
            'activities',
            'assignments',
            'projects',
        ])
            ->whereDate('date', $date)
            ->where('insertedby', $id_user)
            ->where('id_country', $id_country)
            ->orderBy('id', 'desc')
            ->get();

    }

    public function deleteReportsDay($date, $id_country, $id_user): bool
    {
        //dd($date);
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');

        // Бришење на записите според условите
        return Reports::whereDate('date', $formattedDate)
            ->where('id_country', $id_country)
            ->where('insertedby', $id_user)
            ->where('lockrecord', 0)
            ->delete();
    }
    public function deleteReportsWeek($date, $id_country, $id_user): bool
    {
        // Форматирај го внесениот датум
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');

        // Пресметај го почетокот на неделата (6 дена пред дадениот датум)
        $startDate = Carbon::createFromFormat('Y-m-d', $date)->subDays(6)->format('Y-m-d');

        // Бришење на записите според условите
        return Reports::whereBetween('date', [$startDate, $formattedDate])
            ->where('id_country', $id_country)
            ->where('insertedby', $id_user)
            ->where('lockrecord', 0)
            ->delete();
    }

    public function getReportsTableByIdUser($id_user, $params): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $year = $params['year'] ?? date('Y');
        $month = $params['month'] ?? date('m');

        $records = Reports::with('activities', 'assignments', 'projects', 'countries')
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
        if (isset($params['month']) && $params['month'] !== 'all') {
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








    public function showReportsWeek($date, $id_user, $id_country): \Illuminate\Database\Eloquent\Collection
    {
        // Пресметка на датумот на крајот на неделата (недела)
        $selectedDate = Carbon::createFromFormat('Y-m-d', $date);

        // Пресметка на почетокот на неделата (понеделник)
        $startOfWeek = $selectedDate->copy()->startOfWeek(Carbon::MONDAY);

        // Пресметка на крајот на неделата (недела)
        $endOfWeek = $selectedDate->copy()->endOfWeek(Carbon::SUNDAY);

        // Превземи ги записите што се наоѓаат во таа недела (од понеделник до недела)
        return Reports::with([
            'activities',
            'assignments',
            'projects',
        ])
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->where('insertedby', $id_user)
            ->where('id_country', $id_country)
            ->orderBy('date', 'desc')
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






}
