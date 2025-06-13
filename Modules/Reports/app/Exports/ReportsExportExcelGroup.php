<?php

namespace Modules\Reports\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExportExcelGroup implements FromCollection, WithHeadings
{
    protected Collection $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }
    public function collection(): Collection
    {
        return $this->records->map(function ($record) {
            return [
//                __('reports.id') => $record->id,
                __('reports.id_user') => $record->insertedByUser->name .' '. $record->insertedByUser->surname,
                __('reports.id_country') => $record->countries->name,
                __('reports.year') => $record->year,
                __('reports.date')=> $record->date,
                __('reports.project') => $record->projects->name,
                __('reports.projects_code') => $record->projects->code,
                __('reports.assignment') => $record->assignments->name??'n/a',
                __('reports.assignments_code') => $record->assignments->code??'n/a',
                __('reports.activity') => $record->activities->name??'n/a',
                __('reports.duration') => $record->duration,
//                __('reports.record') => $record->lockrecord,
//                __('reports.approved') => $record->approvedby,
            ];
        });
    }

    public function headings(): array
    {
        return [
//            __('reports.id'),
            __('reports.id_user'),
            __('reports.id_country'),
            __('reports.year'),
            __('reports.date'),
            __('reports.project'),
            __('reports.projects_code'),
            __('reports.assignment'),
            __('reports.assignments_code'),
            __('reports.activity'),
            __('reports.duration'),
//            __('reports.record'),
//            __('reports.approved')
        ];
    }
}
