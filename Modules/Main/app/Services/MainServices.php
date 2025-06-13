<?php

namespace Modules\Main\Services;

use Modules\Main\Repositories\MainRepositories;
class MainServices
{
    private MainRepositories $mainRepositories;

    public function __construct(MainRepositories $mainRepositories)
    {
        $this->mainRepositories = $mainRepositories;
    }

    public function getAllLanguages() {
        return $this->mainRepositories->getAllLanguages();
    }
    public function getLanguagesByLang($lang)
    {
        if($lang) {
            return $this->mainRepositories->getLanguagesByLang($lang);
        }
        return null;
    }
}
