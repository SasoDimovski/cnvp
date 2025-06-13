<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

//            'hash' => 'required|exists:users,password_reset_hash',
            'new-password'=>'required|min:8',
            'confirm-password'=>'required|same:new-password',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {

        return [
//            'hash.required' => __('global.required', ['name' => __('auth.reset.hash')]),
            'new-password.required' => __('global.required', ['name' => __('auth.registration.password')]),
            'confirm-password.required' => __('global.required', ['name' => __('auth.registration.confirm_password')]),

//            'hash.exists' => __('auth.exists', ['attribute' => __('auth.reset.hash')]),
            'new-password.min' => __('auth.request.min.string', ['attribute' => __('auth.registration.password')]),
            'confirm-password.same' => __('auth.request.same', ['attribute' => __('auth.registration.password'), 'other' => __('auth.registration.confirm_password')]),
        ];
    }
}
