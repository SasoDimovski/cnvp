<?php

namespace Modules\Record\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Record\Services\RecordServices;

class RecordUnauthorizedMiddleware
{
    public function __construct(public RecordServices $recordServices)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $id_record = $request->route('id');

        $id_user=$this->recordServices->getRecordById($id_record)->id_user;
        //dd($id_user);
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
