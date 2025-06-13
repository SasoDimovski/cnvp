<?php

namespace Modules\Records\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Records\Services\RecordsServices;

class RecordsRerouteMiddleware
{
    public function __construct()
    {
    }

    public function handle(Request $request, Closure $next): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::id();
        $id_module = $request->route('id_module');
        $lang = $request->route('lang');
        //dd($id_user);
        return redirect()->route('records', ['id' => $id_user,'lang' => $lang,'id_module' => $id_module]);
        // Ако има пристап, продолжи со следниот middleware или контролер
        //return $next($request);
    }
}
