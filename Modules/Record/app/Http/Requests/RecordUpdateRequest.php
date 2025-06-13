<?php

namespace Modules\Record\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordUpdateRequest extends FormRequest
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
        $rules = [
            'title'=>'required',
        ];
        return $rules;
    }

    public function messages(): array
    {
        $messages= [
            'title.required' => __('global.required', ['name' => __('record.title')]),
        ];
        return $messages;
    }

}
