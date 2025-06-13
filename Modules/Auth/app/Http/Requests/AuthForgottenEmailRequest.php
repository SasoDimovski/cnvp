<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthForgottenEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            'email' => 'required|email|exists:users,email,deleted,0'

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
            'email.required' => __('global.required', ['name' => __('auth.forgotten.email')]),
            'email.email' => __('auth.AuthForgottenEmailRequest.email_valid', ['attribute' => __('auth.forgotten.email')]),
            'email.exists' => __('auth.AuthForgottenEmailRequest.email_no_exist', ['attribute' => __('auth.forgotten.email')]),
        ];
    }
}
