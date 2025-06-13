<?php

namespace Modules\Projects\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectsAssignmentsStoreRequest extends FormRequest
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
            //'start_date' => 'required|date_format:d.m.Y H:i:s', // Додадено правило за формат
           // 'end_date' => 'required|date_format:d.m.Y H:i:s', // Додадено правило за формат
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('global.required', ['name' => __('projects.assignments_title')]),
            'code.required' => __('global.required', ['name' => __('projects.code')]),
            //'start_date.required' => __('global.required', ['name' => __('projects.start_date')]),
            //'start_date.date_format' => __('global.invalid_date_format', ['name' => __('projects.start_date')]),
            //'end_date.required' => __('global.required', ['name' => __('projects.end_date')]),
            //'end_date.date_format' => __('global.invalid_date_format', ['name' => __('projects.end_date')]),
        ];
    }
}
