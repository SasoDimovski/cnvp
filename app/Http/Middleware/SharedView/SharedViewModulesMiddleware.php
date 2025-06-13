<?php

namespace App\Http\Middleware\SharedView;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Modules\Services\ModulesServices;
use Symfony\Component\HttpFoundation\Response;

class SharedViewModulesMiddleware
{
    public function __construct(public ModulesServices $modulesServices)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->route('lang');
        $id_language = $this->modulesServices->getLanguagesByLang($lang)->id;
        $modules = $this->modulesServices->getAllModulesByIdUser(Auth::user()->id,$id_language);

        View::share('assignedModules', $modules );
        return $next($request);
    }


}
