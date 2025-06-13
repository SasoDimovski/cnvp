<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ControllerClearCache extends Controller
{
    public function clear(): void
    {
        Artisan::call('config:clear');
        echo ('<b>config:clear</b>, cleared cache for all config files!<br>');

        Artisan::call('route:clear');
        echo ('<b>route:clear</b>, cleared routes!<br>');

        Artisan::call('view:clear');
        echo ('<b>view:clear</b>, cleared views!<br>');

        Artisan::call('event:clear');
        echo ('<b>event:clear</b>, cleared events!<br>');

        Artisan::call('optimize:clear');
        echo ('<b>optimize:clear</b>, Compiled views cleared!; Application cache cleared!; Route cache cleared!; Configuration cache cleared!; Compiled services and packages files removed!; Caches cleared successfully!');

    }
    public function cache(): void
    {
        Artisan::call('config:cache');
        echo ('<b>config:cache</b>, all config files cached!<br>');

        Artisan::call('route:cache');
        echo ('<b>route:cache</b>, routes cached!<br>');

        Artisan::call('view:cache');
        echo ('<b>view:cache</b>, views cached!<br>');

        Artisan::call('event:cache');
        echo ('<b>event:cache</b>, events cached!<br>');

        Artisan::call('optimize');
        echo ('<b>optimize</b>, everything cached!<br>');
    }
}
