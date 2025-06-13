<?php

namespace Modules\Records\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordsStoreTableRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
//dd(__('records.projects'));
        $rules = [
            'id_project'=>'required',
            'id_assignment'=>'required',
            'id_activity'=>'required',
        ];
        return $rules;
    }

    public function messages(): array
    {
        $messages= [
            'id_project.required' => __('global.required', ['name' => __('records.projects')]),
            'id_assignment.required' => __('global.required', ['name' => __('records.assignments')]),
            'id_activity.required' => __('global.required', ['name' => __('records.activities')]),
        ];
        return $messages;
    }

}
