<?php

namespace Modules\Languages\Services;

use Modules\Languages\Repositories\LanguagesRepositories;
class LanguagesServices
{
    public function __construct(public LanguagesRepositories $languagesRepository)
    {
    }
    public function getAllLanguages() {
        return $this->languagesRepository->getAllLanguages();
    }
}
