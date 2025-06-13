<?php

namespace Modules\Languages\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->segment(2);
        if(!empty($lang)) {
            App::setLocale($lang);;
        }
        return $next($request);
    }
}
