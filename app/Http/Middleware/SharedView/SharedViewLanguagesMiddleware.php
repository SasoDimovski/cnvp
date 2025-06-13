<?php

namespace App\Http\Middleware\SharedView;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\Languages\Services\LanguagesServices;
use Symfony\Component\HttpFoundation\Response;

class SharedViewLanguagesMiddleware
{
    public function __construct(public LanguagesServices $languagesServices)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $languages=$this->languagesServices->getAllLanguages();
        View::share('languages', $languages);
        return $next($request);
    }
}
