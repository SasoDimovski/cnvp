<?php

namespace Modules\Modules\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Modules\Services\ModulesServices;
use Symfony\Component\HttpFoundation\Response;

class ModulesPrivilegesMiddleware
{
    public function __construct(public ModulesServices $modulesServices)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        $moduleId = $request->route('id_module');
        $lang = $request->route('lang');
        $id_language = $this->modulesServices->getLanguagesByLang($lang)->id;
        // Провери дали корисникот има пристап до модулот
        $isAttached = $this->modulesServices->isUserModuleAreAttached($userId, $moduleId, $id_language);
        //dd($isAttached);

        if (!$isAttached) {
            // Ако нема пристап, врати грешка 403
            abort(403, 'Unauthorized access to the module.');
        }
        // Ако има пристап, продолжи со следниот middleware или контролер
        return $next($request);
    }
}
