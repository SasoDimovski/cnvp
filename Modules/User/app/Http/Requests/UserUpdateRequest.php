<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name.required' => __('global.required', ['name' => __('user.name')]),
            'surname.required' => __('global.required', ['name' => __('user.surname')]),
            'id_expiration_time.required' => __('global.required', ['name' => __('user.id_expiration_time_des')]),
            'user_type.required' => __('global.required', ['name' => __('user.user_type')]),
            'email.required' => __('global.required', ['name' => __('user.email')]),
            'email.email' => __('user.email', ['name' => __('user.email')]),
            'email.unique' => __('global.unique', ['name' => __('user.email')]),
            'username.required' => __('global.required', ['name' => __('user.username')]),
            'username.unique' => __('global.unique', ['name' => __('user.username')]),
        ];

        if(!empty($password) || !empty($confirmPassword)) {
            $messages['password.required'] = __('global.required', ['name' => __('user.password')]);
            $messages['confirm-password'] = __('global.required', ['name' => __('user.password_confirm')]);
            $messages['password.min'] = __('user.UsersUpdateRequest.min_string', ['attribute' => __('user.password')]);
            $messages['confirm-password.same'] = __('user.UsersUpdateRequest.same_string', ['attribute' => __('user.password'), 'other' => __('user.password_confirm')]);
        }
        return $messages;
    }

}
