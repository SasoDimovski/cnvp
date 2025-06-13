<?php

namespace Modules\Activities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivitiesStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('global.required', ['name' => __('activities.name')]),

        ];
    }

}
