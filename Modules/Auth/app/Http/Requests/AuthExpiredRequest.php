<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthExpiredRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

//            'hash' => 'required|exists:users,password_reset_hash',
            'password'=>'required',
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
            'password.required' => __('global.required', ['name' => __('auth.expired.old_password')]),
            'new-password.required' => __('global.required', ['name' => __('auth.expired.new_password')]),
            'confirm-password.required' => __('global.required', ['name' => __('auth.expired.confirm_new_password')]),

//            'hash.exists' => __('auth.exists', ['attribute' => __('auth.reset.hash')]),
            'new-password.min' => __('auth.request.min.string', ['attribute' => __('auth.expired.new_password')]),
            'confirm-password.same' => __('auth.request.same', ['attribute' => __('auth.expired.new_password'), 'other' => __('auth.expired.confirm_new_password')]),
        ];
    }
}
