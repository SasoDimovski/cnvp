<?php

namespace Modules\Countries\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountriesUpdateRequest extends FormRequest
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
            'name.required' => __('global.required', ['name' => __('countries.name')]),

        ];
    }

}
