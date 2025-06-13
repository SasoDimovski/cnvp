<?php

namespace Modules\Modules\Repositories;

use App\Models\Languages;
use App\Models\Modules;
class ModulesRepositories
{
    public function getModulesById($id_module)
    {
        return Modules::with(['design', 'type'])->where('id', $id_module)->first();
    }
    public function getLanguagesByLang($lang)
    {
        return Languages::where('lang', $lang)->first();
    }

}
