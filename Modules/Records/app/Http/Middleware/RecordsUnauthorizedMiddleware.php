<?php

namespace Modules\Records\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Records\Services\RecordsServices;

class RecordsUnauthorizedMiddleware
{
    public function __construct(public RecordsServices $modulesServices)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $id_user = $request->route('id');
        if ($id_user != Auth::id()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin')->with('success', __('global.success_logout'));
            //abort(403, 'Unauthorized access to the module.');

        }
        // Ако има пристап, продолжи со следниот middleware или контролер
        return $next($request);
    }
}
