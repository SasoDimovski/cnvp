<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthLoggedMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        // Проверуваме ако корисникот е логирани
        if (Auth::check()) {
            // Пренасочуваме кон dashboard или друга страница за логирани корисници
            //return redirect()->route('admin/'.App::getLocale().'/main'); // Променете ја според вашата рута
            return redirect()->route('main', ['lang' => App::getLocale()]);
        }

        return $next($request);
    }
}
