<?php

namespace Modules\Countries\Repositories;

use App\Models\Calendar;
use App\Models\Countries;
use App\Models\Records;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Modules\Countries\Dto\CountriesDto;

class CountriesRepositories
{
    public function getAllCountries($params)
    {
        $query = Countries::where('deleted', 0)
            ->select([
                'id',
                'name',
                'code_s',
                'code_l',
                'deleted',
                'active',
                'created_at',
                'updated_at',
            ])
            ->withCount(['users', 'records']);  // Употреба на дефинирани релации

        // Филтрирање според параметри
        $filterableFields = ['id', 'name'];
        foreach ($filterableFields as $field) {
            if (!empty($params[$field])) {
                $query->where($field, 'like', '%' . $params[$field] . '%');
            }
        }

        // Pagination
        $listing = $params['listing'] ?? config('activities.pagination') ?? 15;
        if ($listing === 'a') {
            $listing = $query->count();
        }

        // Сортирање
        $sort = $params['sort'] ?? 'DESC';
        $order = $params['order'] ?? 'id';

        // Проверка дали е valid count колоната
        $validOrders = array_merge(['id', 'name', 'created_at', 'updated_at'], ['users_count', 'records_count']);
        if (in_array($order, ['users', 'records'])) {
            $order = $order . '_count';
        }
        $order = in_array($order, $validOrders) ? $order : 'id';

        $query->orderBy($order, $sort);

        return $query->paginate($listing)->appends($params);
    }

    public function storeCountry($countriesDto)
    {
        // Креирање на нова земја
        $country = Countries::create([
            'name' => $countriesDto->name,
            'code_s' => $countriesDto->code_s,
            'code_l' => $countriesDto->code_l,
            'deleted' => 0,
        ]);

        // Наоѓање на последната внесена година од calendar табелата
        $lastYear = Calendar::max('year');

        if ($lastYear) {
            // Пробавме сите викенди (sat, sun) за последната година
            $weekends = Calendar::where('year', $lastYear)
                ->whereIn('day', ['sat', 'sun'])
                ->pluck('id');

            // Проверка дали веќе постојат записи во calendar_countries
            $existingRecords = DB::table('calendar_countries')
                ->whereIn('id_calendar', $weekends)
                ->where('id_country', $country->id)
                ->pluck('id_calendar')
                ->toArray();

            // Филтрирање на викендите што НЕ постојат во calendar_countries
            $weekendsToInsert = $weekends->diff($existingRecords);

            if ($weekendsToInsert->isNotEmpty()) {
                $pivotData = [];

                foreach ($weekendsToInsert as $calendarId) {
                    $pivotData[] = [
                        'id_calendar' => $calendarId,
                        'id_country' => $country->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                // Внес во calendar_countries
                DB::table('calendar_countries')->insert($pivotData);
            }
        }

        return $country;
    }

    public function updateCountry($id, CountriesDto $data)
    {
        $country= Countries::where('id', '=', $id)->first();

        if($country) {
            $country->name = $data->name;
            $country->code_s = $data->code_s;
            $country->code_l = $data->code_l;

            if ($country->save()) {
                return $country;
            }
        }
        return null;
    }


    public function checkIfCountryExistInRecords($id): bool
    {
        return Records::where('id_country', $id)->count() > 0;
    }
    public function checkIfCountryExistInUsers($id): bool
    {
        return Countries::where('id', $id)->whereHas('users')->exists();
    }

    public function deleteCountry($id): bool
    {
        return DB::transaction(function () use ($id) {
            $country = Countries::find($id);

            if (!$country) {
                return false;  // Враќа false ако земјата не постои
            }

            // Прво бришење на записите од calendar_countries за таа земја
            DB::table('calendar_countries')
                ->where('id_country', $id)
                ->delete();

            // Потоа бришење на земјата
            return $country->delete();
        });
    }
    public function getCountryById($id)
    {
        return Countries::with('users')
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
