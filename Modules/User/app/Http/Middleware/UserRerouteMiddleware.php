<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserServices;

class UserRerouteMiddleware
{
    public function __construct(public UserServices $modulesServices)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $id_user = Auth::id();
        $id_module = $request->route('id_module');
        $lang = $request->route('lang');
        //dd($id_user);
        return redirect()->route('edit.user', ['id' => $id_user,'lang' => $lang,'id_module' => $id_module]);
        // Ако има пристап, продолжи со следниот middleware или контролер
        //return $next($request);
    }
}
