<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Dto\UserDto;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Services\UserServices;

class UserController
{
    public function __construct(public UserServices $userServices, private UserDto $userDto)
    {
    }

    public function update($lang, $id_module, $id, UserUpdateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url = "admin/{$lang}/{$id_module}/users/edit/{$id}";

        $userDTO = $this->userDto->fromRequest($request);
        $ret = $this->userServices->update($lang, $id_module, $id, $userDTO);

        return $ret;

        /*
         {
            "status": "success",
            "message": "Success"
            "user": {...}
        }

        {
            "status": "error",
            "message": "Porakata za errorot"
            "reason": "user_does_not_exist"
        }
         *
         */
    }
}
