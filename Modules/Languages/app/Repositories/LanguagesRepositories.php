<?php

namespace Modules\Languages\Repositories;

use App\Models\Languages;

class LanguagesRepositories
{
    public function getAllLanguages()
    {
        return Languages::where('active', 1)
            ->where('deleted', 0)
            ->get();
    }
}
