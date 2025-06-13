<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\Dto\UserDto;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Services\UserServices;

class UserController extends Controller
{

    public function __construct(public UserServices $userServices, private readonly UserDto $userDto)
    {
    }

    public function edit($lang, $id_module, $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $return = $this->userServices->edit($lang, $id_module, $id);
        return view('User::user/edit', $return['data']);
    }

    public function update($lang, $id_module, $id, UserUpdateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $url_return= $request->get('url_return') ;
        $query= $request->get('query') ;
        $message_error= $request->get('message_error') ;
        $message_success= $request->get('message_success') ;

        $userDTO = $this->userDto->fromRequest($request);
        $return = $this->userServices->update($request->get('id_country'),$id, $request->get('file_name_hidden'), $userDTO);

        if($return->status=='error'){
            return redirect(url($url_return).'?'.$query)->with('error', [$message_error, $return->method, $return->class]);
        }
        return redirect(url($url_return).'?'.$query)->with('success', $message_success);
    }

}
