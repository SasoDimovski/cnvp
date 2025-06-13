<?php

namespace Modules\Main\Repositories;

use App\Models\Languages;

class MainRepositories
{
    public function getAllLanguages()
    {
        return Languages::where('active', '=', '1')->get();;
    }

    public function getLanguagesByLang($lang)
    {
        return Languages::where('lang', '=', $lang)->first();
    }
}
