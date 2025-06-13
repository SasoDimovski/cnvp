<?php

namespace App\Http\Middleware\SharedView;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\Modules\Services\ModulesServices;
use Symfony\Component\HttpFoundation\Response;

class SharedViewModuleMiddleware
{
    public function __construct(public ModulesServices $modulesServices)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {

        $id_module = $request->route('id_module');
        $module = $this->modulesServices->getModulesById($id_module);
        View::share('module', $module);
        return $next($request);
    }
}
