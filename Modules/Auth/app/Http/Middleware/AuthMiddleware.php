<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
class AuthMiddleware extends Middleware
{

    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {return 'admin';}
        return null;
    }
}
