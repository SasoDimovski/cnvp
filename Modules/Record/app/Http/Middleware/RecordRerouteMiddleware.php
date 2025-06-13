<?php

namespace Modules\Record\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Record\Services\RecordServices;

class RecordRerouteMiddleware
{
    public function __construct(public RecordServices $recordServices)
    {
    }

    public function handle(Request $request, Closure $next): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::id();
        $id_module = $request->route('id_module');
        $lang = $request->route('lang');
        $record=$this->recordServices->getRecordByIdUser($id_user);
        //dd($record->id);
        return redirect()->route('edit.record', ['id' => $record->id,'lang' => $lang,'id_module' => $id_module]);
        // Ако има пристап, продолжи со следниот middleware или контролер
        //return $next($request);
    }
}
