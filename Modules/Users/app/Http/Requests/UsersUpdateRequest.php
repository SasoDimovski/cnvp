<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
        $userId = request()->route('id');
        $password = request()->get('password');
        $confirmPassword = request()->get('confirm-password');

        $rules = [
            'name'=>'required',
            'surname'=>'required',
            'id_expiration_time'=>'required',
            'user_type'=>'required',
            'email'=>'required|email|unique:users,email,'.$userId.',id,deleted,0',
            'username'=>'required|unique:users,username,'.$userId.',id',
            'id_country' => ['required', 'array', 'min:1'],  // Проверува дали има барем еден елемент

        ];

        if(!empty($password) || !empty($confirmPassword)) {
            $rules['password'] = 'required|min:8';
            $rules['confirm-password'] = 'required|same:password';
        }

        return $rules;
    }

    public function messages(): array
    {

        $password = request()->get('password');
        $confirmPassword = request()->get('confirm-password');

        $messages= [
            'name.required' => __('global.required', ['name' => __('users.name')]),
            'surname.required' => __('global.required', ['name' => __('users.surname')]),
            'id_expiration_time.required' => __('global.required', ['name' => __('users.id_expiration_time_des')]),
            'user_type.required' => __('global.required', ['name' => __('users.user_type')]),
            'email.required' => __('global.required', ['name' => __('users.email')]),
            'email.email' => __('users.email', ['name' => __('users.email')]),
            'email.unique' => __('global.unique', ['name' => __('users.email')]),
            'username.required' => __('global.required', ['name' => __('users.username')]),
            'username.unique' => __('global.unique', ['name' => __('users.username')]),
            'id_country.required' => __('global.required', ['name' => __('users.id_country')]),
        ];

        if(!empty($password) || !empty($confirmPassword)) {
            $messages['password.required'] = __('global.required', ['name' => __('users.password')]);
            $messages['confirm-password'] = __('global.required', ['name' => __('users.password_confirm')]);
            $messages['password.min'] = __('users.UsersUpdateRequest.min_string', ['attribute' => __('users.password')]);
            $messages['confirm-password.same'] = __('users.UsersUpdateRequest.same_string', ['attribute' => __('users.password'), 'other' => __('users.password_confirm')]);
        }
        return $messages;
    }

}
