<?php

namespace Modules\Public\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicRegisterUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'=>'required',
            'surname'=>'required',
            'phone'=>'required',
            'edb'=>'required',
            'email'=>'required|email|unique:users,email,deleted,0'
        ];

        return $rules;
    }
    public function messages(): array
    {
        $messages= [
            'name.required' => __('global.required', ['name' => __('public.name')]),
            'surname.required' => __('global.required', ['name' => __('public.surname')]),
            'phone.required' => __('global.required', ['name' => __('public.phone')]),
            'edb.required' => __('global.required', ['name' => __('public.edb')]),
            'email.required' => __('global.required', ['name' => __('public.email')]),
            'email.email' => __('global.email', ['name' => __('public.email')]),
            'email.unique' => __('global.unique', ['name' => __('public.email')]),
        ];

        return $messages;
    }

}
