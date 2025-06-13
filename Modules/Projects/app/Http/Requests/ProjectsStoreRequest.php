<?php

namespace Modules\Projects\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectsStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => 'required',
            'code' => 'required',
            'activities' => 'required|array', // Проверете дали `activities` е низа
            'activities.*' => 'exists:activities,id', // Проверете секој елемент во масивот дали постои во табелата `activities`
            'start_date' => 'required|date_format:d.m.Y H:i:s', // Додадено правило за формат
            'end_date' => 'required|date_format:d.m.Y H:i:s', // Додадено правило за формат

        ];
    }

    public function messages(): array
    {

        return [
            'name.required' => __('global.required', ['name' => __('projects.name')]),
            'code.required' => __('global.required', ['name' => __('projects.code')]),
            'activities.required' => __('global.required', ['name' => __('projects.activities')]),
            'activities.array' => __('global.invalid_array', ['name' => __('projects.activities')]),
            'activities.*.exists' => __('global.no_records_in_db', ['name' => __('projects.activities')]),
            'start_date.required' => __('global.required', ['name' => __('projects.start_date')]),
            'start_date.date_format' => __('global.invalid_date_format', ['name' => __('projects.start_date')]),
            'end_date.required' => __('global.required', ['name' => __('projects.end_date')]),
            'end_date.date_format' => __('global.invalid_date_format', ['name' => __('projects.end_date')]),

        ];
    }
}
